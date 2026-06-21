<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\TaskController; // 🌟 Controller baru untuk modul Task dimasukkan di sini
use Illuminate\Support\Facades\Route;

// Jalur untuk User yang BELUM Login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Jalur untuk User yang SUDAH Login (Auth)
Route::middleware('auth')->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Group Route untuk Admin Modules
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // ==========================================
        // MODULE: MANAGEMENT USER
        // ==========================================
        // Menampilkan daftar user
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        // Memproses tambah user baru
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        // Memproses update data user (Modal Edit)
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        // Memproses hapus user
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


        // ==========================================
        // MODULE: TRACKING SYSTEM - TIMELINE
        // ==========================================
        // Menampilkan halaman timeline & chart gantt horizontal
        Route::get('/timelines', [TimelineController::class, 'index'])->name('timelines.index');
        // Memproses penambahan task schedule baru
        Route::post('/timelines', [TimelineController::class, 'store'])->name('timelines.store');
        // Memproses pembaruan task schedule (Modal Edit)
        Route::put('/timelines/{id}', [TimelineController::class, 'update'])->name('timelines.update');
        // Memproses penghapusan task schedule
        Route::delete('/timelines/{id}', [TimelineController::class, 'destroy'])->name('timelines.destroy');


        // ==========================================
        // MODULE: TRACKING SYSTEM - TASK MANAGEMENT
        // ==========================================
        // Menampilkan halaman daftar task / list task pengerjaan
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        // Memproses penambahan tugas baru
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        // Memproses update data task (Modal Edit)
        Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
        // Memproses penghapusan task
        Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    });

    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});