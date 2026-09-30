<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;

class ApiTokenAuth
{
    public function handle(Request $request, Closure $next, string $guard = 'any')
    {
        $plain = $request->bearerToken();

        if (!$plain) {
            return response()->json(['message' => 'Token tidak ditemukan. Silakan login terlebih dahulu.'], 401);
        }

        $hashed = hash('sha256', $plain);
        $token  = ApiToken::where('token', $hashed)->first();

        if (!$token || !$token->isValid()) {
            return response()->json(['message' => 'Token tidak valid atau sudah kadaluarsa.'], 401);
        }

        // Cek guard spesifik
        if ($guard === 'user'  && $token->tokenable_type !== 'App\\Models\\User') {
            return response()->json(['message' => 'Akses ditolak. Endpoint ini hanya untuk siswa.'], 403);
        }
        if ($guard === 'guru'  && $token->tokenable_type !== 'App\\Models\\Guru') {
            return response()->json(['message' => 'Akses ditolak. Endpoint ini hanya untuk guru.'], 403);
        }

        // Update last_used_at
        $token->update(['last_used_at' => now()]);

        // Attach user ke request
        $request->merge(['_api_token' => $token]);
        $request->setUserResolver(fn() => $token->tokenable);

        return $next($request);
    }
}
