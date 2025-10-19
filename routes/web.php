<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\PemeliharaanRutinController;
use App\Http\Controllers\PemeliharaanDaruratController;
use App\Http\Controllers\CatatanPemeliharaanController;
use App\Http\Controllers\NotifikasiController; 
use App\Http\Controllers\EksporController;
use App\Http\Controllers\DashboardController;     
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Form pelaporan
    Route::get('/pelaporan/create', [PelaporanController::class, 'create'])->name('pelaporan.create');
    Route::post('/pelaporan', [PelaporanController::class, 'store'])->name('pelaporan.store');

    //Halaman Laporan
    Route::get('/data-pelaporan', [PelaporanController::class, 'index'])->name('pelaporan.index');

    Route::get('/pelaporan/{pelaporan}', [PelaporanController::class, 'show'])->name('pelaporan.show');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/tindak-lanjut', [TindakLanjutController::class, 'index'])->name('tindak-lanjut.index');
    Route::get('/tindak-lanjut/{id}/edit', [TindakLanjutController::class, 'edit'])->name('tindak-lanjut.edit');
    Route::put('/tindak-lanjut/{id}', [TindakLanjutController::class, 'update'])->name('tindak-lanjut.update');

    Route::resource('pemeliharaan-rutin', PemeliharaanRutinController::class);
    Route::post('catatan-pemeliharaan', [CatatanPemeliharaanController::class, 'store'])->name('catatan-pemeliharaan.store');

    Route::resource('pemeliharaan-darurat', PemeliharaanDaruratController::class);

    Route::get('/ekspor-pdf', [EksporController::class, 'index'])->name('ekspor.index');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'storeAdmin'])->name('admin.store');
    Route::get('/admin/{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{admin}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/admin/{admin}/change-password', [AdminController::class, 'showChangePasswordForm'])->name('admin.change_password_form');
    Route::put('/admin/{admin}/change-password', [AdminController::class, 'updatePassword'])->name('admin.change_password_update');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/mark-all-read', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.markAllAsRead');

});

require __DIR__.'/auth.php';
