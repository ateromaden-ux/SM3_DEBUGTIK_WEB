<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->unsignedBigInteger('kuis_settings_id')
                ->nullable()
                ->after('materi_id');

            $table->foreign('kuis_settings_id')
                ->references('id')
                ->on('kuis_settings')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->dropForeign(['kuis_settings_id']);
            $table->dropColumn('kuis_settings_id');
        });
    }
};
