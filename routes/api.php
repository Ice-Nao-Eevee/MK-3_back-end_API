<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiswaController;

// Route untuk ngetes saja
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

// Route utama untuk Roster Siswa
Route::get('/siswa', [SiswaController::class, 'index']);