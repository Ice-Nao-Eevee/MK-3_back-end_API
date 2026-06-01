<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\ClassroomController; // 🔴 SUNTIKAN 1: Import Controller Kelas Baru Lu
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json([
        'message' => 'pong'
    ]);
});

/*
|--------------------------------------------------------------------------
| Auth & Public Master Routes
|--------------------------------------------------------------------------
| Register, login, dan master kelas tidak butuh token.
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔴 SUNTIKAN 2: Endpoint buat narik list 35 kelas (Bisa difilter ?jurusan=PPLG atau ?tingkat=XI)
Route::get('/classrooms', [ClassroomController::class, 'index']);


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