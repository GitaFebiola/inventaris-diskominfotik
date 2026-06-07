<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib import ini untuk handle login

class AuthController extends Controller
{
    // Menampilkan Halaman Login
    public function showLoginForm()
    {
        return view('login'); // Pastikan kamu punya file login.blade.php
    }

    // Proses Login (Cek Username & Password)
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'username' => ['required'], // Input harus diisi
            'password' => ['required'], // Password harus diisi
        ]);

        // 2. Cek ke Database & Buat Session
        // Auth::attempt akan otomatis mengecek tabel users
        // Jika berhasil, Laravel otomatis mengisi tabel 'sessions'
        if (Auth::attempt($credentials)) {
            // Regenerate session biar aman (mencegah session fixation)
            $request->session()->regenerate();
            
            // Redirect ke halaman dashboard (buat route dengan nama 'dashboard')
            return redirect()->intended('/dashboard');
        }

        // 3. Jika Gagal Login
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }
    
    public function logout(Request $request)
    {
        Auth::logout(); // Hapus status login user

        // Hapus semua data session (Sangat penting!)
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Flush memastikan tidak ada sisa data session yang tersisa
        session()->flush(); 

        return redirect('/');
}
}