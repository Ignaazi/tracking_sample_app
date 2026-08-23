<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // 1. Tampilkan Halaman Form Lupa Password (NIK, Nama, Email)
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Cek NIK & Nama di DB, Lalu Kirim OTP 5 Digit ke Email Inputan User
    public function sendOtp(Request $request)
    {
        $request->validate([
            'nik'   => 'required|numeric',
            'name'  => 'required|string',
            'email' => 'required|email',
        ], [
            'nik.required'   => 'NIK wajib diisi.',
            'nik.numeric'    => 'NIK harus berupa angka.',
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email tujuan OTP wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        // Validasi keberadaan user berdasarkan NIK dan Nama di database
        $user = User::where('nik', $request->nik)
                    ->where('name', 'LIKE', '%' . $request->name . '%')
                    ->first();

        if (!$user) {
            return back()->withErrors(['error' => 'NIK dan Nama Lengkap tidak cocok / tidak ditemukan!'])->withInput();
        }

        // Generate 5 Digit Kode OTP (10000 - 99999)
        $otpCode = rand(10000, 99999);

        // Simpan data NIK, OTP, & Email tujuan ke session sementara (Berlaku 1 menit / 60 detik)
        session([
            'reset_nik'      => $user->nik,
            'otp_code'       => $otpCode,
            'otp_email'      => $request->email,
            'otp_expires_at' => now()->addMinutes(1)
        ]);

        // Kirim Email OTP Secara Nyata
        try {
            Mail::raw("Kode OTP verifikasi reset password Anda adalah: {$otpCode}\n\nKode ini berlaku selama 1 menit. Jangan berikan kode ini kepada siapapun.", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Kode OTP Reset Password - Amcor System Scanner');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengirim email OTP. Pastikan koneksi internet lancar dan pengaturan mail di .env sudah sesuai.'])->withInput();
        }

        return redirect()->route('password.otp_form')->with('success', 'Kode OTP 5 digit telah dikirim ke email: ' . $request->email);
    }

    // 3. Tampilkan Halaman Input 5-Digit OTP
    public function showOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.request')->withErrors(['error' => 'Sesi habis, silakan masukkan NIK dan Nama kembali.']);
        }

        return view('auth.verify-otp');
    }

    // 4. Memproses & Memverifikasi Kode OTP 5 Digit
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:5',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.numeric'  => 'Kode OTP harus berupa angka.',
            'otp.digits'   => 'Kode OTP harus persis 5 digit.',
        ]);

        $savedOtp  = session('otp_code');
        $expiresAt = session('otp_expires_at');

        // Cek apakah OTP kadaluwarsa (lebih dari 1 menit) atau tidak cocok
        if (!$savedOtp || now()->greaterThan($expiresAt)) {
            return back()->withErrors(['error' => 'Kode OTP sudah kadaluwarsa (lebih dari 1 menit). Silakan minta kode baru.']);
        }

        if ($request->otp != $savedOtp) {
            return back()->withErrors(['error' => 'Kode OTP yang Anda masukkan salah! Periksa kembali email Anda.']);
        }

        // OTP Valid: Tandai verifikasi berhasil dan hapus data OTP sementara
        session(['otp_verified' => true]);
        session()->forget(['otp_code', 'otp_expires_at']);

        return redirect()->route('password.reset.form');
    }

    // 5. Tampilkan Form Reset Password Baru
    public function showResetForm()
    {
        if (!session('reset_nik') || !session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['error' => 'Akses ditolak, silakan lakukan verifikasi OTP terlebih dahulu.']);
        }

        return view('auth.reset-password');
    }

    // 6. Update Password Baru ke Database
    public function updatePassword(Request $request)
    {
        $nik = session('reset_nik');

        if (!$nik || !session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['error' => 'Sesi telah berakhir.']);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ]);

        $user = User::where('nik', $nik)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        // Bersihkan semua session reset password
        session()->forget(['reset_nik', 'otp_email', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Password berhasil diperbarui! Silakan login.');
    }
}