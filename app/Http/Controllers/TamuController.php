<?php

namespace App\Http\Controllers;

use DNS2D;
use Carbon\Carbon;
use App\Models\Tamu;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\KedatanganTamu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;




class TamuController extends Controller
{
    public function index()
    {
        $tamus = KedatanganTamu::with('tamu', 'pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Pastikan ini adalah metode paginasi
        return view("admin.laporan-tamu", compact('tamus'));
    }

    public function exportPDF()
    {
        $tamus = KedatanganTamu::with('tamu', 'pegawai');

        $pdf = Pdf::loadView('admin.pdf.laporan-tamu', ['tamus' => $tamus]);
        return $pdf->download('laporan-tamu-'.Carbon::now()->timestamp.'.pdf');
    }



    public function user()
    {
        return view("user.pendaftaran-tamu");
    }

    public function store(Request $request)
    {

        $number = mt_rand(1111111111, 9999999999);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'email' => 'required|email',
            'instansi' => 'required|string',
            'id_pegawai' => 'required|exists:pegawai,id',
            'tujuan' => 'required|string',
            'waktu_perjanjian' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        // Simpan data tamu
        $tamu = new Tamu();
        $tamu->nama = $request->nama;
        $tamu->alamat = $request->alamat;
        $tamu->no_telp = $request->no_telp;
        $tamu->email = $request->email;
        $tamu->save();

        // Ambil data pegawai
        $pegawai = Pegawai::find($request->id_pegawai);
        if (!$pegawai) {
            return response()->json(['message' => 'Pegawai tidak ditemukan'], 404);
        }
        $id_user = $pegawai->id_user;

        // Buat data kedatangan tamu
        $kedatanganTamu = new KedatanganTamu();
        $kedatanganTamu->id_tamu = $tamu->id;
        $kedatanganTamu->instansi = $request->instansi;
        $kedatanganTamu->id_pegawai = $request->id_pegawai;
        $kedatanganTamu->id_user = $id_user;
        $kedatanganTamu->tujuan = $request->tujuan;
        $kedatanganTamu->waktu_perjanjian = $request->waktu_perjanjian;
        $kedatanganTamu->status = 'Menunggu konfirmasi';
        $kedatanganTamu->waktu_kedatangan = null;
        
        // Generate QR Code
        $qrCodeContent = "$tamu->id"; // Atur konten QR Code sesuai kebutuhan
        $qrCodeHtml = DNS2D::getBarcodePNG($qrCodeContent, 'QRCODE');
        $kedatanganTamu->qr_code = $qrCodeHtml;

        $kedatanganTamu->save();

        return response()->json([
            'success' => true,
            'qr_code' => $qrCodeHtml,
        ]);
    }

}
