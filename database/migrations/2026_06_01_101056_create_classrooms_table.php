<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->enum('tingkat', ['X', 'XI', 'XII']); // Pilihan tingkat kelas
            $table->string('jurusan'); // Contoh: PPLG, TJKT, DKV
            $table->string('nama_kelas'); // Contoh: XI PPLG 4, X TJKT 1
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};