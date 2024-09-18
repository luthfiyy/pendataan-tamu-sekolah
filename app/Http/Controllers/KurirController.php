<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kurir;
use App\Models\Pegawai;
use App\Models\Ekspedisi;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Response;
use App\Mail\pegawaiMailKurir;
use App\Exports\LaporanKurirExport;
use App\Models\KedatanganEkspedisi;
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
        $fileName = $ekspedisi->id_ekspedisi.'-'. $ekspedisi->nama_kurir . '.png';
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

}
