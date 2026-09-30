<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guru extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nip', 'name', 'email', 'password', 'role',
        'sekolah', 'foto_profil', 'tahun_ajaran', 'semester',
        'mata_pelajaran', 'no_hp', 'active', 'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'active' => 'boolean',
        'last_login' => 'datetime',
        'password' => 'hashed',
    ];

    public function materisBelajar()
    {
        return $this->hasMany(MateriBelajar::class);
    }

    // Relasi ke token API
    public function apiTokens()
    {
        return $this->morphMany(ApiToken::class, 'tokenable');
    }

    public function createApiToken(string $name = 'android-app'): string
    {
        $plaintext = ApiToken::generate();

        $this->apiTokens()->create([
            'name'      => $name,
            'token'     => hash('sha256', $plaintext),
            'abilities' => '*',
        ]);

        $this->update(['last_login' => now()]);

        return $plaintext;
    }
}
