<?php

namespace App\Http\Controllers; // DISESUAIKAN: Mengikuti letak folder lu (bukan sub-folder Auth)

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller // DISESUAIKAN: Nama class wajib sama dengan nama file AuthController.php
{
    /**
     * Menampilkan halaman login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses otentikasi akun via NIK.
     */
    public function login(Request $request)
    {
        // 1. Validasi input form
        $credentials = $request->validate([
            'nik'      => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Coba login menggunakan Auth bawaan Laravel berbasis kolom NIK
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerasi session jika sukses login agar aman
            $request->session()->regenerate();

            // Alihkan user ke halaman Dashboard Admin Management User
            return redirect()->intended(route('admin.users.index'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        // 3. Jika gagal login, kembalikan dengan error pesan
        return back()->withErrors([
            'nik' => 'NIK atau password yang Anda masukkan salah.',
        ])->withInput($request->only('nik'));
    }

    /**
     * Memproses logout akun dari sistem.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil keluar dari sistem.');
    }
}