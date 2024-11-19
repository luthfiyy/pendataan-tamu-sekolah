<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kurir;
use App\Models\Pegawai;
use App\Models\Ekspedisi;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Response;
use App\Mail\pegawaiMailKurir;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanKurirExport;
use App\Models\KedatanganEkspedisi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator; // Add this line


class KurirController extends Controller
{

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_kurir' => 'required|string|max:255',
            'ekspedisi' => 'required|string|max:255',
            'no_telp' => 'required|string|max:14',
            'foto_data' => 'required|string',
            'id_user' => 'required|exists:users,id',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Simpan informasi kurir ke database
        $ekspedisi = new Ekspedisi();
        $ekspedisi->nama_kurir = $request->input('nama_kurir');
        $ekspedisi->ekspedisi = $request->input('ekspedisi');
        $ekspedisi->no_telp = $request->input('no_telp');
        $ekspedisi->save();

        // Ambil id_user dari request
        $id_user = $request->input('id_user');

        // Cari pegawai berdasarkan id_user
        $pegawai = Pegawai::where('id_user', $id_user)->first();

        // Tambahkan pengecekan apakah pegawai ditemukan
        if (!$pegawai) {
            return redirect()->back()->with('error', 'Pegawai dengan id_user tersebut tidak ditemukan.');
        }

        // Ambil data URL foto
        $fotoData = $request->input('foto_data');

        // Decode data URL untuk mendapatkan konten gambar
        $fotoData = explode(',', $fotoData)[1];
        $fotoData = base64_decode($fotoData);

        // Tentukan nama file dan path penyimpanan
        $fileName = $ekspedisi->id_ekspedisi . '-' . $ekspedisi->nama_kurir . '.png';
        $filePath = 'public/img-kurir/' . $fileName;

        // Simpan file gambar ke storage
        Storage::put($filePath, $fotoData);

        // Simpan informasi kedatangan ekspedisi ke database
        $kedatanganEkspedisi = new KedatanganEkspedisi();
        $kedatanganEkspedisi->id_ekspedisi = $ekspedisi->id_ekspedisi;
        $kedatanganEkspedisi->id_pegawai = $pegawai->nip; // Menggunakan nip dari pegawai
        $kedatanganEkspedisi->id_user = $id_user;
        $kedatanganEkspedisi->foto = $fileName; // Simpan nama file ke database
        $kedatanganEkspedisi->tanggal_waktu = now(); // Simpan tanggal dan waktu sekarang
        $kedatanganEkspedisi->save();

        $email = $pegawai->user->email;
        Mail::to($email)->send(new pegawaiMailKurir($kedatanganEkspedisi));

        // Redirect atau respons sesuai kebutuhan
        // return redirect()->route('landing-page')->with('success', 'Data berhasil disimpan.');
        return response()->json(['success' => true, 'message' => 'Data berhasil terkirim']);
    }


    public function export()
    {
        Carbon::setLocale('id');

        $currentDate = Carbon::now()->translatedFormat('l, d-m-Y');
        $fileName = "Laporan-Ekspedisi {$currentDate}.xlsx";

        return Excel::download(new LaporanKurirExport, $fileName);
    }

    public function generatePDF(Request $request)
    {
        Log::info('Generating PDF with request:', $request->all());

        $request->validate([
            'reportType' => 'required|in:summary,detail',
            'type' => 'required|in:month,date_range,year',
            'value' => 'required_if:type,month,year',
            'start' => 'required_if:type,date_range|date',
            'end' => 'required_if:type,date_range|date|after_or_equal:start',
        ]);

        $query = KedatanganEkspedisi::query();
        $periode = '';

        switch ($request->type) {
            case 'month':
                $date = Carbon::createFromFormat('Y-m', $request->value);
                $query->whereYear('tanggal_waktu', $date->year)
                    ->whereMonth('tanggal_waktu', $date->month);
                $title = 'Rekap Kurir Bulan ' . $date->format('F Y');
                $periode = $date->translatedFormat('F Y');
                break;
            case 'date_range':
                $startDate = Carbon::parse($request->start)->startOfDay();
                $endDate = Carbon::parse($request->end)->endOfDay();
                $query->whereBetween('tanggal_waktu', [$startDate, $endDate]);
                // Format judul menggunakan d/m/Y sesuai requirement
                $title = 'Rekap Kurir ' . $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y');
                // Format periode menggunakan translatedFormat untuk Bahasa Indonesia
                $periode = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y');
                break;
            case 'year':
                $query->whereYear('tanggal_waktu', $request->value);
                $title = 'Rekap Kurir Tahun ' . $request->value;
                $periode = 'Tahun ' . $request->value;
                break;
        }

        if ($request->reportType === 'summary') {
            $dailyCount = $query->get()
                ->groupBy(function ($item) {
                    $date = $item->tanggal_waktu instanceof Carbon
                        ? $item->tanggal_waktu
                        : Carbon::parse($item->tanggal_waktu);
                    return $date->format('Y-m-d');
                })
                ->map->count();

            $totalKurir = $dailyCount->sum();

            try {
                $pdf = Pdf::loadView('pdf.kurir_recap', compact('dailyCount', 'title', 'totalKurir', 'periode'));
            } catch (\Exception $e) {
                Log::error('Error generating summary PDF: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to generate PDF'], 500);
            }
        } else {
            $data = $query->with(['ekspedisi', 'user'])->get();

            try {
                $pdf = Pdf::loadView('pdf.kurir_detail', compact('data', 'title', 'periode'));
            } catch (\Exception $e) {
                Log::error('Error generating detailed PDF: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to generate PDF'], 500);
            }
        }

        Log::info('PDF generated successfully');

        $content = $pdf->output();

        return response($content)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="rekap_kurir.pdf"')
            ->header('Content-Length', strlen($content));
    }
}
