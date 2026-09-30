<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kuis_tik', function (Blueprint $table) {
            // Menyimpan penjelasan per opsi, format: ["Benar karena...", "Salah karena...", ...]
            $table->json('penjelasan_opsi')->nullable()->after('kunci_jawaban');
        });
    }

    public function down(): void
    {
        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->dropColumn('penjelasan_opsi');
        });
    }
};
