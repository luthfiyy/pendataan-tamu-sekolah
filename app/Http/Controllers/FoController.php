<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\KedatanganTamu;
use App\Mail\StatusUpdatedMail;
use Illuminate\Support\Facades\DB;
use App\Models\KedatanganEkspedisi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Tamu;

class FoController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');

        // Data statistik
        $currentMonth = Carbon::now()->month;
        $totalTamuBulanIni = KedatanganTamu::whereMonth('waktu_kedatangan', $currentMonth)->count();
        $totalKurirBulanIni = KedatanganEkspedisi::whereMonth('tanggal_waktu', $currentMonth)->count();
        $totalEmployees = Pegawai::where('ptk', '!=', 'tendik')->count();
        $totalTendik = Pegawai::where('PTK', 'tendik')->count();

        // Data terbaru
        $tamuTerbaru = KedatanganTamu::orderBy('created_at', 'desc')->limit(3)->get();
        $kurirTerbaru = KedatanganEkspedisi::orderBy('created_at', 'desc')->with('ekspedisi')->limit(3)->get();

        // Data untuk diagram mingguan
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        $dataTamu = DB::table('kedatangan_tamu')
            ->select(DB::raw('DAYOFWEEK(waktu_perjanjian) as day_of_week'), DB::raw('count(*) as total'))
            ->whereBetween('waktu_perjanjian', [$startOfWeek, $endOfWeek])
            ->whereRaw('DAYOFWEEK(waktu_perjanjian) BETWEEN 2 AND 6') // Hanya Senin hingga Jumat
            ->groupBy('day_of_week')
            ->orderBy('day_of_week')
            ->pluck('total', 'day_of_week')
            ->toArray();


        $dataKurir = DB::table('kedatangan_ekspedisi')
            ->select(DB::raw('DAYOFWEEK(tanggal_waktu) as day_of_week'), DB::raw('count(*) as total'))
            ->whereBetween('tanggal_waktu', [$startOfWeek, $endOfWeek])
            ->whereRaw('DAYOFWEEK(tanggal_waktu) BETWEEN 2 AND 6') // Hanya Senin hingga Jumat
            ->groupBy('day_of_week')
            ->orderBy('day_of_week')
            ->pluck('total', 'day_of_week')
            ->toArray();


        // Format data untuk diagram
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // Inisialisasi array data dengan nilai 0 untuk setiap hari kerja
        $dataTamuFormatted = array_fill(0, 5, 0);
        $dataKurirFormatted = array_fill(0, 5, 0);

        // Mengisi data yang tersedia ke dalam array yang sudah diinisialisasi
        foreach ($dataTamu as $day => $total) {
            $dataTamuFormatted[$day - 2] = $total; // -2 karena Senin adalah 2 dalam DAYOFWEEK
        }

        foreach ($dataKurir as $day => $total) {
            $dataKurirFormatted[$day - 2] = $total; // -2 karena Senin adalah 2 dalam DAYOFWEEK
        }

        return view('FO.dashboard', [
            'totalEmployees' => $totalEmployees,
            'totalTendik' => $totalTendik,
            'totalTamuBulanIni' => $totalTamuBulanIni,
            'totalKurirBulanIni' => $totalKurirBulanIni,
            'tamuTerbaru' => $tamuTerbaru,
            'kurirTerbaru' => $kurirTerbaru,
            'daysOfWeek' => $daysOfWeek,
            'dataTamu' => $dataTamuFormatted,
            'dataKurir' => $dataKurirFormatted,

        ]);
    }

    public function pegawai(Request $request)
    {
        $query = Pegawai::with('user')->orderBy('created_at', 'desc');;

        $pegawai = $query->paginate(10); // Adjust the number of items per page if needed
        return view("FO.pegawai", compact("pegawai"));
    }

    public function laporan_tamu(Request $request)
    {
        Carbon::setLocale('id');
        // $tamus = KedatanganTamu::with('tamu', 'pegawai')
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10); // Pastikan ini adalah metode paginasi
        // $status = $request->input('status', 'Menunggu konfirmasi');

        // $query = KedatanganTamu::query();

        // if ($status) {
        //     $query->where('status', $status);
        // } else {
        //     $query->where('status', 'Menunggu konfirmasi');
        // }

        $query = KedatanganTamu::with(['tamu', 'user'])->orderBy('created_at', 'desc');;

        if ($request->has('status') && $request->status != 'Status') {
            $query->where('status', $request->status);
        }

        // if ($request->has('search')) {
        //     $search = $request->search;
        //     $query->where(function ($q) use ($search) {
        //         $q->whereHas('tamu', function ($q) use ($search) {
        //             $q->where('nama', 'like', "%$search%")
        //                 ->orWhere('email', 'like', "%$search%");
        //         })
        //             ->orWhereHas('user', function ($q) use ($search) {
        //                 $q->where('name', 'like', "%$search%");
        //             })
        //             ->orWhere('instansi', 'like', "%$search%")
        //             ->orWhere('tujuan', 'like', "%$search%");
        //     });
        // }

        $tamus = $query->paginate(10);

        if ($request->ajax()) {
            $view = view('tamu.table-data', compact('tamus'))->render();
            return response()->json([
                'tableData' => $view,
                'paginationLinks' => $tamus->links('vendor.pagination.bootstrap-5')->toHtml()
            ]);
        }
        return view("FO.laporan-tamu", compact('tamus'));
    }


    public function laporan_kurir()
    {
        Carbon::setLocale('id');
        $ekspedisi = KedatanganEkspedisi::with('ekspedisi', 'pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view("FO.laporan-kurir", compact('ekspedisi'));
    }

    public function manajemen_kunjungan(Request $request)
    {
        Carbon::setLocale('id');

        $currentTime = Carbon::now();

        // Mengambil tamu yang statusnya belum dikonfirmasi dan waktu perjanjiannya belum lewat
        $kedatanganTamu = KedatanganTamu::where('status', 'Menunggu konfirmasi')
            ->where('waktu_perjanjian', '>', $currentTime)
            ->orderBy('waktu_perjanjian', 'asc')
            ->paginate(3)
            ->withQueryString();

        $status = $request->input('status', 'Menunggu konfirmasi');
        $selectedTamuId = $request->input('selected_tamu');

        $selectedTamu = null;
        if ($selectedTamuId) {
            $selectedTamu = KedatanganTamu::find($selectedTamuId);
        }

        $today = Carbon::today();
        $totalTamuHariIni = KedatanganTamu::whereDate('waktu_kedatangan', $today)->count();
        $totalTamuDiterima = KedatanganTamu::where('status', 'Diterima')->count();
        $totalTamuDitolak = KedatanganTamu::where('status', 'Ditolak')->count();
        $totalTamuDiproses = KedatanganTamu::where('status', 'Menunggu konfirmasi')->count();

        return view('FO.manajemen-kunjungan', compact('totalTamuHariIni', 'totalTamuDiterima', 'totalTamuDitolak', 'totalTamuDiproses', 'kedatanganTamu', 'selectedTamu', 'status'));
    }


    // public function update_status(Request $request, $id_tamu)
    // {
    //     $kedatanganTamu = KedatanganTamu::find($id_tamu);
    //     if ($kedatanganTamu) {
    //         $kedatanganTamu->update(['status' => $request->status]);
    //         return redirect()->route('FO.manajemen-kunjungan')->with('status', 'Status tamu berhasil diupdate!');
    //     }
    //     return redirect()->route('FO.manajemen-kunjungan')->with('error', 'Tamu tidak ditemukan!');
    // }

    public function update_status(Request $request, $id_tamu)
    {
        $kedatanganTamu = KedatanganTamu::findOrFail($id_tamu);
        $kedatanganTamu->status = $request->status;
        $kedatanganTamu->save();

        // Simpan QR code ke dalam file
        $qrCodePath = 'qrcodes/' . $kedatanganTamu->id_tamu . '.png';
        \Storage::disk('public')->put($qrCodePath, base64_decode($kedatanganTamu->qr_code));
        $fullQrCodePath = public_path('storage/' . $qrCodePath); // Path lengkap ke QR code

        // Ambil email tamu
        $tamu = Tamu::findOrFail($kedatanganTamu->id_tamu);
        $email = $tamu->email;

        // Cek apakah email terdaftar
        if ($tamu->email) {
            // Kirim email jika email terdaftar
            Mail::to($tamu->email)->send(new StatusUpdatedMail($kedatanganTamu, $fullQrCodePath));
        } else {
            // Email tidak terdaftar, tampilkan pesan error
            return redirect()->back()->with('error', 'Email tidak terdaftar untuk tamu ini');
        }

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    // public function update_tamu(Request $request, $id_tamu)
    // {

    //     $kedatanganTamu = KedatanganTamu::find($id_tamu);
    //     if ($kedatanganTamu) {
    //         $kedatanganTamu->update([
    //             'foto' => $request->tamu,
    //             'waktu_kedatangan' => now(),
    //     ]);
    //         return redirect()->route('FO.laporan-tamu')->with('status', 'Kedatangan tamu berhasil diupdate!');
    //     }
    //     return redirect()->route('FO.laporan-tamu')->with('error', 'Tamu tidak ditemukan!');
    // }

    public function updateKedatangan(Request $request)
    {
        try {
            $kedatanganTamu = KedatanganTamu::where('id_tamu', $request->id_tamu)->first();
            if (!$kedatanganTamu) {
                return response()->json(['success' => false, 'message' => 'Data kedatangan tamu tidak ditemukan']);
            }

            // Set waktu kedatangan
            $kedatanganTamu->waktu_kedatangan = now();

            // Handle foto
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $namaFoto = time() . '_' . $request->id_tamu . '.' . $foto->getClientOriginalExtension();
                $foto->storeAs('public/img-tamu', $namaFoto);
                $kedatanganTamu->foto = $namaFoto;
            }

            $kedatanganTamu->save();

            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
