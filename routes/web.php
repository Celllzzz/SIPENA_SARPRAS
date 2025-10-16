<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\Auth\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Form pelaporan
    Route::get('/pelaporan/create', [PelaporanController::class, 'create'])->name('pelaporan.create');
    Route::post('/pelaporan', [PelaporanController::class, 'store'])->name('pelaporan.store');

    //Halaman Laporan
    Route::get('/data-pelaporan', [PelaporanController::class, 'index'])->name('pelaporan.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/tindak-lanjut', [TindakLanjutController::class, 'index'])->name('tindak-lanjut.index');
    Route::get('/tindak-lanjut/{id}/edit', [TindakLanjutController::class, 'edit'])->name('tindak-lanjut.edit');
    Route::put('/tindak-lanjut/{id}', [TindakLanjutController::class, 'update'])->name('tindak-lanjut.update');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'storeAdmin'])->name('admin.store');
});

require __DIR__.'/auth.php';
