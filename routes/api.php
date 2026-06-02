<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json([
        'message' => 'pong',
    ]);
});

/*
|--------------------------------------------------------------------------
| Public API
|--------------------------------------------------------------------------
| Dibuat public supaya Android mudah demo: login, register, master kelas,
| list siswa, dan jadwal berjalan bisa dibaca tanpa ribet token.
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/classrooms', [ClassroomController::class, 'index']);
Route::get('/siswa', [SiswaController::class, 'index']);
Route::get('/jadwal', [ScheduleController::class, 'index']);
Route::get('/jadwal/sekarang', [ScheduleController::class, 'current']);

/*
|--------------------------------------------------------------------------
| Protected API
|--------------------------------------------------------------------------
| Bagian edit/private tetap pakai Sanctum.
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/siswa/{id}', [SiswaController::class, 'show']);
    Route::post('/siswa/update/{id}', [SiswaController::class, 'update']);

    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::post('/gallery', [GalleryController::class, 'store']);
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy']);
});
