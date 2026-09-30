<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMateriRequest;
use App\Http\Requests\UpdateMateriRequest;
use App\Models\Guru;
use App\Models\KuisTik;
use App\Models\LabPraktik;
use App\Models\MateriBelajar;
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
        $field = $request->query('field');
        $value = $request->query('value');
        $excludeId = $request->query('exclude_id');

        if (! in_array($field, ['id_materi', 'judul']) || ! $value) {
            return response()->json(['duplicate' => false]);
        }

        $query = MateriBelajar::where($field, $value);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return response()->json(['duplicate' => $query->exists()]);
    }

    /**
     * POST /api/kelola-materi
     */
    public function store(StoreMateriRequest $request)
    {
        $validated = $request->validated();

        $validated['guru_id'] = $this->getGuru()->id;
        $validated['published'] = true;
        $validated['deskripsi'] = $validated['deskripsi'] ?? null;
        $validated['konten'] = $validated['konten'] ?? null;
        $validated['tingkat_kesulitan'] = $validated['tingkat_kesulitan'] ?? 1;

        $materi = MateriBelajar::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil ditambahkan',
            'data' => $materi->load(['kuis', 'labPraktik']),
        ], 201);
    }

    /**
     * PUT /api/kelola-materi/{materi}
     */
    public function update(UpdateMateriRequest $request, MateriBelajar $materi)
    {
        $materi->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil diperbarui',
            'data' => $materi->fresh()->load(['kuis', 'labPraktik']),
        ]);
    }

    /**
     * DELETE /api/kelola-materi/{materi}
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
     */
    public function getMetrics()
    {
        $guru = $this->getGuru();
        $materis = MateriBelajar::where('guru_id', $guru->id)->get();
        $ids = $materis->pluck('id');

        return response()->json([
            'success' => true,
            'data' => [
                'total_modul' => $materis->count(),
                'total_kuis' => KuisTik::whereIn('materi_id', $ids)->count(),
                'total_lab' => LabPraktik::whereIn('materi_id', $ids)->count(),
                'siswa_online' => 36,
            ],
        ]);
    }
}
