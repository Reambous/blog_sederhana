<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // PENTING: Import Auth

class AuthController extends Controller
{
    // 1. Tampilkan Halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba Login (Auth::attempt akan mengecek ke tabel users otomatis)
        if (Auth::attempt($credentials)) {
            // Jika berhasil:
            $request->session()->regenerate(); // Buat session baru (keamanan)
            return redirect()->intended('/blogs')->with('success', 'Berhasil Login! Selamat datang kembali.');
        }
        // Jika gagal:
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/blogs')->with('success', 'Berhasil Logout.');
    }
}
