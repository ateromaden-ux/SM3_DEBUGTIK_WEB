<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\KuisApiController;
use App\Http\Controllers\Api\MateriApiController;

/*
|--------------------------------------------------------------------------
| API Routes — DebugTIK Mobile App
|--------------------------------------------------------------------------
|
| Semua route di sini otomatis prefix /api/ dari bootstrap/app.php
|
| Auth flow:
|   1. POST /api/auth/register  → dapat token
|   2. POST /api/auth/login     → dapat token
|   3. Request selanjutnya pakai: Authorization: Bearer {token}
|
*/

// ── PUBLIC: tidak butuh token ──────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthApiController::class, 'register'])->name('api.auth.register');
    Route::post('/login',    [AuthApiController::class, 'login'])->name('api.auth.login');
});

// ── PROTECTED: butuh token (semua role) ───────────────────────────────────
Route::middleware('api.auth')->group(function () {

    // Auth utilities
    Route::prefix('auth')->group(function () {
        Route::post('/logout',          [AuthApiController::class, 'logout'])->name('api.auth.logout');
        Route::get('/me',               [AuthApiController::class, 'me'])->name('api.auth.me');
        Route::put('/profile',          [AuthApiController::class, 'updateProfile'])->name('api.auth.profile');
        Route::put('/change-password',  [AuthApiController::class, 'changePassword'])->name('api.auth.password');
    });

    // ── Konten untuk siswa ─────────────────────────────────────────────────
    // Materi belajar (hanya yang published)
    Route::get('/materi',          [MateriApiController::class, 'index'])->name('api.materi.index');
    Route::get('/materi/{materi}', [MateriApiController::class, 'show'])->name('api.materi.show');

    // Kuis (hanya yang published)
    Route::get('/kuis/{materi}',   [KuisApiController::class, 'show'])->name('api.kuis.show');
    Route::post('/kuis/{materi}/submit', [KuisApiController::class, 'submit'])->name('api.kuis.submit');
});
