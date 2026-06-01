<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            // Jadwal ini terikat dengan kelas mana
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            
            $table->enum('day', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']);
            $table->string('subject_name'); // Nama Pelajaran (cth: Pemrograman Web)
            $table->string('teacher_name'); // Nama Guru (cth: Pak Budi)
            $table->string('room');         // Ruangan (cth: Lab RPL 1)
            $table->time('start_time');     // Jam Mulai (cth: 07:00)
            $table->time('end_time');       // Jam Selesai (cth: 08:30)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};