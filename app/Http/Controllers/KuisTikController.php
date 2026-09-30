<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveKuisSettingsRequest;
use App\Http\Requests\StoreKuisRequest;
use App\Http\Requests\UpdateKuisRequest;
use App\Models\Guru;
use App\Models\KuisSettings;
use App\Models\KuisTik;
use App\Models\MateriBelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuisTikController extends Controller
{
    // ─── HALAMAN ──────────────────────────────────────────────────────────────

    /**
     * GET /kuis/{materi}
     * Halaman fullpage kelola soal kuis untuk satu materi.
     */
    public function showPage(MateriBelajar $materi)
    {
        $guru = Auth::guard('guru')->user() ?? Guru::first();

        $soalList = KuisTik::where('materi_id', $materi->id)
            ->orderBy('urutan')
            ->get();

        $allMateri = MateriBelajar::where('guru_id', $guru->id)
            ->with(['kuis', 'kuisSettings'])
            ->orderBy('created_at', 'desc')
            ->get();

        $settings = KuisSettings::where('materi_id', $materi->id)->first();

        return view('kuis.index', compact('guru', 'materi', 'soalList', 'allMateri', 'settings'));
    }

    // ─── SETTINGS ─────────────────────────────────────────────────────────────

    /**
     * GET /api/kuis/settings?materi_id=X
     */
    public function getSettings(Request $request)
    {
        $settings = KuisSettings::where('materi_id', $request->query('materi_id'))->first();

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }

    /**
     * POST /api/kuis/settings
     */
    public function saveSettings(SaveKuisSettingsRequest $request)
    {
        $validated = $request->validated();

        // Cek duplikasi id_kuis (exclude materi ini sendiri)
        $duplicate = KuisSettings::where('id_kuis', $validated['id_kuis'])
            ->where('materi_id', '!=', $validated['materi_id'])
            ->exists();

        if ($duplicate) {
            return response()->json([
                'success' => false,
                'errors' => ['id_kuis' => ['ID Kuis sudah digunakan oleh materi lain.']],
            ], 422);
        }

        $settings = KuisSettings::updateOrCreate(
            ['materi_id' => $validated['materi_id']],
            [
                'id_kuis' => $validated['id_kuis'],
                'waktu_per_soal' => $validated['waktu_per_soal'],
                'satuan_waktu' => $validated['satuan_waktu'],
                'kkm' => $validated['kkm'],
            ]
        );

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
     * GET /api/kuis?materi_id=X
     */
    public function index(Request $request)
    {
        $materiId = $request->query('materi_id');

        if (! $materiId) {
            return response()->json(['success' => false, 'message' => 'materi_id wajib diisi'], 422);
        }

        $soal = KuisTik::where('materi_id', $materiId)->orderBy('urutan')->get();

        return response()->json(['success' => true, 'data' => $soal, 'total' => $soal->count()]);
    }

    /**
     * POST /api/kuis
     * id_soal di-generate otomatis dari id_kuis + nomor urut jika tidak dikirim.
     */
    public function store(StoreKuisRequest $request)
    {
        $validated = $request->validated();

        // Auto-generate id_soal
        if (empty($validated['id_soal'])) {
            $settings = KuisSettings::where('materi_id', $validated['materi_id'])->first();
            $prefix = $settings ? $settings->id_kuis : 'SOAL';
            $next = KuisTik::where('materi_id', $validated['materi_id'])->count() + 1;
            $validated['id_soal'] = $prefix.'-'.str_pad($next, 2, '0', STR_PAD_LEFT);

            // Pastikan tidak duplikat (edge case)
            while (KuisTik::where('id_soal', $validated['id_soal'])->exists()) {
                $next++;
                $validated['id_soal'] = $prefix.'-'.str_pad($next, 2, '0', STR_PAD_LEFT);
            }
        }

        if (empty($validated['urutan'])) {
            $validated['urutan'] = KuisTik::where('materi_id', $validated['materi_id'])->max('urutan') + 1;
        }

        $soal = KuisTik::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Soal kuis berhasil ditambahkan',
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
            'message' => 'Soal kuis berhasil diperbarui',
            'data' => $kuis->fresh(),
        ]);
    }

    /**
     * DELETE /api/kuis/{kuis}
     */
    public function destroy(KuisTik $kuis)
    {
        $kuis->delete();

        return response()->json([
            'success' => true,
            'message' => 'Soal kuis berhasil dihapus',
        ]);
    }

    // ─── PUBLISH ──────────────────────────────────────────────────────────────

    /**
     * POST /api/kuis/publish/{materi}
     */
    public function publish(MateriBelajar $materi)
    {
        $settings = KuisSettings::where('materi_id', $materi->id)->first();

        if (! $settings) {
            return response()->json(['success' => false, 'message' => 'Pengaturan kuis belum diisi.'], 422);
        }

        if (KuisTik::where('materi_id', $materi->id)->count() === 0) {
            return response()->json(['success' => false, 'message' => 'Kuis harus memiliki minimal 1 soal sebelum dipublish.'], 422);
        }

        $settings->update(['status' => 'published', 'published_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Kuis berhasil dipublish! Siswa sekarang dapat mengerjakan kuis ini.',
            'status' => 'published',
            'published_at' => $settings->published_at->format('d M Y, H:i'),
        ]);
    }

    /**
     * POST /api/kuis/unpublish/{materi}
     */
    public function unpublish(MateriBelajar $materi)
    {
        $settings = KuisSettings::where('materi_id', $materi->id)->first();

        if (! $settings) {
            return response()->json(['success' => false, 'message' => 'Pengaturan kuis tidak ditemukan.'], 404);
        }

        $settings->update(['status' => 'draft', 'published_at' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Kuis dikembalikan ke Draft.',
            'status' => 'draft',
        ]);
    }
}
