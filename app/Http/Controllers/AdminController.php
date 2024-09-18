<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tamu;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\KedatanganTamu;
use App\Exports\LaporanTamuExport;
use Illuminate\Support\Facades\DB;
use App\Exports\LaporanKurirExport;
use App\Models\KedatanganEkspedisi;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    // Di dalam AdminController
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
        $kurirTerbaru = KedatanganEkspedisi::orderBy('created_at', 'desc')->limit(3)->get();

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

        return view('admin.dashboard', [
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

    public function pegawai() {
        $query = Pegawai::with('user')->orderBy('created_at', 'desc');;
        $pegawai = $query->paginate(10); // Adjust the number of items per page if needed
        return view("admin.pegawai", compact("pegawai"));
    }

    public function laporan_tamu()
    {
        Carbon::setLocale('id');

        $tamus = KedatanganTamu::with('tamu', 'pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Pastikan ini adalah metode paginasi
        return view("admin.laporan-tamu", compact('tamus'));
    }

    public function laporan_kurir()
    {
        Carbon::setLocale('id');

        $ekspedisi = KedatanganEkspedisi::with('ekspedisi', 'pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view("admin.laporan-kurir", compact('ekspedisi'));
    }

    public function exportTamu()
    {
        Carbon::setLocale('id');

        $currentDate = Carbon::now()->translatedFormat('l, d-m-Y');
        $fileName = "Laporan-Tamu {$currentDate}.xlsx";

        return Excel::download(new LaporanTamuExport, $fileName);
    }

    public function exportKurir()
    {
        Carbon::setLocale('id');

        $currentDate = Carbon::now()->translatedFormat('l, d-m-Y');
        $fileName = "Laporan-Ekspedisi {$currentDate}.xlsx";

        return Excel::download(new LaporanKurirExport, $fileName);
    }

}
