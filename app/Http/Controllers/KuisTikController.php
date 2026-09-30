<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\KuisSettings;
use App\Models\KuisTik;
use App\Models\MateriBelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class KuisTikController extends Controller
{
    /**
     * POST /api/kuis/publish/{materi}
     * Publish kuis — minimal harus ada 1 soal.
     */
    public function publish(MateriBelajar $materi)
    {
        $settings = KuisSettings::where('materi_id', $materi->id)->first();

        if (! $settings) {
            return response()->json(['success' => false, 'message' => 'Pengaturan kuis belum diisi.'], 422);
        }

        $jumlahSoal = KuisTik::where('materi_id', $materi->id)->count();
        if ($jumlahSoal === 0) {
            return response()->json(['success' => false, 'message' => 'Kuis harus memiliki minimal 1 soal sebelum dipublish.'], 422);
        }

        $settings->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kuis berhasil dipublish! Siswa sekarang dapat mengerjakan kuis ini.',
            'status' => 'published',
            'published_at' => $settings->published_at->format('d M Y, H:i'),
        ]);
    }

    /**
     * POST /api/kuis/unpublish/{materi}
     * Kembalikan ke draft.
     */
    public function unpublish(MateriBelajar $materi)
    {
        $settings = KuisSettings::where('materi_id', $materi->id)->first();

        if (! $settings) {
            return response()->json(['success' => false, 'message' => 'Pengaturan kuis tidak ditemukan.'], 404);
        }

        $settings->update([
            'status' => 'draft',
            'published_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kuis dikembalikan ke Draft.',
            'status' => 'draft',
        ]);
    }

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
            ->with('kuis')
            ->orderBy('created_at', 'desc')
            ->get();

        // Load existing settings untuk materi ini (bisa null kalau belum pernah diset)
        $settings = KuisSettings::where('materi_id', $materi->id)->first();

        return view('kuis.index', compact('guru', 'materi', 'soalList', 'allMateri', 'settings'));
    }

    /**
     * GET /api/kuis/settings?materi_id=X
     * Ambil settings kuis untuk satu materi.
     */
    public function getSettings(Request $request)
    {
        $materiId = $request->query('materi_id');
        $settings = KuisSettings::where('materi_id', $materiId)->first();

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }

    /**
     * POST /api/kuis/settings
     * Simpan (create atau update) settings kuis untuk satu materi.
     */
    public function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'materi_id' => 'required|exists:materi_belajar,id',
            'id_kuis' => 'required|string|max:100',
            'waktu_per_soal' => 'required|integer|min:1|max:3600',
            'satuan_waktu' => 'required|in:detik,menit,jam',
            'kkm' => 'required|integer|min:0|max:100',
        ], [
            'id_kuis.required' => 'ID Kuis wajib diisi.',
            'waktu_per_soal.required' => 'Waktu per soal wajib diisi.',
            'kkm.required' => 'KKM wajib diisi.',
        ]);

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

    /**
     * GET /api/kuis/check-id?id_soal=X&exclude_id=Y
     * Cek apakah id_soal sudah dipakai.
     */
    public function checkId(Request $request)
    {
        $idSoal = $request->query('id_soal');
        $excludeId = $request->query('exclude_id');

        $query = KuisTik::where('id_soal', $idSoal);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
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
    public function store(Request $request)
    {
        $materiId = $request->input('materi_id');

        $validated = $request->validate([
            'materi_id' => 'required|exists:materi_belajar,id',
            'id_soal' => 'nullable|string|unique:kuis_tik,id_soal',
            'pertanyaan' => [
                'required',
                'string',
                Rule::unique('kuis_tik', 'pertanyaan')
                    ->where('materi_id', $materiId),
            ],
            'tipe' => 'required|in:pilihan_ganda,multiple_answer,essay',
            'opsi_jawaban' => 'nullable|array|min:2',
            'kunci_jawaban' => 'required|array|min:1',
            'kunci_jawaban.*' => 'string',
            'penjelasan_opsi' => 'nullable|array',
            'poin' => 'required|integer|min:1|max:200',
            'urutan' => 'nullable|integer|min:1',
        ], [
            'id_soal.unique' => 'ID soal sudah digunakan.',
            'pertanyaan.unique' => 'Pertanyaan ini sudah ada di kuis materi ini.',
            'poin.required' => 'Poin wajib diisi.',
        ]);

        // Auto-generate id_soal dari id_kuis + nomor urut
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

        if (! isset($validated['urutan'])) {
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
    public function update(Request $request, KuisTik $kuis)
    {
        $validated = $request->validate([
            'pertanyaan' => [
                'sometimes',
                'required',
                'string',
                Rule::unique('kuis_tik', 'pertanyaan')
                    ->ignore($kuis->id)
                    ->where('materi_id', $kuis->materi_id),
            ],
            'tipe' => 'sometimes|in:pilihan_ganda,multiple_answer,essay',
            'opsi_jawaban' => 'nullable|array|min:2',
            'kunci_jawaban' => 'sometimes|required|array|min:1',
            'kunci_jawaban.*' => 'string',
            'penjelasan_opsi' => 'nullable|array',
            'poin' => 'sometimes|integer|min:1|max:200',
            'urutan' => 'sometimes|integer|min:1',
        ], [
            'pertanyaan.unique' => 'Pertanyaan ini sudah ada di kuis materi ini.',
        ]);

        $kuis->update($validated);

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

        return response()->json(['success' => true, 'message' => 'Soal kuis berhasil dihapus']);
    }
}
