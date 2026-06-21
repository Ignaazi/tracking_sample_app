<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Form Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 2. Proses Validasi & Autentikasi Login pakai NIK
    public function login(Request $request)
    {
        // Validasi inputan form dlu
        $credentials = $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba login menggunakan NIK dan Password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Sesuai request, sementara proteksi hanya untuk administrator dlu
            if (Auth::user()->role === 'administrator') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat Datang Admin!');
            }

            // Jika ada user lain tapi bukan admin, kita kick dulu sementara
            Auth::logout();
            return back()->withErrors(['nik' => 'Akses saat ini hanya untuk Administrator!']);
        }

        // Jika NIK atau Password salah
        return back()->withErrors([
            'nik' => 'NIK atau Password yang kamu masukkan salah, bor!',
        ]);
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}