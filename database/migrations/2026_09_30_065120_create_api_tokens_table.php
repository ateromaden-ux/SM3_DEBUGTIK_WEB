<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel token API sederhana — pengganti Sanctum untuk offline environment.
     * Polymorphic: tokenable_type = App\Models\User | App\Models\Guru
     */
    public function up(): void
    {
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');              // tokenable_type + tokenable_id
            $table->string('name');                   // label token, misal "android-app"
            $table->string('token', 64)->unique();    // SHA-256 hex, 64 char
            $table->string('abilities')->default('*'); // scope, misal "*" atau "user,quiz"
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();  // null = tidak expire
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_tokens');
    }
};
