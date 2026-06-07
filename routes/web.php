<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login-proses', [AuthController::class, 'login']); 

Route::middleware(['auth', 'prevent-back'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route lain (inventory, kategori, dll) taruh di sini
});
