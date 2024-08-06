<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tamu;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\KedatanganTamu;
use Illuminate\Support\Facades\DB;
use App\Models\KedatanganEkspedisi;

class AdminController extends Controller
{
    // Di dalam AdminController
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
        $kurirTerbaru = KedatanganEkspedisi::orderBy('created_at', 'desc')->limit(3)->get();

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




}
