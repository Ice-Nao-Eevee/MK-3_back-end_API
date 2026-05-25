<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\GalleryController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json([
        'message' => 'pong'
    ]);
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
| Register dan login tidak butuh token.
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
| Route di dalam sini butuh token Sanctum.
*/
Route::middleware('auth:sanctum')->group(function () {
    // Profil User
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Data Siswa
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::get('/siswa/{id}', [SiswaController::class, 'show']); // Untuk detail siswa
    
    // 🛠️ MODIFIKASI SAKTI: Diubah ke POST agar Android bisa lancar upload file gambar foto profil ke Cloudinary
    Route::post('/siswa/update/{id}', [SiswaController::class, 'update']); 

    // Gallery Kenangan
    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::post('/gallery', [GalleryController::class, 'store']);
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy']);
});