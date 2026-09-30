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
        Schema::table('progress_belajar', function (Blueprint $table) {
            $table->integer('nilai_kuis')->nullable()->after('skor');
            $table->integer('nilai_lab')->nullable()->after('nilai_kuis');
            $table->integer('persentase_selesai')->default(0)->after('progress_persen');
            $table->boolean('status_selesai')->default(false)->after('status');
            $table->integer('nilai_akhir')->nullable()->after('nilai_lab');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress_belajar', function (Blueprint $table) {
            $table->dropColumn(['nilai_kuis', 'nilai_lab', 'persentase_selesai', 'status_selesai', 'nilai_akhir']);
        });
    }
};
