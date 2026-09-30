<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrasi data lama: string → JSON array ["nilai_lama"]
        DB::table('kuis_tik')->get()->each(function ($row) {
            if ($row->kunci_jawaban && !str_starts_with($row->kunci_jawaban, '[')) {
                DB::table('kuis_tik')->where('id', $row->id)->update([
                    'kunci_jawaban' => json_encode([$row->kunci_jawaban]),
                ]);
            }
        });

        // Ubah kolom tipe enum agar support multiple_answer
        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->enum('tipe', ['pilihan_ganda', 'multiple_answer', 'essay'])
                  ->default('pilihan_ganda')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->enum('tipe', ['pilihan_ganda', 'essay'])
                  ->default('pilihan_ganda')
                  ->change();
        });
    }
};
