<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * FUNGSI UP: Dijalankan saat kita mengetik 'php artisan migrate'.
     * Fungsinya untuk membuat tabel dan kolom di database.
     */
    public function up(): void
    {
        // Membuat tabel baru bernama 'galleries'
        Schema::create('galleries', function (Blueprint $table) {
            // 1. Kolom ID: Sebagai Primary Key (ID unik otomatis bertambah)
            $table->id();

            // 2. Kolom FOREIGN ID: Menghubungkan tabel ini ke tabel 'users'
            // 'constrained' memastikan user_id harus ada di tabel users
            // 'onDelete(cascade)' artinya jika User dihapus, semua fotonya otomatis terhapus
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // 3. Kolom IMAGE: Menyimpan alamat URL foto dari Cloudinary
            $table->string('image');

            // 4. Kolom CAPTION: Menyimpan keterangan foto (boleh kosong/nullable)
            $table->text('caption')->nullable();

            // 5. Kolom TIMESTAMPS: Otomatis membuat kolom 'created_at' dan 'updated_at'
            // Gunanya untuk mencatat kapan foto diupload dan terakhir diedit.
            $table->timestamps();
        });
    }

    /**
     * FUNGSI DOWN: Dijalankan saat kita melakukan 'php artisan migrate:rollback'.
     * Fungsinya untuk menghapus tabel jika terjadi kesalahan.
     */
    public function down(): void
    {
        // Menghapus tabel 'galleries' dari database
        Schema::dropIfExists('galleries');
    }
};