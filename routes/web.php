<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return view('auth.login');
});
 
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route admin saja
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('pengguna.create');
    Route::post('/pengguna', [UserController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/{user}/edit', [UserController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna/{user}', [UserController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{user}', [UserController::class, 'destroy'])->name('pengguna.destroy');

    // Route edit & hapus surat juga hanya admin
    Route::get('/surat/{surat}/edit', [SuratController::class, 'edit'])->name('surat.edit');
    Route::put('/surat/{surat}', [SuratController::class, 'update'])->name('surat.update');
    Route::delete('/surat/{surat}', [SuratController::class, 'destroy'])->name('surat.destroy');

    Route::get('/log', [ActivityLogController::class, 'index'])->name('log.index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});

// Route semua user (admin & user biasa)
Route::middleware(['auth'])->group(function () {
    Route::get('/surat', [SuratController::class, 'index'])->name('surat.index');
    Route::post('/surat/generate', [SuratController::class, 'generate'])->name('surat.generate');
    Route::get('/riwayat', [SuratController::class, 'riwayat'])->name('surat.riwayat');
    Route::post('/surat/{surat}/mundur', [SuratController::class, 'mundur'])->name('surat.mundur');
});


Route::middleware('auth')->group(function () {
    Route::get('/surat/{surat}/cetak', [SuratController::class, 'cetak'])->name('surat.cetak');
});

require __DIR__.'/auth.php';
