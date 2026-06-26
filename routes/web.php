<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\ItemSpecController; // 1. Tambahkan ini di atas

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        
        // MODULE: MANAGEMENT USER
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // MODULE: TRACKING SYSTEM - TIMELINE
        Route::get('/timelines', [TimelineController::class, 'index'])->name('timelines.index');
        Route::post('/timelines', [TimelineController::class, 'store'])->name('timelines.store');
        Route::put('/timelines/{id}', [TimelineController::class, 'update'])->name('timelines.update');
        Route::delete('/timelines/{id}', [TimelineController::class, 'destroy'])->name('timelines.destroy');

        // MODULE: TRACKING SYSTEM - TASK MANAGEMENT
        Route::get('/task', [TaskController::class, 'index'])->name('task.index');
        Route::get('/task/table', [TaskController::class, 'tableIndex'])->name('task.table'); 
        Route::post('/task', [TaskController::class, 'store'])->name('task.store');
        Route::put('/task/{id}', [TaskController::class, 'update'])->name('task.update');
        Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('task.destroy');

        // MODULE: PRODUCTIVITY APPS - EMAIL SYSTEM
        Route::get('/emails', [EmailController::class, 'index'])->name('emails.index');
        Route::post('/emails', [EmailController::class, 'store'])->name('emails.store');
        Route::post('/emails/bulk-action', [EmailController::class, 'bulkAction'])->name('emails.bulkAction');
        Route::post('/emails/{id}/toggle-star', [EmailController::class, 'toggleStar'])->name('emails.star');
        Route::delete('/emails/{id}', [EmailController::class, 'destroy'])->name('emails.destroy');

        // ========================================================
        // NEW MODULE: ITEM SPECIFICATION & REQUIREMENTS (TABEL BERFOTO)
        // ========================================================
        Route::get('/item-specs', [ItemSpecController::class, 'index'])->name('item-specs.index');
        Route::post('/item-specs', [ItemSpecController::class, 'store'])->name('item-specs.store');
        Route::put('/item-specs/{id}', [ItemSpecController::class, 'update'])->name('item-specs.update');
        Route::delete('/item-specs/{id}', [ItemSpecController::class, 'destroy'])->name('item-specs.destroy');

        // ========================================================
        // NEW MODULE: WORKFLOW ENGINE & ASSIGNMENT (PRINT PDF)
        // ========================================================
        Route::get('/workflow', [WorkflowController::class, 'index'])->name('workflow.index');
        Route::get('/workflow/{id}/print-pdf', [WorkflowController::class, 'printPdf'])->name('workflow.printPdf');
        
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});