<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\KedatanganTamu;
use Illuminate\Support\Facades\DB;
use App\Models\KedatanganEkspedisi;
use App\Http\Controllers\Controller;

class FoController extends Controller
{
    public function index()
    {
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

        $dataTamu = DB::table('tamu')
            ->select(DB::raw('DAYOFWEEK(created_at) as day_of_week'), DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->whereRaw('DAYOFWEEK(created_at) BETWEEN 2 AND 6') // Hanya Senin hingga Jumat
            ->groupBy('day_of_week')
            ->orderBy('day_of_week')
            ->pluck('total', 'day_of_week')
            ->toArray();

        $dataKurir = DB::table('ekspedisi')
            ->select(DB::raw('DAYOFWEEK(created_at) as day_of_week'), DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->whereRaw('DAYOFWEEK(created_at) BETWEEN 2 AND 6') // Hanya Senin hingga Jumat
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
        $query = Pegawai::with('user');

        $pegawai = $query->paginate(10); // Adjust the number of items per page if needed
        return view("FO.pegawai", compact("pegawai"));
    }

    public function laporan_tamu()
    {
        $tamus = KedatanganTamu::with('tamu', 'pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Pastikan ini adalah metode paginasi
        return view("FO.laporan-tamu", compact('tamus'));
    }


    public function laporan_kurir()
    {
        $ekspedisi = KedatanganEkspedisi::with('ekspedisi', 'pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view("FO.laporan-kurir", compact('ekspedisi'));
    }

    public function manajemen_kunjungan(Request $request)
    {
        $today = Carbon::today();

        $totalTamuHariIni = KedatanganTamu::whereDate('waktu_kedatangan', $today)->count();
        $totalTamuDiterima = KedatanganTamu::where('status', 'Diterima')->count();
        $totalTamuDitolak = KedatanganTamu::where('status', 'Ditolak')->count();
        $totalTamuDiproses = KedatanganTamu::where('status', 'Menunggu Konfirmasi')->count();
        
        $status = $request->input('status', 'Menunggu Konfirmasi');
        $kedatanganTamu = KedatanganTamu::where('status', $status)->paginate(5);

        $tamus = KedatanganTamu::with(['tamu', 'user']);

        $selectedTamu = null;
        if ($request->has('selected_tamu')) {
            $selectedTamuData = KedatanganTamu::with(['tamu', 'user'])->find($request->selected_tamu);
            if ($selectedTamuData) {
                $selectedTamu = [
                    'id' => $selectedTamuData->id,
                    'nama_tamu' => $selectedTamuData->tamu->nama,
                    'nama_user' => $selectedTamuData->user->name,
                    'alamat_tamu' => $selectedTamuData->tamu->alamat,
                    'no_telp_tamu' => $selectedTamuData->tamu->no_telp,
                    'instansi' => $selectedTamuData->instansi,
                    'tujuan' => $selectedTamuData->tujuan,
                    'status' => $selectedTamuData->status,
                    'waktu_perjanjian' => $selectedTamuData->waktu_perjanjian
                ];
            }
        }

        return view('FO.manajemen-kunjungan', compact('totalTamuHariIni', 'totalTamuDiterima', 'totalTamuDitolak', 'totalTamuDiproses', 'kedatanganTamu', 'selectedTamu', 'tamus'));
    }
    public function update_status(Request $request, $id)
    {

        $kedatanganTamu = KedatanganTamu::find($id);
        if ($kedatanganTamu) {
            $kedatanganTamu->update(['status' => $request->status]);
            return redirect()->route('FO.manajemen-kunjungan')->with('status', 'Status tamu berhasil diupdate!');
        }
        return redirect()->route('FO.manajemen-kunjungan')->with('error', 'Tamu tidak ditemukan!');
    }
}
