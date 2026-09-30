<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'kelas',
        'no_hp',
        'foto_profil',
        'active',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login'        => 'datetime',
        'password'          => 'hashed',
        'active'            => 'boolean',
    ];

    // Relasi ke token API
    public function apiTokens()
    {
        return $this->morphMany(ApiToken::class, 'tokenable');
    }

    // Buat token baru dan simpan ke DB
    public function createApiToken(string $name = 'android-app'): string
    {
        $plaintext = ApiToken::generate();

        $this->apiTokens()->create([
            'name'    => $name,
            'token'   => hash('sha256', $plaintext),
            'abilities' => '*',
        ]);

        // Update last_login
        $this->update(['last_login' => now()]);

        return $plaintext; // kirim ke client sekali saja
    }

    public function progressBelajar()
    {
        return $this->hasMany(ProgressBelajar::class);
    }
}
