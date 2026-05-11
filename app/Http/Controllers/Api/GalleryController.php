<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Lihat semua foto gallery
    public function index()
    {
        // Catatan: Pastikan di Model User kolomnya 'name' atau 'nama' 
        // Kalau tadi di migration adalah 'name', ganti 'nama' jadi 'name' di bawah ini
        $galleries = Gallery::with('user:id,name')->latest()->get();
        return response()->json([
            'success' => true,
            'data'    => $galleries
        ]);
    }

    // Upload foto baru
    public function store(Request $request)
    {
        $request->validate([
            'image'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'caption' => 'nullable|string',
            // 'user_id' => 'required'  <-- HAPUS INI, karena kita ambil dari token
        ]);

        // Proses simpan gambar
        $image = $request->file('image');
        $image->storeAs('public/gallery', $image->hashName());

        $gallery = Gallery::create([
            // AMBIL ID OTOMATIS DARI USER YANG LOGIN
            'user_id' => auth()->id(), 
            'image'   => $image->hashName(),
            'caption' => $request->caption,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diupload!',
            'data'    => $gallery
        ]);
    }
}