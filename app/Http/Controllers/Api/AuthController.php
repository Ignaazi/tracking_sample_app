<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi Input dari Android (Menerima NIK, bukan Email)
        $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);

        // 2. Ambil kredensial berdasarkan NIK dan Password
        $credentials = [
            'nik' => $request->nik,
            'password' => $request->password
        ];

        // 3. Cek kredensial ke database XAMPP
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'NIK atau Password salah!'
            ], 401);
        }

        // 4. Jika benar, ambil data user dan buat Token Sanctum
        $user = User::where('nik', $request->nik)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login Berhasil!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'nik' => $user->nik,
                'role' => $user->role ?? 'user' // Menyesuaikan jika ada role system
            ]
        ], 200);
    }
}