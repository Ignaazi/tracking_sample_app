<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TaskController; // 1. IMPORT Controller Task Kamu di Sini

/*
|--------------------------------------------------------------------------
| API Routes - Aplikasi Berbasis Mobile / Android
|--------------------------------------------------------------------------
| Rute di sini tidak menggunakan Session Web/CSRF, sehingga aman ditembus 
| oleh Flutter Android menggunakan Token (Stateless).
*/

// Endpoint Login untuk Android (Flutter)
Route::post('/login', [AuthController::class, 'login']);

// 2. TAMBAHKAN ROUTE UNTUK DATA KANBAN BOARD (TASK) DI BAWAH INI
// Endpoint GET untuk mengambil list data task dari database
Route::get('/tasks', [TaskController::class, 'index']);

// Endpoint POST untuk membuat/menambahkan data project task baru
Route::post('/tasks', [TaskController::class, 'store']);