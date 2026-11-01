<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── kuis_settings ─────────────────────────────────────────────────────
        Schema::table('kuis_settings', function (Blueprint $table) {
            // Hapus FK materi_id dulu sebelum ubah kolom
            $table->dropForeign(['materi_id']);
            $table->dropUnique(['materi_id']);

            // materi_id jadi nullable (kuis bisa berdiri sendiri)
            $table->unsignedBigInteger('materi_id')->nullable()->change();

            // Tambah FK kembali sebagai nullable
            $table->foreign('materi_id')
                ->references('id')
                ->on('materi_belajar')
                ->onDelete('cascade');

            // Tambah kolom baru
            $table->unsignedBigInteger('guru_id')->nullable()->after('id');
            $table->string('nama_kuis', 150)->nullable()->after('guru_id');
            $table->text('deskripsi')->nullable()->after('nama_kuis');

            $table->foreign('guru_id')
                ->references('id')
                ->on('gurus')
                ->onDelete('cascade');
        });

        // ── kuis_tik ──────────────────────────────────────────────────────────
        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->dropForeign(['materi_id']);

            // materi_id jadi nullable
            $table->unsignedBigInteger('materi_id')->nullable()->change();

            $table->foreign('materi_id')
                ->references('id')
                ->on('materi_belajar')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kuis_settings', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropColumn(['guru_id', 'nama_kuis', 'deskripsi']);
            $table->dropForeign(['materi_id']);
            $table->unsignedBigInteger('materi_id')->nullable(false)->change();
            $table->foreign('materi_id')->references('id')->on('materi_belajar')->onDelete('cascade');
            $table->unique('materi_id');
        });

        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->dropForeign(['materi_id']);
            $table->unsignedBigInteger('materi_id')->nullable(false)->change();
            $table->foreign('materi_id')->references('id')->on('materi_belajar')->onDelete('cascade');
        });
    }
};
