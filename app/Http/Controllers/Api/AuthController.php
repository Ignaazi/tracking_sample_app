<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * API Login untuk Android / Flutter (Menerima NIK & Password)
     */
    public function login(Request $request)
    {
        // 1. Validasi Input dari Android (Disamakan aturan NIK & Password dengan Web)
        $validator = Validator::make($request->all(), [
            'nik'      => ['required', 'string', 'regex:/^[0-9]+$/'],
            'password' => ['required', 'string', 'regex:/^\S*$/'],
        ], [
            'nik.required'      => 'NIK wajib diisi.',
            'nik.regex'         => 'NIK harus berupa karakter angka.',
            'password.required' => 'Password wajib diisi.',
            'password.regex'    => 'Password tidak boleh mengandung spasi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal!',
                'errors'  => $validator->errors()
            ], 422);
        }

        // 2. Pembatasan Percobaan Login (Throttle Key berdasarkan IP & NIK)
        $throttleKey = Str::lower($request->nik) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'status'  => 'error',
                'message' => 'Terlalu banyak percobaan login salah. Silakan coba lagi dalam ' . $seconds . ' detik.'
            ], 429);
        }

        // 3. Ambil kredensial berdasarkan NIK dan Password
        $credentials = [
            'nik'      => $request->nik,
            'password' => $request->password
        ];

        // 4. Cek kredensial ke database
        if (!Auth::attempt($credentials)) {
            // Catat kegagalan ke RateLimiter (Kunci selama 30 detik jika salah 3x)
            RateLimiter::hit($throttleKey, 30);

            return response()->json([
                'status'  => 'error',
                'message' => 'NIK atau Password yang Anda masukkan tidak cocok!'
            ], 401);
        }

        // Clear pembatasan percobaan login jika berhasil
        RateLimiter::clear($throttleKey);

        // 5. Jika benar, ambil data user dan buat Token Sanctum
        $user  = User::where('nik', $request->nik)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'       => 'success',
            'message'      => 'Login Berhasil!',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => [
                'id'   => $user->id,
                'name' => $user->name,
                'nik'  => $user->nik,
                'role' => $user->role ?? 'user'
            ]
        ], 200);
    }

    /**
     * Logout API untuk Hapus Token Sanctum di Mobile App
     */
    public function logout(Request $request)
    {
        // Menghapus token yang sedang digunakan Flutter saat logout
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Anda berhasil keluar dari sistem.'
        ], 200);
    }
}