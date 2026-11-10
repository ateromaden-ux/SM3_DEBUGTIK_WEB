<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KelolaKuisController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KuisTikController;
use App\Http\Controllers\MateriBelajarController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\RekapNilaiController;
use App\Models\MateriBelajar;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Admin Auth Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::post('/login', [LoginController::class, 'login'])->name('login');

// Route Super Admin
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/tambah-guru', [AdminController::class, 'storeGuru'])->name('admin.store-guru');
});

Route::middleware('auth:guru')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kelola-kuis', [KelolaKuisController::class, 'index'])->name('kelola-kuis');
    Route::post('/kelola-kuis', [KelolaKuisController::class, 'store'])->name('kelola-kuis.store');
    Route::get('/rekap-nilai', [RekapNilaiController::class, 'index'])->name('rekap-nilai');
    Route::get('/rekap-nilai/export', [RekapNilaiController::class, 'export'])->name('rekap-nilai.export');
    // Redirect /kelola-materi to unified dashboard with tab
    Route::get('/kelola-materi', function () {
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
        Route::get('/', [KuisTikController::class, 'index'])->name('kuis.index');
        Route::post('/', [KuisTikController::class, 'store'])->name('kuis.store');
        Route::put('/{kuis}', [KuisTikController::class, 'update'])->name('kuis.update');
        Route::delete('/{kuis}', [KuisTikController::class, 'destroy'])->name('kuis.destroy');
        Route::delete('/all/{materi}', [KuisTikController::class, 'destroyAllByMateri'])->name('kuis.destroy-all');
    });

    // Halaman fullpage kelola soal kuis
    Route::get('/kuis/{settings}', [KuisTikController::class, 'showPage'])->name('kuis.page');
    Route::post('/api/kuis/publish/{settings}', [KuisTikController::class, 'publish'])->name('kuis.publish');
    Route::post('/api/kuis/unpublish/{settings}', [KuisTikController::class, 'unpublish'])->name('kuis.unpublish');
    Route::get('/kuis-play/{materi}', function (MateriBelajar $materi) {
        $materi->load('kuis');
        return view('kuis.play', compact('materi'));
    })->name('kuis.play');
    Route::post('/logout', function () {
        Auth::guard('guru')->logout();

        return redirect('/');
    })->name('logout');

    // Pengaturan
    Route::post('/pengaturan/profil', [PengaturanController::class, 'updateProfil'])->name('pengaturan.profil');
    Route::post('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.password');
});
