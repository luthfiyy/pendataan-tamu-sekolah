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

require __DIR__.'/auth.php';

Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class,'index'])->name('admin.dashboard');
    Route::get('admin/pegawai', [PegawaiController::class,'index'])->name('admin.pegawai');
    Route::get('admin/laporan-tamu', [TamuController::class,'index'])->name('admin.laporan-tamu');
    Route::get('admin/laporan-kurir', [KurirController::class,'index'])->name('admin.laporan-kurir');


    // pegawai
    // Route::get('admin/tambah-pegawai', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('admin/tambah-pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    // Route::get('admin/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::post('admin/update-pegawai', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::get('admin/delete-pegawai/{nip}', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
    Route::get('pegawai/export/', [PegawaiController::class, 'export'])->name('pegawai.export');
    Route::post('pegawai/import/', [PegawaiController::class, 'import'])->name('pegawai.import');
});

Route::middleware(['auth', 'checkRole:FO'])->group(function () {
    Route::get('FO/dashboard', [FoController::class,'index'])->name('FO.dashboard');
    Route::get('FO/pegawai', [FoController::class, 'pegawai'])->name('FO.pegawai');
    Route::get('FO/laporan-tamu', [FoController::class, 'laporan_tamu'])->name('FO.laporan-tamu');
    Route::get('FO/laporan-kurir', [FoController::class, 'laporan_kurir'])->name('FO.laporan-kurir');
    Route::get('FO/manajemen-kunjungan', [FoController::class, 'manajemen_kunjungan'])->name('FO.manajemen-kunjungan');
    Route::post('FO/update-kunjungan/{id}', [FoController::class, 'update_status'])->name('FO.update-status');
});



Route::middleware(['auth', 'checkRole:pegawai'])->group(function () {
    Route::get('/pegawai/dashboard', function () {
        return view('pegawai.dashboard');
    })->name('pegawai.dashboard');

    // Rute pegawai lainnya...
});

Route::get('/tamu', [TamuController::class, 'user'])->name('tamu');

Route::get('/kurir', [ShowController::class, 'kurir'])->name('kurir');
Route::get('/tentang-kami', [ShowController::class, 'tentangkami'])->name('tentang-kami');
Route::get('/guru', [ShowController::class, 'guru'])->name('guru');
Route::get('/tenaga-pendidik', [ShowController::class, 'tendik'])->name('tendik');


Route::get('/tamu', [UserController::class, 'role'])->name('tamu')->defaults('view', 'user.pendaftaran-tamu');

Route::get('laporan-tamu-pdf', [TamuController::class, 'exportPDF'])->name('laporan_tamu.pdf');


Route::get('/kurir', [UserController::class, 'role'])->name('kurir')->defaults('view', 'user.pendaftaran-kurir');
// Route::get('/qr-code', [UserController::class, 'qr_code'])->name('kurir')->name('qr-code');
// Route untuk mengunduh QR Code
Route::get('download-qrcode/{idTamu}', [TamuController::class, 'downloadQRCode'])->name('qrcode.download');

Route::post('/pendaftaran-tamu', [TamuController::class, 'store'])->name('tamu.store');
Route::post('/pendaftaran-kurir', [KurirController::class, 'store'])->name('kurir.store');


