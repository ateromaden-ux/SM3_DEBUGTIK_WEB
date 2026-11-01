<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveKuisSettingsRequest;
use App\Http\Requests\StoreKuisRequest;
use App\Http\Requests\UpdateKuisRequest;
use App\Models\Guru;
use App\Models\KuisSettings;
use App\Models\KuisTik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuisTikController extends Controller
{
    // ─── HALAMAN ──────────────────────────────────────────────────────────────

    /**
     * GET /kuis/{settings}
     * Halaman fullpage kelola soal kuis — bisa dari materi atau standalone.
     */
    public function showPage(KuisSettings $settings)
    {
        $guru = Auth::guard('guru')->user() ?? Guru::first();

        // Load soal — bisa via materi_id (legacy) atau kuis_settings_id (standalone)
        $soalList = KuisTik::where(function ($q) use ($settings) {
            $q->where('kuis_settings_id', $settings->id)
                ->orWhere(function ($q2) use ($settings) {
                    if ($settings->materi_id) {
                        $q2->where('materi_id', $settings->materi_id)
                            ->whereNull('kuis_settings_id');
                    }
                });
        })->orderBy('urutan')->get();

        // Judul halaman — pakai nama_kuis atau judul materi
        $judulKuis = $settings->nama_kuis
            ?? $settings->materi?->judul
            ?? 'Kuis';

        return view('kuis.index', compact('guru', 'settings', 'soalList', 'judulKuis'));
    }

    // ─── SETTINGS ─────────────────────────────────────────────────────────────

    /**
     * GET /api/kuis/settings?kuis_settings_id=X
     */
    public function getSettings(Request $request)
    {
        $settings = KuisSettings::find($request->query('kuis_settings_id'));

        return response()->json(['success' => true, 'data' => $settings]);
    }

    /**
     * POST /api/kuis/settings
     */
    public function saveSettings(SaveKuisSettingsRequest $request)
    {
        $validated = $request->validated();

        // Cek duplikasi id_kuis
        $settingsId = $request->input('settings_id');
        $duplicate = KuisSettings::where('id_kuis', $validated['id_kuis'])
            ->when($settingsId, fn ($q) => $q->where('id', '!=', $settingsId))
            ->exists();

        if ($duplicate) {
            return response()->json([
                'success' => false,
                'errors' => ['id_kuis' => ['ID Kuis sudah digunakan.']],
            ], 422);
        }

        // Pastikan guru_id terisi
        if (empty($validated['guru_id'])) {
            $validated['guru_id'] = Auth::guard('guru')->id()
                ?? Guru::first()->id;
        }

        if ($settingsId) {
            $settings = KuisSettings::findOrFail($settingsId);
            $settings->update($validated);
        } else {
            $settings = KuisSettings::create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan kuis berhasil disimpan.',
            'data' => $settings,
        ]);
    }

    // ─── SOAL CRUD ────────────────────────────────────────────────────────────

    /**
     * GET /api/kuis/check-id?id_soal=X&exclude_id=Y
     */
    public function checkId(Request $request)
    {
        $query = KuisTik::where('id_soal', $request->query('id_soal'));
        if ($request->query('exclude_id')) {
            $query->where('id', '!=', $request->query('exclude_id'));
        }

        return response()->json(['duplicate' => $query->exists()]);
    }

    /**
     * GET /api/kuis?kuis_settings_id=X
     */
    public function index(Request $request)
    {
        $kuisSettingsId = $request->query('kuis_settings_id');
        if (! $kuisSettingsId) {
            return response()->json(['success' => false, 'message' => 'kuis_settings_id wajib diisi'], 422);
        }

        $soal = KuisTik::where('kuis_settings_id', $kuisSettingsId)
            ->orderBy('urutan')
            ->get();

        return response()->json(['success' => true, 'data' => $soal, 'total' => $soal->count()]);
    }

    /**
     * POST /api/kuis
     */
    public function store(StoreKuisRequest $request)
    {
        $validated = $request->validated();

        // Auto-generate id_soal
        if (empty($validated['id_soal'])) {
            $settings = KuisSettings::find(
                $validated['kuis_settings_id']
                    ?? KuisSettings::where('materi_id', $validated['materi_id'] ?? null)->first()?->id
            );
            $prefix = $settings?->id_kuis ?? 'SOAL';
            $next = KuisTik::where(function ($q) use ($validated) {
                if (! empty($validated['kuis_settings_id'])) {
                    $q->where('kuis_settings_id', $validated['kuis_settings_id']);
                } elseif (! empty($validated['materi_id'])) {
                    $q->where('materi_id', $validated['materi_id']);
                }
            })->count() + 1;

            $validated['id_soal'] = $prefix.'-'.str_pad($next, 2, '0', STR_PAD_LEFT);
            while (KuisTik::where('id_soal', $validated['id_soal'])->exists()) {
                $next++;
                $validated['id_soal'] = $prefix.'-'.str_pad($next, 2, '0', STR_PAD_LEFT);
            }
        }

        if (empty($validated['urutan'])) {
            $validated['urutan'] = KuisTik::where(function ($q) use ($validated) {
                if (! empty($validated['kuis_settings_id'])) {
                    $q->where('kuis_settings_id', $validated['kuis_settings_id']);
                } elseif (! empty($validated['materi_id'])) {
                    $q->where('materi_id', $validated['materi_id']);
                }
            })->max('urutan') + 1;
        }

        $soal = KuisTik::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil ditambahkan',
            'data' => $soal,
        ], 201);
    }

    /**
     * PUT /api/kuis/{kuis}
     */
    public function update(UpdateKuisRequest $request, KuisTik $kuis)
    {
        $kuis->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil diperbarui',
            'data' => $kuis->fresh(),
        ]);
    }

    /**
     * DELETE /api/kuis/{kuis}
     */
    public function destroy(KuisTik $kuis)
    {
        $kuis->delete();

        return response()->json(['success' => true, 'message' => 'Soal berhasil dihapus']);
    }

    // ─── PUBLISH ──────────────────────────────────────────────────────────────

    /**
     * POST /api/kuis/publish/{settings}
     */
    public function publish(KuisSettings $settings)
    {
        $jumlahSoal = KuisTik::where('kuis_settings_id', $settings->id)->count();

        if ($jumlahSoal === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kuis harus memiliki minimal 1 soal sebelum dipublish.',
            ], 422);
        }

        $settings->update(['status' => 'published', 'published_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Kuis berhasil dipublish!',
            'status' => 'published',
            'published_at' => $settings->published_at->format('d M Y, H:i'),
        ]);
    }

    /**
     * POST /api/kuis/unpublish/{settings}
     */
    public function unpublish(KuisSettings $settings)
    {
        $settings->update(['status' => 'draft', 'published_at' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Kuis dikembalikan ke Draft.',
            'status' => 'draft',
        ]);
    }
}
