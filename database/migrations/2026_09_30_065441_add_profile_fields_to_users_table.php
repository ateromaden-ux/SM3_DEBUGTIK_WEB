<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kelas')->nullable()->after('name');        // contoh: "X RPL 1"
            $table->string('no_hp')->nullable()->after('kelas');
            $table->string('foto_profil')->nullable()->after('no_hp'); // path storage
            $table->boolean('active')->default(true)->after('foto_profil');
            $table->timestamp('last_login')->nullable()->after('active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kelas', 'no_hp', 'foto_profil', 'active', 'last_login']);
        });
    }
};
