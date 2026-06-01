<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nis')->unique()->nullable(); 
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // 🔴 MODIFIKASI TERBARU SKALA SEKOLAH:
            // Role diubah menjadi umum: wali_kelas, siswa, atau admin_sekolah
            $table->enum('role', ['admin_sekolah', 'wali_kelas', 'siswa', 'umum'])->default('umum');
            
            // Menghubungkan akun ke ID kelasnya (Nullable karena akun umum/admin tidak punya kelas)
            $table->foreignId('classroom_id')->nullable()->constrained('classrooms')->onDelete('set null');

            $table->rememberToken();
            $table->timestamps();
        });

        // Bagian password_reset_tokens dan sessions biarkan tetap seperti kode aslimu su...
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};