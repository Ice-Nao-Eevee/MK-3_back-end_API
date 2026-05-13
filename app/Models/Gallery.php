<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    // 1. FILLABLE: Daftar kolom yang diizinkan untuk diisi secara massal (mass assignment)
    // Ini demi keamanan agar tidak sembarang kolom bisa diinput oleh user.
    protected $fillable = ['user_id', 'image', 'public_id', 'caption'];

    // 2. APPENDS: Menambahkan kolom "palsu" atau kolom tambahan saat data dijadikan JSON.
    // Kolom 'image_url' tidak ada di database, tapi akan muncul saat API dipanggil.
    protected $appends = ['image_url'];

    /**
     * RELATIONSHIP: Relasi antara Gallery dan User.
     * Menggunakan belongsTo karena setiap foto (gallery) dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 3. ACCESSOR (getImageUrlAttribute): Logika cerdas untuk kolom 'image_url'
     * Fungsi ini otomatis berjalan saat kita memanggil data gallery.
     */
    public function getImageUrlAttribute()
    {
        // CEK: Apakah kolom 'image' di database sudah berupa link internet (http/https)?
        // Ini berguna karena kita pakai Cloudinary yang memberikan link URL langsung.
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            // Jika sudah berupa link (Cloudinary), langsung kembalikan link-nya.
            return $this->image;
        }

        // JIKA BUKAN LINK: Berarti file disimpan di server lokal (Laravel Storage).
        // Maka fungsi asset() akan membuatkan link otomatis ke folder storage kamu.
        return asset('storage/gallery/' . $this->image);
    }
}