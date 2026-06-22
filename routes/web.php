<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;

// Jalur untuk User yang BELUM Login (Guest)
Route::middleware('guest')->group(function () {
    // FIXED: Mengubah showLogin menjadi showLoginForm agar sinkron dengan AuthController
    Route::get('/', [AuthController::class, 'showLoginForm']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
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
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // ==========================================
        // MODULE: TRACKING SYSTEM - TIMELINE
        // ==========================================
        Route::get('/timelines', [TimelineController::class, 'index'])->name('timelines.index');
        Route::post('/timelines', [TimelineController::class, 'store'])->name('timelines.store');
        Route::put('/timelines/{id}', [TimelineController::class, 'update'])->name('timelines.update');
        Route::delete('/timelines/{id}', [TimelineController::class, 'destroy'])->name('timelines.destroy');

        // ==========================================
        // MODULE: TRACKING SYSTEM - TASK MANAGEMENT
        // ==========================================
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

        // ==========================================
        // MODULE: PRODUCTIVITY APPS - EMAIL SYSTEM
        // ==========================================
        Route::get('/emails', [EmailController::class, 'index'])->name('emails.index');
        Route::post('/emails', [EmailController::class, 'store'])->name('emails.store');
        Route::post('/emails/bulk-action', [EmailController::class, 'bulkAction'])->name('emails.bulkAction');
        Route::post('/emails/{id}/toggle-star', [EmailController::class, 'toggleStar'])->name('emails.star');
        Route::delete('/emails/{id}', [EmailController::class, 'destroy'])->name('emails.destroy');

    });

    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});