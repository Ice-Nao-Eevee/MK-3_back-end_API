<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\GalleryController;

// Route untuk ngetes saja
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

// Route utama untuk Roster Siswa
Route::get('/siswa', [SiswaController::class, 'index']);

Route::get('/gallery', [GalleryController::class, 'index']);
Route::post('/gallery', [GalleryController::class, 'store']);