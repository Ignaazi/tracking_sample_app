<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import AdminController bawaan Web
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\WorkflowController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'data'   => $request->user()
        ]);
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);

    // 📌 DASHBOARD SEKARANG PANGGIL AdminController@dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // Tasks Management API
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);

    // WORKFLOW API ROUTES
    Route::get('/workflow', [WorkflowController::class, 'index']);
    Route::get('/workflow/{id}', [WorkflowController::class, 'show']);
    Route::post('/workflow/{id}/approve', [WorkflowController::class, 'approve']);
    Route::post('/workflow/{id}/reject', [WorkflowController::class, 'reject']);

});