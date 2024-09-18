<?php

namespace App\Http\Controllers;

use Log;
use DNS2D;
use Carbon\Carbon;
use App\Models\Tamu;
use App\Models\Pegawai;
use App\Mail\pegawaiMail;
use Illuminate\Support\Str;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\KedatanganTamu;
use App\Mail\StatusUpdatedMail;
use App\Exports\LaporanTamuExport;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Notification;
use GuzzleHttp\Client;



class TamuController extends Controller
{


    // public function exportPDF()
    // {
    //     $tamus = KedatanganTamu::with('tamu', 'pegawai');

    //     $pdf = Pdf::loadView('admin.pdf.laporan-tamu', ['tamus' => $tamus]);
    //     return $pdf->download('laporan-tamu-' . Carbon::now()->timestamp . '.pdf');
    // }

    public function user()
    {
        return view("user.pendaftaran-tamu");
    }

    public function store(Request $request)
    {
        // Cek apakah ada pertemuan yang diterima pada hari yang sama untuk id_pegawai tertentu
        $existingAcceptedAppointment = KedatanganTamu::where('id_pegawai', $request->id_pegawai)
            ->where('status', 'Diterima')
            ->whereDate('waktu_perjanjian', Carbon::parse($request->waktu_perjanjian)->format('Y-m-d'))
            ->first();

        if ($existingAcceptedAppointment) {
            return response()->json([
                'success' => false,
                'message' => 'Waktu perjanjian sudah ada untuk pegawai ini dalam jangka waktu 1 jam. Silakan pilih waktu lain.',
            ], 409); // 409 Conflict
        }

        // Cek apakah ada waktu perjanjian yang bentrok untuk id_pegawai tertentu dengan rentang waktu 1 jam
        $existingAppointment = KedatanganTamu::where('id_pegawai', $request->id_pegawai)
            ->where(function ($query) use ($request) {
                $query->whereBetween('waktu_perjanjian', [
                    Carbon::parse($request->waktu_perjanjian)->subHour(),
                    Carbon::parse($request->waktu_perjanjian)->addHour()
                ]);
            })
            ->where('status', '!=', 'Ditolak') // Mengabaikan status 'Ditolak'
            ->first();

        if ($existingAppointment) {
            return response()->json([
                'success' => false,
                'message' => 'Waktu perjanjian sudah ada untuk pegawai ini dalam jangka waktu 1 jam. Silakan pilih waktu lain.',
            ], 409); // 409 Conflict
        }

        // Simpan data tamu
        $tamu = new Tamu();
        $tamu->nama = $request->nama;
        $tamu->alamat = $request->alamat;
        $tamu->no_telp = $request->no_telp;
        $tamu->email = $request->email;
        $tamu->save();

        $pegawai = Pegawai::with('user')->where('nip', $request->id_pegawai)->firstOrFail();
        $id_user = $pegawai->user->id;

        $kedatanganTamu = new KedatanganTamu();
        $kedatanganTamu->id_tamu = $tamu->id_tamu;
        $kedatanganTamu->instansi = $request->instansi;
        $kedatanganTamu->id_pegawai = $request->id_pegawai;
        $kedatanganTamu->id_user = $id_user;
        $kedatanganTamu->tujuan = $request->tujuan;
        $kedatanganTamu->waktu_perjanjian = $request->waktu_perjanjian;
        $kedatanganTamu->status = 'Menunggu konfirmasi';
        $kedatanganTamu->waktu_kedatangan = null;

        // Generate QR Code
        $qrCodeContent = "$tamu->id_tamu";
        // $qrCodeContent = "$kedatanganTamu->id_kedatanganTamu";
        $qrCodeHtml = DNS2D::getBarcodePNG($qrCodeContent, 'QRCODE');
        $kedatanganTamu->qr_code = $qrCodeHtml;
        $kedatanganTamu->confirmation_token = Str::random(32);
        $kedatanganTamu->save();

        $email = $pegawai->user->email;
        Mail::to($email)->send(new PegawaiMail($kedatanganTamu));


        return response()->json([
            'success' => true,
            'qr_code' => $qrCodeHtml,
        ]);
    }


    public function konfirmasiKedatangan($token, $action, Request $request)
    {
        $kedatanganTamu = KedatanganTamu::where('confirmation_token', $token)->firstOrFail();
        $tamu = Tamu::findOrFail($kedatanganTamu->id_tamu);

        if ($action === 'accept') {
            $kedatanganTamu->status = 'Diterima';

            // Simpan QR code ke dalam file
            $qrCodePath = 'qrcodes/' . $kedatanganTamu->id_tamu . '.png';
            \Storage::disk('public')->put($qrCodePath, base64_decode($kedatanganTamu->qr_code));
            $fullQrCodePath = public_path('storage/' . $qrCodePath); // Path lengkap ke QR code

            $kedatanganTamu->confirmation_token = null;
            $kedatanganTamu->save();

            // Kirim email untuk status diterima
            $this->sendStatusUpdatedEmail($tamu->email, $kedatanganTamu, $fullQrCodePath);

            return view('emails.appointment_confirmation', ['status' => 'Diterima']);
        } elseif ($action === 'reject') {
            if ($request->isMethod('post')) {
                $request->validate([
                    'keterangan' => 'required|string|max:255',
                ]);

                $kedatanganTamu->status = 'Ditolak';
                $kedatanganTamu->keterangan = $request->input('keterangan');
                $kedatanganTamu->confirmation_token = null;
                $kedatanganTamu->save();

                // Kirim email untuk status ditolak
                $this->sendStatusUpdatedEmail($tamu->email, $kedatanganTamu);

                return view('emails.appointment_confirmation', ['status' => 'Ditolak']);
            } else {
                // Tampilkan form konfirmasi penolakan
                return view('emails.reject_confirmation', ['kedatanganTamu' => $kedatanganTamu]);
            }
        }

        return abort(404);
    }

    private function sendStatusUpdatedEmail($email, $kedatanganTamu, $fullQrCodePath = null)
    {
        Mail::to($email)->send(new StatusUpdatedMail($kedatanganTamu, $fullQrCodePath));
    }


    public function verifikasiQrCode(Request $request)
    {
        $qrCodeContent = $request->input('qr_code_content');

        // Misalnya, verifikasi berdasarkan ID tamu
        $tamu = Tamu::where('id_tamu', $qrCodeContent)->first();

        if ($tamu) {
            return response()->json(['success' => true, 'message' => 'QR Code valid.']);
        } else {
            return response()->json(['success' => false, 'message' => 'QR Code tidak valid.']);
        }
    }

    // public function getTamuDetail($id_tamu)
    // {
    //     $tamu = Tamu::find($id_tamu);
    //     if ($tamu) {
    //         $kedatangan = KedatanganTamu::where('id_tamu', $id_tamu)
    //             ->whereDate('waktu_perjanjian', '<=', now()->toDateString())
    //             ->orderBy('waktu_perjanjian', 'desc')
    //             ->first();


    //         if ($kedatangan) {
    //             $waktuPerjanjian = Carbon::parse($kedatangan->waktu_perjanjian);
    //             $now = Carbon::now();

    //             if ($now->greaterThanOrEqualTo($waktuPerjanjian)) {
    //                 return response()->json([
    //                     'success' => true,
    //                     'name' => $tamu->nama,
    //                     'email' => $tamu->email,
    //                     'phone' => $tamu->no_telp,
    //                     'status' => $kedatangan->status,
    //                     'waktu_perjanjian' => $kedatangan->waktu_perjanjian,
    //                 ]);
    //             } else {
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Waktu scan belum mencapai jadwal perjanjian.'
    //                 ], 403);
    //             }
    //         } else {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Tidak ada jadwal perjanjian yang sesuai.'
    //             ], 404);
    //         }
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Tamu tidak ditemukan'
    //         ], 404);
    //     }
    // }

    public function getTamuDetail($id_tamu)
    {
        $tamu = Tamu::find($id_tamu);
        if ($tamu) {
            // $kedatangan = KedatanganTamu::where('id_tamu', $id_tamu)
            //     ->whereDate('waktu_perjanjian', '<=', now()->toDateString())
            //     ->orderBy('waktu_perjanjian', 'desc')
            //     ->first();

            $kedatangan = KedatanganTamu::where('id_tamu', $id_tamu)
                ->orderBy('waktu_perjanjian', 'desc')
                ->first();

            if ($kedatangan) {
                if ($kedatangan->status !== 'Diterima') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Status tamu belum "Diterima".'
                    ], 403);
                }

                $waktuPerjanjian = Carbon::parse($kedatangan->waktu_perjanjian);
                $now = Carbon::now();
                $batasWaktu = $waktuPerjanjian->copy()->addHour();

                if ($now->between($waktuPerjanjian, $batasWaktu)) {
                    return response()->json([
                        'success' => true,
                        'name' => $tamu->nama,
                        'email' => $tamu->email,
                        'phone' => $tamu->no_telp,
                        'waktu_perjanjian' => $kedatangan->waktu_perjanjian,
                        'status' => $kedatangan->status
                    ]);
                } else if ($now->lessThan($waktuPerjanjian)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Waktu scan belum mencapai jadwal perjanjian.'
                    ], 403);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Waktu scan telah melewati batas 1 jam dari jadwal perjanjian.'
                    ], 403);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada jadwal perjanjian yang sesuai.'
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tamu tidak ditemukan'
            ], 404);
        }
    }

    public function export()
    {
        Carbon::setLocale('id');

        $currentDate = Carbon::now()->translatedFormat('l, d-m-Y');
        $fileName = "Laporan-Tamu {$currentDate}.xlsx";

        return Excel::download(new LaporanTamuExport, $fileName);
    }

    public function getNotifications()
    {
        // $notifications = Notification::where('user_id', auth()->id())
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        $notifications = Tamu::where('created_at', '>=', now()->subDay())->get();

        return response()->json($notifications);
    }
}
