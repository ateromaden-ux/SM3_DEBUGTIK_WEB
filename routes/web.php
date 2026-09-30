<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MateriBelajarController;
use App\Http\Controllers\KuisTikController;
use App\Http\Controllers\LabPraktikController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\RekapNilaiController;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Test auth
Route::get('/test-auth', function() {
    $guru = Guru::where('email', 'siti.nurhaliza@sekolah.sch.id')->first();
    if (!$guru) {
        return 'Guru not found';
    }
    
    $passwordCheck = Hash::check('password123', $guru->password);
    
    return [
        'guru_exists' => true,
        'email' => $guru->email,
        'password_check' => $passwordCheck,
        'password_hash' => substr($guru->password, 0, 20)
    ];
});

Route::middleware('auth:guru')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/rekap-nilai', [RekapNilaiController::class, 'index'])->name('rekap-nilai');
    // Redirect /kelola-materi to unified dashboard with tab
    Route::get('/kelola-materi', function() {
        return redirect('/dashboard?tab=kelola-materi');
    })->name('kelola.materi.redirect');

    // API routes for materi CRUD (used by unified dashboard)
    Route::prefix('api/kelola-materi')->group(function () {
        Route::get('/check', [MateriBelajarController::class, 'checkDuplicate'])->name('kelola.materi.check');
        Route::get('/metrics', [MateriBelajarController::class, 'getMetrics'])->name('kelola.materi.metrics');
        Route::post('/', [MateriBelajarController::class, 'store'])->name('kelola.materi.store');
        Route::put('/{materi}', [MateriBelajarController::class, 'update'])->name('kelola.materi.update');
        Route::delete('/{materi}', [MateriBelajarController::class, 'destroy'])->name('kelola.materi.destroy');
    });

    // API routes for kuis CRUD
    Route::prefix('api/kuis')->group(function () {
        Route::get('/check-id', [KuisTikController::class, 'checkId'])->name('kuis.check-id');
        Route::get('/settings', [KuisTikController::class, 'getSettings'])->name('kuis.settings.get');
        Route::post('/settings', [KuisTikController::class, 'saveSettings'])->name('kuis.settings.save');
        Route::get('/', [KuisTikController::class, 'index'])->name('kuis.index');
        Route::post('/', [KuisTikController::class, 'store'])->name('kuis.store');
        Route::put('/{kuis}', [KuisTikController::class, 'update'])->name('kuis.update');
        Route::delete('/{kuis}', [KuisTikController::class, 'destroy'])->name('kuis.destroy');
    });

    // API routes for attachments
    Route::prefix('api/attachment')->group(function () {
        // Materi
        Route::post('/materi/{materi}', [AttachmentController::class, 'uploadMateri'])->name('attachment.materi.upload');
        Route::get('/materi/{materi}',  [AttachmentController::class, 'listMateri'])->name('attachment.materi.list');
        // Soal kuis
        Route::post('/soal/{soal}',     [AttachmentController::class, 'uploadSoal'])->name('attachment.soal.upload');
        Route::get('/soal/{soal}',      [AttachmentController::class, 'listSoal'])->name('attachment.soal.list');
        // Delete (shared)
        Route::delete('/{attachment}',  [AttachmentController::class, 'destroy'])->name('attachment.destroy');
    });

    // Halaman fullpage kelola soal kuis
    Route::get('/kuis/{materi}', [KuisTikController::class, 'showPage'])->name('kuis.page');
    Route::post('/api/kuis/publish/{materi}',   [KuisTikController::class, 'publish'])->name('kuis.publish');
    Route::post('/api/kuis/unpublish/{materi}', [KuisTikController::class, 'unpublish'])->name('kuis.unpublish');
    Route::get('/kuis-play/{materi}', function (App\Models\MateriBelajar $materi) {
        return view('kuis.play', compact('materi'));
    })->name('kuis.play');

    // API routes for lab praktik CRUD
    Route::prefix('api/lab')->group(function () {
        Route::get('/', [LabPraktikController::class, 'index'])->name('lab.index');
        Route::post('/', [LabPraktikController::class, 'store'])->name('lab.store');
        Route::put('/{lab}', [LabPraktikController::class, 'update'])->name('lab.update');
        Route::delete('/{lab}', [LabPraktikController::class, 'destroy'])->name('lab.destroy');
    });
    Route::post('/logout', function () {
        Auth::guard('guru')->logout();
        return redirect('/');
    })->name('logout');

    // Pengaturan
    Route::post('/pengaturan/profil',   [PengaturanController::class, 'updateProfil'])->name('pengaturan.profil');
    Route::post('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.password');
});
