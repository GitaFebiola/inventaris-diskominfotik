<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\PenghapusanController;
use App\Http\Controllers\DashboardController;

// Login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login-proses', [AuthController::class, 'login']); 

Route::middleware(['auth', 'prevent-back'])->group(function () {

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('kategori', KategoriController::class);

    Route::resource('merk', MerkController::class);

    Route::resource('ruangan', RuanganController::class);
    
    Route::get('/barang/pdf', [BarangController::class, 'pdf'])->name('barang.pdf');
    Route::resource('barang', BarangController::class);

    Route::resource('mutasi', MutasiController::class);

    Route::resource('pemeliharaan', PemeliharaanController::class);
    Route::put(
    '/pemeliharaan/{pemeliharaan}/selesai',
    [PemeliharaanController::class,'selesai']
)->name('pemeliharaan.selesai');

    Route::resource('penghapusan', PenghapusanController::class);

});
