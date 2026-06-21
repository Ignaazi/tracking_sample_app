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
     * Menampilkan daftar user di halaman Management User.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        
        // Menyesuaikan folder yang kamu miliki (pakai admin.user.index / admin.users.index)
        if (view()->exists('admin.user.index')) {
            return view('admin.user.index', compact('users'));
        }
        return view('admin.users.index', compact('users'));
    }

    /**
     * Memproses penambahan user baru (Menggunakan NIK).
     */
    public function store(Request $request)
    {
        // Validasi inputan form: Email dihapus, diganti NIK wajib unik
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nik'      => ['required', 'string', 'max:50', 'unique:users,nik'],
            'role'     => ['required', Rule::in(['Costing', 'Engineering', 'Production'])],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Simpan data ke database sesuai field database users kamu, bor!
        User::create([
            'name'     => $request->name,
            'nik'      => $request->nik,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User baru berhasil didaftarkan lewat NIK!');
    }

    /**
     * Memproses pembaruan data user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi edit: NIK unik kecuali untuk data miliknya sendiri
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nik'      => ['required', 'string', 'max:50', Rule::unique('users', 'nik')->ignore($user->id)],
            'role'     => ['required', Rule::in(['Costing', 'Engineering', 'Production'])],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->name = $request->name;
        $user->nik  = $request->nik;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data account user berhasil diperbarui!');
    }

    /**
     * Memproses penghapusan user dari sistem.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Kamu tidak bisa menghapus akunmu sendiri yang sedang aktif, bor!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Account user berhasil dihapus dari sistem!');
    }
}