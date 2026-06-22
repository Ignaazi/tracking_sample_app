<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user di halaman Management User (Dengan Pagination Real).
     */
    public function index()
    {
        // Ambil data dengan pagination real (misal: 5 data per halaman)
        $users = User::orderBy('created_at', 'desc')->paginate(5);
        
        if (view()->exists('admin.user.index')) {
            return view('admin.user.index', compact('users'));
        }
        return view('admin.users.index', compact('users'));
    }

    /**
     * Memproses penambahan user baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nik'      => ['required', 'string', 'max:50', 'unique:users,nik'],
            'role'     => ['required', Rule::in(['Administrator'])], // Hanya Administrator
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'nik'      => $request->nik,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User baru berhasil didaftarkan!',
                'data'    => $user
            ], 200);
        }

        return redirect()->route('admin.users.index')->with('success', 'User baru berhasil didaftarkan!');
    }

    /**
     * Memproses pembaruan data user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nik'      => ['required', 'string', 'max:50', Rule::unique('users', 'nik')->ignore($user->id)],
            'role'     => ['required', Rule::in(['Administrator'])], // Hanya Administrator
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->name = $request->name;
        $user->nik  = $request->nik;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil diperbarui!',
                'data'    => $user
            ], 200);
        }

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Memproses penghapusan user dari sistem.
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kamu tidak bisa menghapus akunmu sendiri yang sedang aktif, bor!'
                ], 422);
            }
            return redirect()->route('admin.users.index')->with('error', 'Kamu tidak bisa menghapus akunmu sendiri yang sedang aktif, bor!');
        }

        $user->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Account user berhasil dihapus!'
            ], 200);
        }

        return redirect()->route('admin.users.index')->with('success', 'Account user berhasil dihapus!');
    }
}