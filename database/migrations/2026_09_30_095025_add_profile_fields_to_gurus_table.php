<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->string('foto_profil')->nullable()->after('sekolah');
            $table->string('tahun_ajaran')->default('2024/2025')->after('foto_profil');
            $table->enum('semester', ['Ganjil', 'Genap'])->default('Ganjil')->after('tahun_ajaran');
            $table->string('mata_pelajaran')->default('Teknologi Informasi & Komunikasi')->after('semester');
            $table->string('no_hp')->nullable()->after('mata_pelajaran');
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn(['foto_profil', 'tahun_ajaran', 'semester', 'mata_pelajaran', 'no_hp']);
        });
    }
};
