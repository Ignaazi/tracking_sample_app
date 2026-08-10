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
            'name'      => ['required', 'string', 'max:255'],
            'nik'       => ['required', 'string', 'max:50', 'unique:users,nik'],
            'role'      => ['required', Rule::in(['Administrator', 'PD', 'QA', 'PLANNER'])],
            'password'  => ['required', 'string', 'min:8'],
            'signature' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        $signaturePath = null;
        if ($request->hasFile('signature')) {
            $file = $request->file('signature');
            $filename = time() . '_sign_' . preg_replace('/[^A-Za-z0-9_\.-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/signatures'), $filename);
            $signaturePath = 'uploads/signatures/' . $filename;
        }

        $user = User::create([
            'name'      => $request->name,
            'nik'       => $request->nik,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
            'signature' => $signaturePath,
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
            'name'      => ['required', 'string', 'max:255'],
            'nik'       => ['required', 'string', 'max:50', Rule::unique('users', 'nik')->ignore($user->id)],
            'role'      => ['required', Rule::in(['Administrator', 'PD', 'QA', 'PLANNER'])],
            'password'  => ['nullable', 'string', 'min:8'],
            'signature' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        $user->name = $request->name;
        $user->nik  = $request->nik;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Jika mengunggah gambar tanda tangan baru
        if ($request->hasFile('signature')) {
            // Hapus file tanda tangan lama jika ada
            if ($user->signature && file_exists(public_path($user->signature))) {
                @unlink(public_path($user->signature));
            }

            $file = $request->file('signature');
            $filename = time() . '_sign_' . preg_replace('/[^A-Za-z0-9_\.-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/signatures'), $filename);
            $user->signature = 'uploads/signatures/' . $filename;
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

        // Hapus file gambar tanda tangan jika ada
        if ($user->signature && file_exists(public_path($user->signature))) {
            @unlink(public_path($user->signature));
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