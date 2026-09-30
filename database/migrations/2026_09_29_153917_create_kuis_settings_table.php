<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuis_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materi_id')
                  ->unique() // satu setting per materi
                  ->constrained('materi_belajar')
                  ->onDelete('cascade');

            // ID Kuis — diset sekali, semua soal ikut ini
            $table->string('id_kuis')->unique()->comment('Kode unik kuis, contoh: KUIS-HTML-2024');

            // Waktu per soal
            $table->unsignedSmallInteger('waktu_per_soal')->default(30)
                  ->comment('Nilai numerik waktu per soal');
            $table->enum('satuan_waktu', ['detik', 'menit', 'jam'])->default('detik');

            // KKM — nilai minimum untuk lulus (persentase 0-100)
            $table->unsignedTinyInteger('kkm')->default(70)
                  ->comment('Persentase minimum jawaban benar untuk lulus, 0-100');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuis_settings');
    }
};
