<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\Pegawai;
use App\Models\Ekspedisi;
use Illuminate\Http\Request;
use App\Models\KedatanganEkspedisi;
// use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator; // Add this line


class KurirController extends Controller
{
    public function index()
    {
        $ekspedisi = KedatanganEkspedisi::with('ekspedisi', 'pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view("admin.laporan-kurir", compact('ekspedisi'));
    }
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_kurir' => 'required|string|max:255',
            'ekspedisi' => 'required|string|max:255',
            'foto_data' => 'required|string', // Validasi untuk data URL foto
            'id_user' => 'required|exists:users,id', // Validasi untuk id_user
        ]);

        // Jika validasi gagal, return response dengan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil data URL foto
        $fotoData = $request->input('foto_data');

        // Decode data URL untuk mendapatkan konten gambar
        $fotoData = explode(',', $fotoData)[1];
        $fotoData = base64_decode($fotoData);

        // Tentukan nama file dan path penyimpanan
        $fileName = 'kurir_' . time() . '.png';
        $filePath = 'public/img-kurir/' . $fileName;

        // Simpan file gambar ke storage
        Storage::put($filePath, $fotoData);

        // Simpan informasi kurir ke database (contoh penggunaan model Ekspedisi)
        $ekspedisi = new Ekspedisi();
        $ekspedisi->nama_kurir = $request->input('nama_kurir');
        $ekspedisi->ekspedisi = $request->input('ekspedisi');
        $ekspedisi->save();

        // Ambil id_user dari request
        $id_user = $request->input('id_user');

        // Cari pegawai berdasarkan id_user
        $pegawai = Pegawai::where('id_user', $id_user)->first();

        // Tambahkan pengecekan apakah pegawai ditemukan
        if (!$pegawai) {
            return redirect()->back()->with('error', 'Pegawai dengan id_user tersebut tidak ditemukan.');
        }

        // Simpan informasi kedatangan ekspedisi ke database
        $kedatanganEkspedisi = new KedatanganEkspedisi();
        $kedatanganEkspedisi->id_ekspedisi = $ekspedisi->id;
        $kedatanganEkspedisi->id_pegawai = $pegawai->id; // Menggunakan id dari pegawai
        $kedatanganEkspedisi->id_user = $id_user;
        $kedatanganEkspedisi->foto = $fileName; // Simpan nama file ke database
        $kedatanganEkspedisi->tanggal_waktu = now(); // Simpan tanggal dan waktu sekarang
        $kedatanganEkspedisi->save();

        // Redirect atau respons sesuai kebutuhan
        return view('user.landing-page')->with('success', 'Data berhasil disimpan.');
    }
}
