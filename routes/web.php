<?php
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SiswaCrudController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuntController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KepsekController;

/*
|--------------------------------------------------------------------------
| HALAMAN SISWA (PUBLIK)
|--------------------------------------------------------------------------
*/
Route::get('/', [SiswaController::class, 'index'])->name('siswa');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| KIRIM ASPIRASI (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::post('/siswa/aspirasi', [SiswaController::class, 'store'])
    ->middleware('auth');
Route::post('/siswa/feedback/read', [SiswaController::class, 'readFeedback'])
    ->middleware('auth')
    ->name('siswa.feedback.read');

/*
|--------------------------------------------------------------------------
| ADMIN CRUD (JSON)
|--------------------------------------------------------------------------
*/
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/aspirasi/menunggu', [AdminController::class, 'menunggu'])->name('admin.aspirasi.menunggu');
Route::get('/admin/aspirasi/proses', [AdminController::class, 'proses'])->name('admin.aspirasi.proses');
Route::get('/admin/aspirasi/selesai', [AdminController::class, 'selesai'])->name('admin.aspirasi.selesai');
Route::get('/admin/users-page', [AdminController::class, 'users'])->name('admin.users');
Route::get('/admin/siswa-page', [AdminController::class, 'siswa'])->name('admin.siswa');
Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
Route::get('/admin/laporan/pdf', [AdminController::class, 'laporanPdf'])->name('admin.laporan.pdf');
Route::post('/admin/laporan/send', [AdminController::class, 'sendLaporan'])->name('admin.laporan.send');
Route::get('/admin/laporan/download/{log}', [AdminController::class, 'downloadLaporan'])->name('admin.laporan.download');
Route::post('/admin/feedback', [AdminController::class, 'storeFeedback'])->name('admin.feedback');
Route::post('/admin/user', [AdminController::class, 'storeUser'])->name('admin.user.store');
Route::put('/admin/user/{user}', [AdminController::class, 'updateUser'])->name('admin.user.update');
Route::delete('/admin/user/{user}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
Route::post('/admin/siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
Route::put('/admin/siswa/{siswa}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
Route::delete('/admin/siswa/{siswa}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.destroy');

Route::prefix('admin/api')->group(function () {
    Route::resource('kategori', KategoriController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('aspirasi', AspirasiController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('siswa', SiswaCrudController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('users', UserController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| AUNT
|--------------------------------------------------------------------------
*/
Route::get('/aunt', [AuntController::class, 'index']);

/*
|--------------------------------------------------------------------------
| KEPSEK
|--------------------------------------------------------------------------
*/
Route::get('/kepsek', [KepsekController::class, 'index'])->name('kepsek.dashboard');
Route::get('/kepsek/aspirasi/menunggu', [KepsekController::class, 'menunggu'])->name('kepsek.aspirasi.menunggu');
Route::get('/kepsek/aspirasi/proses', [KepsekController::class, 'proses'])->name('kepsek.aspirasi.proses');
Route::get('/kepsek/aspirasi/selesai', [KepsekController::class, 'selesai'])->name('kepsek.aspirasi.selesai');
Route::get('/kepsek/laporan', [KepsekController::class, 'laporan'])->name('kepsek.laporan');
Route::get('/kepsek/laporan/download/{log}', [AdminController::class, 'downloadLaporan'])->name('kepsek.laporan.download');
