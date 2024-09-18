<?php

use App\Models\Tamu;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('user.landing-page');
})->name('landing-page');


// Route::get('/dashboard', function () {
//     return view('pegawai.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/pegawai', [AdminController::class, 'pegawai'])->name('admin.pegawai');
    // Route::put('admin/pegawai/{pegawai}', [AdminController::class, 'update'])->name('admin.pegawai.update');
    Route::get('admin/laporan-tamu', [AdminController::class, 'laporan_tamu'])->name('admin.laporan-tamu');
    Route::get('admin/laporan-kurir', [AdminController::class, 'laporan_kurir'])->name('admin.laporan-kurir');

    // Route::get('admin/tambah-pegawai', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('admin/tambah-pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    // Route::get('admin/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('admin/update-pegawai', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::get('admin/delete-pegawai/{nip}', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
    Route::get('pegawai/export/', [PegawaiController::class, 'export'])->name('pegawai.export');
    Route::post('pegawai/import/', [PegawaiController::class, 'import'])->name('pegawai.import');

    Route::get('admin/laporan-tamu/export/', [TamuController::class, 'export'])->name('admin.tamu.export');
    Route::get('admin/laporan-ekspedisi/export/', [KurirController::class, 'export'])->name('admin.kurir.export');

    // Route::get('laporan-tamu-pdf', [TamuController::class, 'exportPDF'])->name('laporan_tamu.pdf');
});

Route::middleware(['auth', 'checkRole:FO'])->group(function () {
    Route::get('FO/dashboard', [FoController::class, 'index'])->name('FO.dashboard');
    Route::get('FO/pegawai', [FoController::class, 'pegawai'])->name('FO.pegawai');
    Route::get('FO/laporan-tamu', [FoController::class, 'laporan_tamu'])->name('FO.laporan-tamu');
    Route::get('FO/laporan-kurir', [FoController::class, 'laporan_kurir'])->name('FO.laporan-kurir');
    Route::get('FO/manajemen-kunjungan', [FoController::class, 'manajemen_kunjungan'])->name('FO.manajemen-kunjungan');
    Route::post('FO/update-kunjungan/{id_tamu}', [FoController::class, 'update_status'])->name('FO.update-status');
    Route::post('/verifikasi-qrcode', [TamuController::class, 'verifikasiQrCode']);
    Route::get('/tamu/detail/{id_tamu}', [TamuController::class, 'getTamuDetail']);
    Route::post('/update-kedatangan', [FoController::class, 'updateKedatangan'])->name('update-kedatangan');

    Route::get('FO/laporan-tamu/export/', [TamuController::class, 'export'])->name('tamu.export');
    Route::get('FO/laporan-ekspedisi/export/', [KurirController::class, 'export'])->name('kurir.export');

    Route::get('/get-notifications', function () {
        $notifications = session('notifications', []);
        if(empty($notifications)) {
            return response()->json(['message' => 'Tidak ada notifikasi ditemukan']);
        }
        return response()->json($notifications);
    });



});



Route::middleware(['auth', 'checkRole:pegawai'])->group(function () {
    Route::get('pegawai/dashboard', [PegawaiController::class, 'index'])->name('pegawai.dashboard');
    Route::get('pegawai/user-profile', [PegawaiController::class, 'user_profile'])->name('pegawai.user-profile');
    Route::get('pegawai/laporan-tamu', [PegawaiController::class, 'laporan_tamu'])->name('pegawai.laporan-tamu');
    Route::get('pegawai/laporan-kurir', [PegawaiController::class, 'laporan_kurir'])->name('pegawai.laporan-kurir');
    Route::get('pegawai/manajemen-kunjungan', [PegawaiController::class, 'manajemen_kunjungan'])->name('pegawai.manajemen-kunjungan');
    Route::post('pegawai/update-kunjungan/{id_tamu}', [PegawaiController::class, 'update_status'])->name('pegawai.update-status');
    Route::get('pegawai/laporan-tamu/export', [PegawaiController::class, 'exportTamu'])->name('pegawai.tamu.export');
    Route::get('pegawai/laporan-kurir/export', [PegawaiController::class, 'exportKurir'])->name('pegawai.kurir.export');
    Route::post('/profile/update', [PegawaiController::class, 'updateProfile'])->name('user.update');

    // Rute pegawai lainnya...
});

Route::get('/tamu', [TamuController::class, 'user'])->name('tamu');

Route::get('/kurir', [ShowController::class, 'kurir'])->name('kurir');
Route::get('/tentang-kami', [ShowController::class, 'tentangkami'])->name('tentang-kami');
Route::get('/guru', [ShowController::class, 'guru'])->name('guru');
Route::get('/tenaga-kependidikan', [ShowController::class, 'tendik'])->name('tendik');


Route::get('/tamu', [UserController::class, 'role'])->name('tamu')->defaults('view', 'user.pendaftaran-tamu');



Route::get('/kurir', [UserController::class, 'role'])->name('kurir')->defaults('view', 'user.pendaftaran-kurir');
// Route::get('/qr-code', [UserController::class, 'qr_code'])->name('kurir')->name('qr-code');
// Route untuk mengunduh QR Code
// Route::get('download-qrcode/{idTamu}', [TamuController::class, 'downloadQRCode'])->name('qrcode.download');

Route::post('/pendaftaran-tamu', [TamuController::class, 'store'])->name('tamu.store');
Route::post('/pendaftaran-kurir', [KurirController::class, 'store'])->name('kurir.store');

// Route::get('/confirm-appointment/{token}/{action}', [TamuController::class, 'konfirmasiKedatangan'])->name('confirm.appointment');
Route::get('confirm-appointment/{token}/{action}', [TamuController::class, 'konfirmasiKedatangan'])
    ->name('confirm.appointment')
    ->where(['action' => 'accept|reject']);

Route::post('confirm-appointment/{token}/{action}', [TamuController::class, 'konfirmasiKedatangan'])
    ->name('confirm.appointment.post')
    ->where(['action' => 'reject']);

Route::get('/tamu-baru', [TamuController::class, 'getNotifications'])->name('tamu.baru');

