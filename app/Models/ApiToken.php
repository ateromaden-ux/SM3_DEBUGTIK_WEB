<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiToken extends Model
{
    protected $table = 'api_tokens';

    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at'   => 'datetime',
    ];

    protected $hidden = ['token'];

    // Relasi polymorphic
    public function tokenable()
    {
        return $this->morphTo();
    }

    // Generate token baru (64 char hex)
    public static function generate(): string
    {
        return bin2hex(random_bytes(32)); // 64 char hex
    }

    // Cek apakah token masih valid (tidak expire)
    public function isValid(): bool
    {
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }
        return true;
    }
}
