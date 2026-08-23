<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses otentikasi akun via NIK dengan aturan validasi dan pembatasan percobaan.
     */
    public function login(Request $request)
    {
        // Validasi: NIK harus berupa angka, Password tidak boleh ada spasi
        $rules = [
            'nik'      => ['required', 'string', 'regex:/^[0-9]+$/'],
            'password' => ['required', 'string', 'regex:/^\S*$/'],
        ];

        $messages = [
            'nik.required'      => 'NIK wajib diisi.',
            'nik.regex'         => 'NIK harus berupa karakter angka.',
            'password.required' => 'Password wajib diisi.',
            'password.regex'    => 'Password tidak boleh mengandung spasi.',
        ];

        $request->validate($rules, $messages);

        // Throttle Key berdasarkan IP dan NIK
        $throttleKey = Str::lower($request->input('nik')) . '|' . $request->ip();

        // Cek apakah kesalahan login sudah mencapai 3x
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'nik' => 'Terlalu banyak percobaan login salah. Silakan coba lagi dalam ' . $seconds . ' detik.',
            ])->withInput($request->only('nik'));
        }

        // Kredensial pencocokan database
        $credentials = [
            'nik'      => $request->nik,
            'password' => $request->password,
        ];

        // Verifikasi login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        // Tambah hitungan percobaan salah jika login gagal
        RateLimiter::hit($throttleKey, 30);

        return back()->withErrors([
            'nik' => 'Kombinasi NIK dan Password yang Anda masukkan tidak cocok.',
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
