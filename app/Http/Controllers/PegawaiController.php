<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\Tamu;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Exports\PegawaiExport;
use App\Imports\PegawaiImport;
use App\Models\KedatanganTamu;
use App\Mail\StatusUpdatedMail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PegawaiExportTamu;
use Illuminate\Support\Facades\DB;
use App\Exports\PegawaiExportKurir;
use App\Models\KedatanganEkspedisi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Pagination\Paginator; // Add this line

// use App\Imports\PegawaiImport;

class PegawaiController extends Controller
{
    // public function create()
    // {
    //     return view('admin.pegawai');
    // }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nip' => 'required|string|max:255|unique:pegawai', // Menambahkan aturan unique untuk nip
            'no_telp' => 'required|string|max:255',
            'ptk' => 'required|string|max:255',
        ]);

        if (Pegawai::where('nip', $request->nip)->exists()) {
            return redirect()->route('pegawai.create')->with('error', 'Pegawai ini sudah terdaftar.');
        }

        try {
            // Mulai transaksi
            DB::beginTransaction();

            // Buat user baru
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pegawai',
            ]);

            // Buat pegawai baru
            $pegawai = Pegawai::create([
                'nip' => $request->nip,
                'id_user' => $user->id,
                'no_telp' => $request->no_telp,
                'ptk' => $request->ptk,
            ]);

            // Commit transaksi
            DB::commit();

            return redirect()->route('admin.pegawai')->with('success', 'Pegawai berhasil ditambahkan');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada kesalahan
            DB::rollBack();

            // Log error
            // \Log::error('Gagal menambahkan pegawai', ['error' => $e->getMessage()]);
            \Log::error('Gagal menambahkan pegawai', ['error']);

            return redirect()->route('pegawai.create')->with('error', 'Gagal menambahkan pegawai');
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        // Ambil data pegawai berdasarkan nip
        $pegawai = Pegawai::where('nip', $request->input('nip'))->first();
        // dd($pegawai);

        if ($pegawai) {
            // Update atribut-atribut yang sesuai dari model Pegawai
            // $pegawai->nip = $request->input('nip');
            $pegawai->no_telp = $request->input('newNotelp');
            $pegawai->ptk = $request->input('newPtk');

            // Simpan perubahan pada pegawai
            $pegawai->save();

            // Update juga atribut user jika diperlukan
            if ($pegawai->user) {
                $pegawai->user->name = $request->input('newNama');
                $pegawai->user->email = $request->input('newEmail');
                // Pastikan untuk mengenkripsi password jika diubah
                if (!empty($request->input('newPassword'))) {
                    $pegawai->user->password = bcrypt($request->input('newPassword'));
                }
                $pegawai->user->save();
            }

            return redirect()->back()->with('success', 'Pegawai berhasil di update');
        } else {
            return redirect()->back()->with('error', 'Pegawai tidak ditemukan');
        }
    }

    public function destroy(string $nip)
    {
        // Ambil data pegawai berdasarkan nip
        $pegawai = Pegawai::with('user')->where('nip', $nip)->first();

        if ($pegawai) {
            // Hapus pengguna terkait jika ada
            if ($pegawai->user) {
                $pegawai->user->delete();
            }

            // Hapus data pegawai
            $pegawai->delete();

            return redirect()->back()->with('success', 'Pegawai berhasil dihapus beserta data pengguna terkait');
        } else {
            return redirect()->back()->with('error', 'Pegawai tidak ditemukan');
        }
    }
    public function export()
    {
        Carbon::setLocale('id');

        $currentDate = Carbon::now()->translatedFormat('l, d-m-Y');
        $fileName = "Daftar Pegawai {$currentDate}.xlsx";

        return Excel::download(new PegawaiExport, $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            Excel::import(new PegawaiImport, $request->file('file'));
            // dd($request->all());
            return redirect()->back()->with('success', 'Data pegawai berhasil diimport');
        } catch (\Exception) {
            return redirect()->back()->with('error', 'Pegawai sudah ada');
        }
    }

    // // public function index(Request $request)
    // // {

    // //     Carbon::setLocale('id');

    // //     // Data statistik
    // //     $currentMonth = Carbon::now()->month;
    // //     $currentDay = Carbon::today()->day;

    // //     $totalTamuBulanIni = KedatanganTamu::where('id_user', $id_user)->whereMonth('waktu_kedatangan', $currentMonth)->count();
    // //     $totalKurirBulanIni = KedatanganEkspedisi::where('id_user', $id_user)->whereMonth('tanggal_waktu', $currentMonth)->count();
    // //     $totalTamuHariIni = KedatanganTamu::where('id_user', $id_user)->whereDay('waktu_kedatangan', $currentDay)->count();
    // //     $totalKurirHariIni = KedatanganEkspedisi::where('id_user', $id_user)->whereDay('tanggal_waktu', $currentDay)->count();
    // //     // Get date range from request, default to current week if not provided
    // //     $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfWeek();
    // //     $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfWeek();

    // //     // Ensure endDate is not before startDate
    // //     if ($endDate->lt($startDate)) {
    // //         $endDate = $startDate->copy()->addDays(6);
    // //     }

    // //     // Data terbaru
    // //     $tamuTerbaru = KedatanganTamu::where('id_user', $id_user)->orderBy('created_at', 'desc')->limit(3)->get();
    // //     $kurirTerbaru = KedatanganEkspedisi::where('id_user', $id_user)->orderBy('created_at', 'desc')->limit(3)->get();

    // //     // Data statistik
    // //     $totalTamuPeriode = KedatanganTamu::whereBetween('waktu_kedatangan', [$startDate, $endDate])->count();
    // //     $totalKurirPeriode = KedatanganEkspedisi::whereBetween('tanggal_waktu', [$startDate, $endDate])->count();

    // //     // Data terbaru
    // //     $tamuTerbaru = KedatanganTamu::orderBy('created_at', 'desc')->limit(3)->get();
    // //     $kurirTerbaru = KedatanganEkspedisi::orderBy('created_at', 'desc')->with('ekspedisi')->limit(3)->get();

    // //     // Data untuk diagram
    // //     $dataTamu = $this->getChartData(KedatanganTamu::class, 'waktu_kedatangan', $startDate, $endDate);
    // //     $dataKurir = $this->getChartData(KedatanganEkspedisi::class, 'tanggal_waktu', $startDate, $endDate);

    // //     // Format data untuk diagram
    // //     $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    // //     // Inisialisasi array data dengan nilai 0 untuk setiap hari kerja
    // //     $dataTamuFormatted = array_fill(0, 5, 0);
    // //     $dataKurirFormatted = array_fill(0, 5, 0);

    // //     // Mengisi data yang tersedia ke dalam array yang sudah diinisialisasi
    // //     foreach ($dataTamu as $day => $total) {
    // //         $dataTamuFormatted[$day - 2] = $total; // -2 karena Senin adalah 2 dalam DAYOFWEEK
    // //     }

    // //     foreach ($dataKurir as $day => $total) {
    // //         $dataKurirFormatted[$day - 2] = $total; // -2 karena Senin adalah 2 dalam DAYOFWEEK
    // //     }

    // //     return view('pegawai.dashboard', [
    // //         'totalTamuBulanIni' => $totalTamuBulanIni,
    // //         'totalKurirBulanIni' => $totalKurirBulanIni,
    // //         'totalTamuPeriode' => $totalTamuPeriode,
    // //         'totalKurirPeriode' => $totalKurirPeriode,
    // //         'totalTamuHariIni' => $totalTamuHariIni,
    // //         'totalKurirHariIni' => $totalKurirHariIni,
    // //         'tamuTerbaru' => $tamuTerbaru,
    // //         'kurirTerbaru' => $kurirTerbaru,
    // //         'daysOfWeek' => $daysOfWeek,
    // //         'dataTamu' => $dataTamuFormatted,
    // //         'dataKurir' => $dataKurirFormatted,
    // //         'startDate' => $startDate->format('Y-m-d'),
    // //         'endDate' => $endDate->format('Y-m-d'),
    // //     ]);
    // // }

    // public function index(Request $request)
    // {
    //     Carbon::setLocale('id');
    //     $id_user = auth()->user()->id;

    //     $currentMonth = Carbon::now()->month;
    //     $currentDay = Carbon::today()->day;

    //     $totalTamuBulanIni = KedatanganTamu::whereMonth('waktu_kedatangan', $currentMonth)->count();
    //     $totalKurirBulanIni = KedatanganEkspedisi::whereMonth('tanggal_waktu', $currentMonth)->count();
    //     $totalTamuHariIni = KedatanganTamu::where('id_user', $id_user)->whereDay('waktu_kedatangan', $currentDay)->count();
    //     $totalKurirHariIni = KedatanganEkspedisi::where('id_user', $id_user)->whereDay('tanggal_waktu', $currentDay)->count();

    //     $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfWeek();
    //     $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfWeek();

    //     if ($endDate->lt($startDate)) {
    //         $endDate = $startDate->copy()->addDays(4); // Senin - Jumat saja
    //     }

    //     // Data statistik
    //     $totalTamuPeriode = KedatanganTamu::whereBetween('waktu_kedatangan', [$startDate, $endDate])->count();
    //     $totalKurirPeriode = KedatanganEkspedisi::whereBetween('tanggal_waktu', [$startDate, $endDate])->count();
    //     $totalEmployees = Pegawai::where('ptk', '!=', 'tendik')->count();
    //     $totalTendik = Pegawai::where('PTK', 'tendik')->count();

    //     // Data terbaru
    //     $tamuTerbaru = KedatanganTamu::where('id_user', $id_user)
    //         ->orderBy('created_at', 'desc')->limit(3)->get();
    //     $kurirTerbaru = KedatanganEkspedisi::where('id_user', $id_user)
    //         ->orderBy('created_at', 'desc')->with('ekspedisi')->limit(3)->get();

    //     // Data untuk diagram
    //     $dataTamu = $this->getChartData(KedatanganTamu::class, 'waktu_kedatangan', $startDate, $endDate);
    //     $dataKurir = $this->getChartData(KedatanganEkspedisi::class, 'tanggal_waktu', $startDate, $endDate);

    //     return view('pegawai.dashboard', [
    //         'totalTamuHariIni' => $totalTamuHariIni,
    //         'totalKurirHariIni' => $totalKurirHariIni,
    //         'totalTamuPeriode' => $totalTamuPeriode,
    //         'totalKurirPeriode' => $totalKurirPeriode,
    //         'totalTamuBulanIni' => $totalTamuBulanIni,
    //         'totalKurirBulanIni' => $totalKurirBulanIni,
    //         'tamuTerbaru' => $tamuTerbaru,
    //         'kurirTerbaru' => $kurirTerbaru,
    //         'dataTamu' => $dataTamu,
    //         'dataKurir' => $dataKurir,
    //         'startDate' => $startDate->format('Y-m-d'),
    //         'endDate' => $endDate->format('Y-m-d'),
    //     ]);
    // }

    public function index(Request $request)
    {
        Carbon::setLocale('id');

        // Ambil data user yang sedang login
        $user = Auth::user();

        $currentDate = Carbon::now();
        $defaultMonthYear = $currentDate->format('Y-m');
        $selectedMonthYear = $request->input('month', $defaultMonthYear);

        // Parse the selected month-year
        $date = Carbon::createFromFormat('Y-m', $selectedMonthYear);
        $selectedMonth = $date->month;
        $selectedYear = $date->year;

        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        // Total tamu bulan ini - tambahkan filter user
        $totalTamuBulanIni = KedatanganTamu::whereMonth('waktu_kedatangan', $selectedMonth)
            ->where('id_user', $user->id) // Tambah filter user
            ->whereYear('waktu_kedatangan', $selectedYear) // Tambah filter tahun untuk memastikan bulan yang tepat
            ->count();

        // Total kurir bulan ini - tambahkan filter user
        $totalKurirBulanIni = KedatanganEkspedisi::whereMonth('tanggal_waktu', $selectedMonth)
            ->where('id_user', $user->id) // Tambah filter user
            ->whereYear('tanggal_waktu', $selectedYear) // Tambah filter tahun untuk memastikan bulan yang tepat
            ->count();

        // Total tamu hari ini sudah ada filter user - tidak perlu diubah
        $totalTamuHariIni = KedatanganTamu::where('id_user', $user->id)
            ->whereDay('waktu_kedatangan', $currentDate)
            ->count();

        // Total kurir hari ini sudah ada filter user - tidak perlu diubah
        $totalKurirHariIni = KedatanganEkspedisi::where('id_user', $user->id)
            ->whereDay('tanggal_waktu', $currentDate)
            ->count();

        $tamuAkanDatang = KedatanganTamu::whereDate('waktu_perjanjian', $currentDate->toDateString())
            ->where('id_user', $user->id)
            ->where('status', 'Diterima')
            ->whereNull('waktu_kedatangan') // Tambahkan kondisi ini
            // ->orderBy('waktu_perjanjian')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'tamu_datang_page');

        // Tamu yang sudah datang (waktu_kedatangan tidak NULL)
        $tamuSudahDatang = KedatanganTamu::with(['tamu', 'pegawai.user'])
            ->whereDate('waktu_kedatangan', $currentDate->toDateString())
            ->where('status', 'Diterima')
            ->where('id_user', $user->id)
            ->whereNotNull('waktu_kedatangan') // Tambahkan kondisi ini
            // ->orderBy('waktu_kedatangan', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'tamu_sudah_datang_page');

        $tamuMenungguKonfirmasi = KedatanganTamu::with(['tamu', 'user'])
            ->whereDate('waktu_perjanjian', '>', $currentDate)
            ->where('id_user', $user->id)
            ->where('status', 'Menunggu konfirmasi')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'tamu_pending_page');

        $tamuDitolak = KedatanganTamu::whereDate('waktu_perjanjian', $currentDate->toDateString())
            ->where('status', 'Ditolak')
            ->where('id_user', $user->id)
            // ->orderBy('waktu_perjanjian')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'tamu_ditolak_page');

        $kurirHariIni = KedatanganEkspedisi::whereDate('tanggal_waktu', $currentDate->toDateString())
            ->where('id_user', $user->id)
            ->orderBy('tanggal_waktu', 'desc')
            ->with('ekspedisi')
            ->paginate(5, ['*'], 'kurir_page');


        $dataTamu = $this->getChartData(KedatanganTamu::class, 'waktu_kedatangan', $startDate, $endDate, $user);
        $dataKurir = $this->getChartData(KedatanganEkspedisi::class, 'tanggal_waktu', $startDate, $endDate, $user);

        if ($request->ajax()) {
            return response()->json([
                'dataTamu' => $dataTamu,
                'dataKurir' => $dataKurir,
                'totalTamuPeriode' => array_sum($dataTamu),
                'totalKurirPeriode' => array_sum($dataKurir),
            ]);
        }

        return view('pegawai.dashboard', [
            'totalTamuHariIni' => $totalTamuHariIni,
            'totalKurirHariIni' => $totalKurirHariIni,
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
    private function getChartData($model, $dateField, $startDate, $endDate, $user)
    {
        $data = $model::selectRaw("DATE($dateField) as date, COUNT(*) as total")
            ->whereBetween($dateField, [$startDate, $endDate])
            ->where('id_user', $user->id)
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
    public function laporan_tamu(Request $request)
    {
        Carbon::setLocale('id');
        $id_user = auth()->user()->id;

        $query = KedatanganTamu::where('id_user', $id_user)->with('tamu', 'pegawai')
            ->orderBy('created_at', 'desc');

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
        return view("pegawai.laporan-tamu", compact('tamus'));
    }

    public function laporan_kurir(Request $request)
    {
        Carbon::setLocale('id'); // Atur lokal untuk Carbon (Bahasa Indonesia)
        $id_user = auth()->user()->id; // Mendapatkan ID pengguna yang sedang login
        $search = $request->input('search'); // Mendapatkan input pencarian

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Modify the query to include search and date filter functionality
        $ekspedisi = KedatanganEkspedisi::where('id_user', $id_user)
            ->with('ekspedisi', 'pegawai')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('ekspedisi', function ($query) use ($search) {
                    $query->where('nama_kurir', 'like', "%{$search}%")
                        ->orWhere('no_telp', 'like', "%{$search}%")
                        ->orWhere('ekspedisi', 'like', "%{$search}%");
                });
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('tanggal_waktu', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('tanggal_waktu', '<=', $endDate);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view("pegawai.laporan-kurir", compact('ekspedisi')); // Kirim data ke view
    }

    public function manajemen_kunjungan(Request $request)
    {
        $today = Carbon::today();
        Carbon::setLocale('id');
        $now = Carbon::now(); // Mendapatkan waktu sekarang (tanggal + jam)

        // Mengambil status filter dari request
        $filterStatus = $request->input('filterStatus', 'Belum Datang');

        // ID pengguna yang sedang login
        $userId = auth()->user()->id;

        // $kedatanganTamuDiterima = KedatanganTamu::with('user', 'tamu')
        //     ->where('status', 'Diterima')
        //     ->where('id_user', $userId)
        //     ->when($filterStatus === 'Belum Datang', function ($query) {
        //         return $query->whereNull('waktu_kedatangan');
        //     })
        //     ->when($filterStatus === 'Sudah Datang', function ($query) {
        //         return $query->whereNotNull('waktu_kedatangan');
        //     })
        //     ->orderBy('waktu_perjanjian', 'asc')
        //     ->paginate(5, ['*'], 'page_diterima');

        $kedatanganTamuDiterima = KedatanganTamu::with('user', 'tamu')
            ->where('status', 'Diterima')
            ->where('id_user', $userId)
            ->when($filterStatus === 'Belum Datang', function ($query) use ($now) {
                // Belum Datang: waktu_kedatangan null dan waktu_perjanjian belum lewat
                return $query->whereNull('waktu_kedatangan')
                    ->where('waktu_perjanjian', '>', $now);
            })
            ->when($filterStatus === 'Sudah Datang', function ($query) {
                // Sudah Datang: waktu_kedatangan tidak null
                return $query->whereNotNull('waktu_kedatangan');
            })
            ->when($filterStatus === 'Tidak Datang', function ($query) use ($now) {
                // Tidak Datang: waktu_kedatangan null dan waktu_perjanjian lebih dari 30 menit yang lalu
                return $query->whereNull('waktu_kedatangan')
                    ->where('waktu_perjanjian', '<', $now->subMinutes(30));
            })
            ->orderBy('waktu_perjanjian', 'asc')
            ->paginate(5, ['*'], 'page_diterima');

        $search = $request->input('search');

        // Tamu dengan status "Menunggu konfirmasi" dan waktu perjanjian di masa depan
        $kedatanganTamuMenunggu = KedatanganTamu::with('user', 'tamu')
            ->where('status', 'Menunggu konfirmasi')
            ->where('waktu_perjanjian', '>', $now)
            ->where('id_user', $userId) // Menambahkan filter berdasarkan pengguna yang login
            ->when($search, function ($query) use ($search) {
                // Jika ada input pencarian
                $query->whereHas('tamu', function ($query) use ($search) {
                    // Pencarian berdasarkan nama atau email tamu
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhere('waktu_perjanjian', 'like', "%{$search}%") // Pencarian berdasarkan waktu perjanjian
                    ->orWhere('waktu_kedatangan', 'like', "%{$search}%"); // Pencarian berdasarkan waktu kedatangan
            })
            ->orderBy('waktu_perjanjian', 'asc')
            ->paginate(3, ['*'], 'page_menunggu')
            ->withQueryString();

        $totalTamuHariIni = KedatanganTamu::whereDate('waktu_kedatangan', $today)
            ->where('id_user', $userId) // Menambahkan filter berdasarkan pengguna yang login
            ->count();
        $totalTamuDiterima = KedatanganTamu::where('status', 'Diterima')
            ->where('id_user', $userId) // Menambahkan filter berdasarkan pengguna yang login
            ->count();
        $totalTamuDitolak = KedatanganTamu::where('status', 'Ditolak')
            ->where('id_user', $userId) // Menambahkan filter berdasarkan pengguna yang login
            ->count();
        $totalTamuDiproses = KedatanganTamu::where('status', 'Menunggu konfirmasi')
            ->where('id_user', $userId) // Menambahkan filter berdasarkan pengguna yang login
            ->count();

        return view('pegawai.manajemen-kunjungan', compact(
            'totalTamuHariIni',
            'totalTamuDiterima',
            'totalTamuDitolak',
            'totalTamuDiproses',
            'kedatanganTamuDiterima',
            'kedatanganTamuMenunggu',
            'filterStatus'
        ));
    }
    public function update_status(Request $request, $id_tamu)
    {
        $kedatanganTamu = KedatanganTamu::findOrFail($id_tamu);
        $kedatanganTamu->status = $request->status;

        // If status is "Ditolak", save the rejection reason
        if ($request->status === 'Ditolak') {
            $request->validate([
                'keterangan' => 'required|string|max:255',
            ]);
            $kedatanganTamu->keterangan = $request->keterangan;
        } else {
            $kedatanganTamu->keterangan = null; // Clear keterangan if status is not "Ditolak"
        }

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
            Mail::to($email)->send(new StatusUpdatedMail($kedatanganTamu, $fullQrCodePath));
        } else {
            // Email tidak terdaftar, tampilkan pesan error
            return redirect()->back()->with('error', 'Email tidak terdaftar untuk tamu ini');
        }

        $message = $request->status === 'Ditolak' ? 'Status diperbarui dan alasan penolakan berhasil disimpan' : 'Status berhasil diperbarui';
        return redirect()->back()->with('success', $message);
    }
    public function user_profile()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai->first(); // Fetch the first Pegawai record
        return view('pegawai.user-profile', compact('user', 'pegawai'));
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'newNama' => 'required|string|max:255',
            'newEmail' => 'required|email|max:255',
            'newNotelp' => 'nullable|string|max:20',
            'newPassword' => 'nullable|string|min:8|confirmed', // Assumes confirmation field is present
            'newPtk' => 'nullable|string',
        ]);

        $user = Auth::user();
        $pegawai = $user->pegawai->first(); // Fetch the first Pegawai record

        if ($user) {
            $user->name = $request->input('newNama');
            $user->email = $request->input('newEmail');

            if ($request->filled('newPassword')) {
                $user->password = bcrypt($request->input('newPassword'));
            }

            $user->save();
        }

        if ($pegawai) {
            $pegawai->no_telp = $request->input('newNotelp');
            $pegawai->ptk = $request->input('newPtk');
            $pegawai->save();
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function exportTamu()
    {
        Carbon::setLocale('id');

        $user = auth()->user();
        $userId = $user->id;

        $currentDate = now()->translatedFormat('l, d-m-Y');
        $userName = $user->name;
        $fileName = "Laporan-Tamu {$userName} - {$currentDate}.xlsx";

        return Excel::download(new PegawaiExportTamu($userId), $fileName);
    }

    public function generatePDFKurir(Request $request)
    {
        // Check if user is authenticated
        $user = auth()->user();
        if (!$user) {
            throw new AuthorizationException('User not authenticated');
        }

        Log::info('Generating PDF for user: ' . $user->id);

        try {
            $request->validate([
                'reportType' => 'required|in:summary,detail',
                'type' => 'required|in:month,date_range,year',
                'value' => 'required_if:type,month,year',
                'start' => 'required_if:type,date_range|date',
                'end' => 'required_if:type,date_range|date|after_or_equal:start',
            ]);

            // Ensure query is always scoped to the authenticated user
            $query = KedatanganEkspedisi::where('id_user', $user->id);
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
                    $periode = $startDate->translatedFormat('d F Y') . ' - ' .
                        $endDate->translatedFormat('d F Y');
                    break;
                case 'year':
                    $query->whereYear('tanggal_waktu', $request->value);
                    $title = 'Rekap Kurir Tahun ' . $request->value;
                    $periode = 'Tahun ' . $request->value;
                    break;
            }

            if ($request->reportType === 'summary') {
                // Additional security check for data access
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
                    Log::error('Error generating summary PDF for user ' . $user->id . ': ' . $e->getMessage());
                    return response()->json(['error' => 'Failed to generate PDF'], 500);
                }
            } else {
                // Additional security check for detailed data
                $data = $query->with(['ekspedisi', 'user'])->get();

                try {
                    $pdf = Pdf::loadView('pdf.kurir_detail', compact('data', 'title', 'periode'));
                } catch (\Exception $e) {
                    Log::error('Error generating detailed PDF for user ' . $user->id . ': ' . $e->getMessage());
                    return response()->json(['error' => 'Failed to generate PDF'], 500);
                }
            }

            Log::info('PDF generated successfully for user: ' . $user->id);

            $content = $pdf->output();
            $filename = 'rekap_kurir_' . $user->id . '_' . date('Y-m-d_His') . '.pdf';

            return response($content)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Content-Length', strlen($content));
        } catch (ValidationException $e) {
            Log::error('Validation error for user ' . $user->id . ': ' . $e->getMessage());
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Unexpected error for user ' . $user->id . ': ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    public function generatePDFTamu(Request $request)
    {
        // Check if user is authenticated
        $user = auth()->user();
        if (!$user) {
            throw new AuthorizationException('User not authenticated');
        }

        Log::info('Generating PDF for user: ' . $user->id);

        try {
            $request->validate([
                'type' => 'required|in:month,date_range,year',
                'value' => 'required_if:type,month,year',
                'start' => 'required_if:type,date_range|date',
                'end' => 'required_if:type,date_range|date|after_or_equal:start',
                'report_type' => 'required|in:summary,detail',
                'status' => 'nullable|in:Menunggu konfirmasi,Diterima,Ditolak',
            ]);

            // Ensure query is always scoped to the authenticated user
            $query = KedatanganTamu::where('id_user', $user->id);
            $periode = '';
            $title = '';

            switch ($request->type) {
                case 'month':
                    $date = Carbon::createFromFormat('Y-m', $request->value);
                    $query->whereYear('waktu_perjanjian', $date->year)
                        ->whereMonth('waktu_perjanjian', $date->month);
                    $title = 'Rekap Tamu Bulan ' . $date->translatedFormat('F Y');
                    $periode = $date->translatedFormat('F Y');
                    break;

                case 'date_range':
                    $startDate = Carbon::parse($request->start)->startOfDay();
                    $endDate = Carbon::parse($request->end)->endOfDay();
                    $query->whereBetween('waktu_perjanjian', [$startDate, $endDate]);
                    $title = 'Rekap Tamu ' . $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y');
                    $periode = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y');
                    break;

                case 'year':
                    $query->whereYear('waktu_perjanjian', $request->value);
                    $title = 'Rekap Tamu Tahun ' . $request->value;
                    $periode = 'Tahun ' . $request->value;
                    break;
            }

            // Get status statistics if no specific status is selected
            $statusStats = null;
            if (empty($request->status)) {
                $statusStats = [
                    'Menunggu konfirmasi' => (clone $query)->where('status', 'Menunggu konfirmasi')->count(),
                    'Diterima' => (clone $query)->where('status', 'Diterima')->count(),
                    'Ditolak' => (clone $query)->where('status', 'Ditolak')->count()
                ];
            }

            if ($request->status) {
                $query->where('status', $request->status);
                $title .= ' - Status: ' . $request->status;
            }

            if ($request->report_type === 'summary') {
                $dailyCount = $query->get()
                    ->groupBy(function ($item) {
                        return $item->waktu_perjanjian ?
                            Carbon::parse($item->waktu_perjanjian)->format('Y-m-d') : null;
                    })
                    ->map->count();

                $totalTamu = $dailyCount->sum();
                $pdf = PDF::loadView('pdf.tamu_recap', compact(
                    'dailyCount',
                    'title',
                    'periode',
                    'totalTamu',
                    'statusStats'
                ));
            } else {
                // Additional security check for detailed data
                $guests = $query->with('tamu', 'user')->get();
                $pdf = PDF::loadView('pdf.tamu_detail', compact(
                    'guests',
                    'title',
                    'periode',
                    'statusStats'
                ));
            }

            Log::info('PDF generated successfully for user: ' . $user->id);

            $content = $pdf->output();
            $filename = 'rekap_tamu_' . $user->id . '_' . date('Y-m-d_His') . '.pdf';

            return response($content)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (ValidationException $e) {
            Log::error('Validation error for user ' . $user->id . ': ' . $e->getMessage());
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error generating PDF for user ' . $user->id . ': ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate PDF: ' . $e->getMessage()], 500);
        }
    }
}
