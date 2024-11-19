<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tamu;
use App\Models\Pegawai;
use App\Mail\tamuDatang;
use Illuminate\Http\Request;
use App\Models\KedatanganTamu;
use App\Mail\StatusUpdatedMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\KedatanganEkspedisi;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class FoController extends Controller
{

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

        return view('fo.dashboard', [
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

        return view("FO.pegawai", compact("pegawai"));
    }

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

        return view("fo.laporan-tamu", compact('tamus'));
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
        return view("FO.laporan-kurir", compact('ekspedisi'));
    }


    public function manajemen_kunjungan(Request $request)
    {
        $today = Carbon::today();
        Carbon::setLocale('id');
        $now = Carbon::now(); // Mendapatkan waktu sekarang (tanggal + jam)

        // Mengambil status filter dari request
        $filterStatus = $request->input('filterStatus', 'Belum Datang');

        $kedatanganTamuDiterima = KedatanganTamu::with('user', 'tamu')
            ->where('status', 'Diterima')
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

        // Tamu dengan status "Menunggu konfirmasi" dan waktu perjanjian di masa depan
        $kedatanganTamuMenunggu = KedatanganTamu::with('user', 'tamu')
            ->where('status', 'Menunggu konfirmasi')
            ->where('waktu_perjanjian', '>', $now)
            ->orderBy('waktu_perjanjian', 'asc')
            ->paginate(5, ['*'], 'page_menunggu')
            ->withQueryString();

        $totalTamuHariIni = KedatanganTamu::whereDate('waktu_kedatangan', $today)->count();
        $totalTamuDiterima = KedatanganTamu::where('status', 'Diterima')->count();
        $totalTamuDitolak = KedatanganTamu::where('status', 'Ditolak')->count();
        $totalTamuDiproses = KedatanganTamu::where('status', 'Menunggu konfirmasi')->count();

        return view('FO.manajemen-kunjungan', compact(
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

        // Cek apakah email terdaftar
        if ($tamu->email) {
            // Kirim email jika email terdaftar
            Mail::to($tamu->email)->send(new StatusUpdatedMail($kedatanganTamu, $fullQrCodePath));
        } else {
            // Email tidak terdaftar, tampilkan pesan error
            return redirect()->back()->with('error', 'Email tidak terdaftar untuk tamu ini');
        }

        $message = $request->status === 'Ditolak' ? 'Status updated and rejection reason saved successfully' : 'Status updated successfully';
        return redirect()->back()->with('success', $message);
    }

    public function updateKedatangan(Request $request)
    {
        try {
            $kedatanganTamu = KedatanganTamu::where('id_tamu', $request->id_tamu)->first();

            if (!$kedatanganTamu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kedatangan tamu tidak ditemukan'
                ]);
            }

            // Set waktu kedatangan
            $kedatanganTamu->waktu_kedatangan = now();

            // Handle foto
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $namaFoto = time() . '_' . $request->id_tamu . '.jpeg';

                // Store the file directly
                $foto->storeAs('public/img-tamu', $namaFoto);
                $kedatanganTamu->foto = $namaFoto;
            }

            $kedatanganTamu->save();

            // Send email if needed
            if (isset($kedatanganTamu->user) && isset($kedatanganTamu->user->email)) {
                Mail::to($kedatanganTamu->user->email)->send(new tamuDatang($kedatanganTamu));
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in updateKedatangan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
