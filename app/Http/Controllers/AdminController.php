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
use Illuminate\Support\Facades\Log;
use App\Exports\FormatPegawaiExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    // Di dalam AdminController
    public function index(Request $request)
    {
        Carbon::setLocale('id');

        $currentDate = Carbon::now();
        $defaultMonthYear = $currentDate->format('Y-m');
        $selectedMonthYear = $request->input('month', $defaultMonthYear);

        // Parse the selected month-year
        $date = Carbon::createFromFormat('Y-m', $selectedMonthYear);
        $selectedMonth = $date->month;
        $selectedYear = $date->year;

        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        // Basic statistics remain the same
        $totalTamuBulanIni = KedatanganTamu::whereMonth('waktu_kedatangan', $selectedMonth)
            ->whereYear('waktu_kedatangan', $selectedYear)->count();
        $totalKurirBulanIni = KedatanganEkspedisi::whereMonth('tanggal_waktu', $selectedMonth)
            ->whereYear('tanggal_waktu', $selectedYear)->count();
        $totalEmployees = Pegawai::where('ptk', '!=', 'tendik')->count();
        $totalTendik = Pegawai::where('PTK', 'tendik')->count();

        $tamuAkanDatang = KedatanganTamu::whereDate('waktu_perjanjian', $currentDate->toDateString())
            ->where('status', 'Diterima')
            ->whereNull('waktu_kedatangan') // Tambahkan kondisi ini
            // ->orderBy('waktu_perjanjian')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'tamu_datang_page');

        // Tamu yang sudah datang (waktu_kedatangan tidak NULL)
        $tamuSudahDatang = KedatanganTamu::with(['tamu', 'pegawai.user'])
            ->whereDate('waktu_kedatangan', $currentDate->toDateString())
            ->where('status', 'Diterima')
            ->whereNotNull('waktu_kedatangan') // Tambahkan kondisi ini
            // ->orderBy('waktu_kedatangan', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'tamu_sudah_datang_page');

        $tamuMenungguKonfirmasi = KedatanganTamu::with(['tamu', 'user'])
            ->whereDate('waktu_perjanjian', '>', $currentDate)
            ->where('status', 'Menunggu konfirmasi')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'tamu_pending_page');

        $tamuDitolak = KedatanganTamu::whereDate('waktu_perjanjian', $currentDate->toDateString())
            ->where('status', 'Ditolak')
            // ->orderBy('waktu_perjanjian')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'tamu_ditolak_page');

        $kurirHariIni = KedatanganEkspedisi::whereDate('tanggal_waktu', $currentDate->toDateString())
            ->orderBy('tanggal_waktu', 'desc')
            ->with('ekspedisi')
            ->paginate(5, ['*'], 'kurir_page');

        // Chart data remains the same
        $dataTamu = $this->getChartData(KedatanganTamu::class, 'waktu_kedatangan', $startDate, $endDate);
        $dataKurir = $this->getChartData(KedatanganEkspedisi::class, 'tanggal_waktu', $startDate, $endDate);

        if ($request->ajax()) {
            return response()->json([
                'dataTamu' => $dataTamu,
                'dataKurir' => $dataKurir,
                'totalTamuPeriode' => array_sum($dataTamu),
                'totalKurirPeriode' => array_sum($dataKurir),
            ]);
        }

        return view('admin.dashboard', [
            'totalEmployees' => $totalEmployees,
            'totalTendik' => $totalTendik,
            'totalTamuBulanIni' => $totalTamuBulanIni,
            'totalKurirBulanIni' => $totalKurirBulanIni,
            'tamuAkanDatang' => $tamuAkanDatang,
            'tamuSudahDatang' => $tamuSudahDatang,
            'tamuMenungguKonfirmasi' => $tamuMenungguKonfirmasi,
            'tamuDitolak' => $tamuDitolak,
            'kurirHariIni' => $kurirHariIni,
            'dataTamu' => $dataTamu,
            'dataKurir' => $dataKurir,
            'selectedMonthYear' => $selectedMonthYear,
        ]);
    }

    private function getChartData($model, $dateField, $startDate, $endDate)
    {
        $data = $model::selectRaw("DATE($dateField) as date, COUNT(*) as total")
            ->whereBetween($dateField, [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        $allDates = collect($startDate->daysUntil($endDate))->map(function ($date) {
            return $date->format('Y-m-d');
        });

        return $allDates->mapWithKeys(function ($date) use ($data) {
            return [$date => $data[$date] ?? 0];
        })->toArray();
    }

    public function pegawai(Request $request)
    {
        $query = Pegawai::with(['user']);

        $search = $request->input('search');
        $searchBy = $request->input('search_by');

        // Apply search logic
        if ($search && trim($search) !== '') {
            if ($searchBy) {
                // Specific column search
                switch ($searchBy) {
                    case 'nip':
                        $query->where('nip', 'like', "%{$search}%");
                        break;
                    case 'nama_pegawai':
                        $query->whereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                        break;
                    case 'email_pegawai':
                        $query->whereHas('user', function ($q) use ($search) {
                            $q->where('email', 'like', "%{$search}%");
                        });
                        break;
                    case 'no_telp':
                        $query->where('no_telp', 'like', "%{$search}%");
                        break;
                    case 'ptk':
                        $query->where('ptk', 'like', "%{$search}%");
                        break;
                }
            } else {
                // Global search (search in all relevant columns)
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                        ->orWhere('nip', 'like', "%{$search}%")
                        ->orWhere('no_telp', 'like', "%{$search}%")
                        ->orWhere('ptk', 'like', "%{$search}%");
                });
            }
        }

        $pegawai = $query->paginate(10)->appends($request->query());

        return view("admin.pegawai", compact("pegawai"));
    }
    // Controller: laporan_tamu method
    public function laporan_tamu(Request $request)
    {
        Carbon::setLocale('id');

        $query = KedatanganTamu::with(['tamu', 'user'])
            ->orderBy('created_at', 'desc');

        // Get search parameters
        $search = $request->input('search');
        $searchBy = $request->input('search_by');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Apply search logic
        if ($search && trim($search) !== '') {
            if ($searchBy) {
                // Specific column search
                switch ($searchBy) {
                    case 'nama_tamu':
                        $query->whereHas('tamu', function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%");
                        });
                        break;
                    case 'email_tamu':
                        $query->whereHas('tamu', function ($q) use ($search) {
                            $q->where('email', 'like', "%{$search}%");
                        });
                        break;
                    case 'nama_pegawai':
                        $query->whereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                        break;
                    case 'instansi':
                        $query->where('instansi', 'like', "%{$search}%");
                        break;
                    case 'tujuan':
                        $query->where('tujuan', 'like', "%{$search}%");
                        break;
                }
            } else {
                // Global search (search in all relevant columns)
                $query->where(function ($q) use ($search) {
                    $q->whereHas('tamu', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhere('instansi', 'like', "%{$search}%")
                        ->orWhere('tujuan', 'like', "%{$search}%");
                });
            }
        }

        // Filter by status if provided
        if ($status && trim($status) !== '') {
            $query->where('status', $status);
        }

        // Filter by date range if both dates are provided
        if ($startDate && $endDate) {
            $query->whereBetween('waktu_perjanjian', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $tamus = $query->paginate(10)->appends($request->query());

        return view("admin.laporan-tamu", compact('tamus'));
    }
    public function laporan_kurir(Request $request)
    {
        Carbon::setLocale('id');
        $search = $request->input('search');
        $search_by = $request->input('search_by');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = KedatanganEkspedisi::with(['ekspedisi', 'user'])
            ->orderBy('created_at', 'desc');

        if ($search && $search_by) {
            switch ($search_by) {
                case 'nama_kurir':
                    $query->whereHas('ekspedisi', function ($q) use ($search) {
                        $q->where('nama_kurir', 'like', "%{$search}%");
                    });
                    break;
                case 'ekspedisi':
                    $query->whereHas('ekspedisi', function ($q) use ($search) {
                        $q->where('ekspedisi', 'like', "%{$search}%");
                    });
                    break;
                case 'no_telp':
                    $query->whereHas('ekspedisi', function ($q) use ($search) {
                        $q->where('no_telp', 'like', "%{$search}%");
                    });
                    break;
                case 'pegawai':
                    $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                    break;
            }
        } elseif ($search) {
            // Apply global search across multiple columns
            $query->where(function ($q) use ($search) {
                $q->whereHas('ekspedisi', function ($q) use ($search) {
                    $q->where('nama_kurir', 'like', "%{$search}%")
                        ->orWhere('ekspedisi', 'like', "%{$search}%")
                        ->orWhere('no_telp', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_waktu', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $ekspedisi = $query->paginate(10)->appends($request->query());
        return view("admin.laporan-kurir", compact('ekspedisi'));
    }


    public function downloadFormat()
    {
        return Excel::download(new FormatPegawaiExport, 'format_import_pegawai.xlsx');
    }
}
