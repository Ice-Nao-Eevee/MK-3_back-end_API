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
            $table->string('tingkat', 10);     // X, XI, XII
            $table->string('jurusan', 20);     // PPLG, TJKT
            $table->unsignedTinyInteger('nomor_kelas');
            $table->string('nama_kelas')->unique(); // contoh: XI PPLG 4
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['tingkat', 'jurusan', 'nomor_kelas']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
