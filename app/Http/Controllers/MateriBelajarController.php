<?php

namespace App\Http\Controllers;

use App\Models\MateriBelajar;
use App\Models\KuisTik;
use App\Models\LabPraktik;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriBelajarController extends Controller
{
    /**
     * Ambil guru yang sedang login, fallback ke guru pertama (dummy mode).
     */
    private function getGuru(): Guru
    {
        return Auth::guard('guru')->user() ?? Guru::first();
    }

    /**
     * GET /api/kelola-materi/check?field=id_materi|judul&value=X&exclude_id=Y
     * Cek duplikasi real-time dari form.
     */
    public function checkDuplicate(Request $request)
    {
        $field     = $request->query('field');
        $value     = $request->query('value');
        $excludeId = $request->query('exclude_id');

        if (!in_array($field, ['id_materi', 'judul']) || !$value) {
            return response()->json(['duplicate' => false]);
        }

        $query = MateriBelajar::where($field, $value);
        if ($excludeId) $query->where('id', '!=', $excludeId);

        return response()->json(['duplicate' => $query->exists()]);
    }

    /**
     * POST /api/kelola-materi
     * Tambah materi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_materi'         => ['required', 'regex:/^MAT-[A-Z]+-\d+$/', 'unique:materi_belajar,id_materi'],
            'judul'             => 'required|string|max:255|unique:materi_belajar,judul',
            'deskripsi'         => 'required|string',
            'kategori'          => 'required|in:HTML Dasar,CSS Dasar,JS Dasar,Web Responsif',
            'level'             => 'required|in:Pemula,Menengah,Lanjutan',
            'konten'            => 'nullable|string',
            'estimasi_waktu'    => 'required|integer|min:10|max:240',
            'tingkat_kesulitan' => 'integer|in:1,2,3',
        ], [
            'id_materi.unique' => 'ID materi sudah digunakan, gunakan ID yang berbeda.',
            'id_materi.regex'  => 'Format ID harus MAT-[KATEGORI]-[NOMOR], contoh: MAT-JS-04.',
            'judul.unique'     => 'Judul materi ini sudah ada, gunakan judul yang berbeda.',
        ]);

        $validated['guru_id']           = $this->getGuru()->id;
        $validated['published']         = true;
        $validated['konten']            = $validated['konten'] ?? '<p>Materi ' . $validated['kategori'] . '</p>';
        $validated['tingkat_kesulitan'] = $validated['tingkat_kesulitan'] ?? 1;

        $materi = MateriBelajar::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil ditambahkan',
            'data'    => $materi->load(['kuis', 'labPraktik']),
        ], 201);
    }

    /**
     * PUT /api/kelola-materi/{materi}
     * Update materi — unique exclude diri sendiri.
     */
    public function update(Request $request, MateriBelajar $materi)
    {
        $validated = $request->validate([
            'judul'             => 'string|max:255|unique:materi_belajar,judul,' . $materi->id,
            'deskripsi'         => 'string',
            'kategori'          => 'in:HTML Dasar,CSS Dasar,JS Dasar,Web Responsif',
            'level'             => 'in:Pemula,Menengah,Lanjutan',
            'konten'            => 'string',
            'estimasi_waktu'    => 'integer|min:10|max:240',
            'tingkat_kesulitan' => 'integer|in:1,2,3',
            'published'         => 'boolean',
        ], [
            'judul.unique' => 'Judul materi ini sudah ada, gunakan judul yang berbeda.',
        ]);

        $materi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil diperbarui',
            'data'    => $materi->fresh()->load(['kuis', 'labPraktik']),
        ]);
    }

    /**
     * DELETE /api/kelola-materi/{materi}
     * Hapus materi beserta kuis dan lab-nya (cascade).
     */
    public function destroy(MateriBelajar $materi)
    {
        $materi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil dihapus',
        ]);
    }

    /**
     * GET /api/kelola-materi/metrics
     * Statistik ringkas untuk kartu metric di view kelola-materi.
     */
    public function getMetrics()
    {
        $guru    = $this->getGuru();
        $materis = MateriBelajar::where('guru_id', $guru->id)->get();
        $ids     = $materis->pluck('id');

        return response()->json([
            'success' => true,
            'data'    => [
                'total_modul'  => $materis->count(),
                'total_kuis'   => KuisTik::whereIn('materi_id', $ids)->count(),
                'total_lab'    => LabPraktik::whereIn('materi_id', $ids)->count(),
                'siswa_online' => 36,
            ],
        ]);
    }
}
