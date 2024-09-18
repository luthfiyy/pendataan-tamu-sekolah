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

    public function index()
    {

        Carbon::setLocale('id');

        $id_user = auth()->user()->id;
        // Data statistik
        $currentMonth = Carbon::now()->month;
        $currentDay = Carbon::today()->day;

        $totalTamuBulanIni = KedatanganTamu::where('id_user', $id_user)->whereMonth('waktu_kedatangan', $currentMonth)->count();
        $totalKurirBulanIni = KedatanganEkspedisi::where('id_user', $id_user)->whereMonth('tanggal_waktu', $currentMonth)->count();
        $totalTamuHariIni = KedatanganTamu::where('id_user', $id_user)->whereDay('waktu_kedatangan', $currentDay)->count();
        $totalKurirHariIni = KedatanganEkspedisi::where('id_user', $id_user)->whereDay('tanggal_waktu', $currentDay)->count();

        // Data terbaru
        $tamuTerbaru = KedatanganTamu::where('id_user', $id_user)->orderBy('created_at', 'desc')->limit(3)->get();
        $kurirTerbaru = KedatanganEkspedisi::where('id_user', $id_user)->orderBy('created_at', 'desc')->limit(3)->get();

        // Data untuk diagram mingguan
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        $dataTamu = DB::table('kedatangan_tamu')
            ->select(DB::raw('DAYOFWEEK(waktu_perjanjian) as day_of_week'), DB::raw('count(*) as total'))
            ->where('id_user', $id_user)
            ->whereBetween('waktu_perjanjian', [$startOfWeek, $endOfWeek])
            ->whereRaw('DAYOFWEEK(waktu_perjanjian) BETWEEN 2 AND 6') // Hanya Senin hingga Jumat
            ->groupBy('day_of_week')
            ->orderBy('day_of_week')
            ->pluck('total', 'day_of_week')
            ->toArray();

        $dataKurir = DB::table('kedatangan_ekspedisi')
            ->select(DB::raw('DAYOFWEEK(tanggal_waktu) as day_of_week'), DB::raw('count(*) as total'))
            ->where('id_user', $id_user)
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

        return view('pegawai.dashboard', [
            'totalTamuBulanIni' => $totalTamuBulanIni,
            'totalKurirBulanIni' => $totalKurirBulanIni,
            'totalTamuHariIni' => $totalTamuHariIni,
            'totalKurirHariIni' => $totalKurirHariIni,
            'tamuTerbaru' => $tamuTerbaru,
            'kurirTerbaru' => $kurirTerbaru,
            'daysOfWeek' => $daysOfWeek,
            'dataTamu' => $dataTamuFormatted,
            'dataKurir' => $dataKurirFormatted,
        ]);
    }

    public function laporan_tamu()
    {
        Carbon::setLocale('id');
        $id_user = auth()->user()->id;
        $tamus = KedatanganTamu::where('id_user', $id_user)->with('tamu', 'pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Pastikan ini adalah metode paginasi
        return view("pegawai.laporan-tamu", compact('tamus'));
    }


    public function laporan_kurir()
    {
        Carbon::setLocale('id');
        $id_user = auth()->user()->id;
        $ekspedisi = KedatanganEkspedisi::where('id_user', $id_user)->with('ekspedisi', 'pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view("pegawai.laporan-kurir", compact('ekspedisi'));
    }

    public function manajemen_kunjungan(Request $request)
    {
        $id_user = auth()->user()->id;

        Carbon::setLocale('id');
        $today = Carbon::now(); // Menggunakan waktu saat ini

        $status = $request->input('status', 'Menunggu konfirmasi');
        $selectedTamuId = $request->input('selected_tamu');

        // Membuat query untuk menampilkan tamu yang belum dikonfirmasi dan waktu perjanjiannya belum lewat
        $query = KedatanganTamu::where('id_user', $id_user)
            ->where('status', 'Menunggu konfirmasi')
            ->where('waktu_perjanjian', '>=', $today); // Hanya tampilkan tamu dengan waktu perjanjian yang belum lewat

        $kedatanganTamu = $query->paginate(5)->withQueryString();

        $selectedTamu = null;
        if ($selectedTamuId) {
            $selectedTamu = KedatanganTamu::find($selectedTamuId);
        }

        $totalTamuHariIni = KedatanganTamu::where('id_user', $id_user)->whereDate('waktu_kedatangan', $today)->count();
        $totalTamuDiterima = KedatanganTamu::where('id_user', $id_user)->where('status', 'Diterima')->count();
        $totalTamuDitolak = KedatanganTamu::where('id_user', $id_user)->where('status', 'Ditolak')->count();
        $totalTamuDiproses = KedatanganTamu::where('id_user', $id_user)->where('status', 'Menunggu konfirmasi')->count();

        $tamus = KedatanganTamu::where('id_user', $id_user)->with(['tamu', 'user']);

        if ($request->has('selected_tamu')) {
            $selectedTamuData = KedatanganTamu::where('id_user', $id_user)->with(['tamu', 'user'])->find($request->selected_tamu);
            if ($selectedTamuData) {
                $selectedTamu = [
                    'id_kedatanganTamu' => $selectedTamuData->id_kedatanganTamu,
                    'nama_tamu' => $selectedTamuData->tamu->nama,
                    'email' => $selectedTamuData->tamu->email,
                    'nama_user' => $selectedTamuData->user->name,
                    'alamat_tamu' => $selectedTamuData->tamu->alamat,
                    'no_telp_tamu' => $selectedTamuData->tamu->no_telp,
                    'instansi' => $selectedTamuData->instansi,
                    'foto' => $selectedTamuData->foto,
                    'tujuan' => $selectedTamuData->tujuan,
                    'status' => $selectedTamuData->status,
                    'waktu_perjanjian' => $selectedTamuData->waktu_perjanjian
                ];
            }
        }

        return view('pegawai.manajemen-kunjungan', compact('totalTamuHariIni', 'totalTamuDiterima', 'totalTamuDitolak', 'totalTamuDiproses', 'kedatanganTamu', 'selectedTamu', 'tamus', 'status'));
    }


    public function update_status(Request $request, $id_tamu)
    {

        $kedatanganTamu = KedatanganTamu::find($id_tamu);
        if ($kedatanganTamu) {
            $kedatanganTamu->update(['status' => $request->status]);
            return redirect()->route('pegawai.manajemen-kunjungan')->with('status', 'Status tamu berhasil diupdate!');

            // Simpan QR code ke dalam file
            $qrCodePath = 'qrcodes/' . $kedatanganTamu->id_tamu . '.png';
            Storage::disk('public')->put($qrCodePath, base64_decode($kedatanganTamu->qr_code));
            $fullQrCodePath = public_path('storage/' . $qrCodePath); // Path lengkap ke QR code

            // Ambil email tamu
            $tamu = Tamu::findOrFail($kedatanganTamu->id_tamu);
            $email = $tamu->email;

            // Kirim email
            Mail::to($email)->send(new StatusUpdatedMail($kedatanganTamu, $fullQrCodePath));
        }

        return view('pegawai.manajemen-kunjungan')->with('error', 'Tamu tidak ditemukan!');
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

    public function exportKurir()
    {
        Carbon::setLocale('id');

        $user = auth()->user();
        $userId = $user->id;
        $userName = $user->name;
        $currentDate = Carbon::now()->translatedFormat('l, d-m-Y');
        $fileName = "Laporan-Ekspedisi {$userName} - {$currentDate}.xlsx";

        return Excel::download(new PegawaiExportKurir($userId), $fileName);
    }
}
