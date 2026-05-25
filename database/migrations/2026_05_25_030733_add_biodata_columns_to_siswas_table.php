<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Tambah 5 kolom baru setelah kolom foto lama, set nullable biar aman
            $table->string('tanggal_lahir')->nullable()->after('foto');
            $table->string('whatsapp')->nullable()->after('tanggal_lahir');
            $table->string('instagram')->nullable()->after('whatsapp');
            $table->text('bio')->nullable()->after('instagram');
            $table->text('quote')->nullable()->after('bio');
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn(['tanggal_lahir', 'whatsapp', 'instagram', 'bio', 'quote']);
        });
    }
};