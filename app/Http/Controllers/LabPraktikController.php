<?php

namespace App\Http\Controllers;

use App\Models\LabPraktik;
use App\Models\MateriBelajar;
use Illuminate\Http\Request;

class LabPraktikController extends Controller
{
    /**
     * GET /api/lab?materi_id=X
     * Ambil semua lab praktik untuk materi tertentu.
     */
    public function index(Request $request)
    {
        $materiId = $request->query('materi_id');

        if (!$materiId) {
            return response()->json(['success' => false, 'message' => 'materi_id wajib diisi'], 422);
        }

        $labs = LabPraktik::where('materi_id', $materiId)->get();

        return response()->json([
            'success' => true,
            'data'    => $labs,
            'total'   => $labs->count(),
        ]);
    }

    /**
     * POST /api/lab
     * Tambah lab praktik baru ke materi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'materi_id'         => 'required|exists:materi_belajar,id',
            'id_lab'            => 'required|string|unique:lab_praktik,id_lab',
            'deskripsi_kasus'   => 'required|string',
            'kode_soal_awal'    => 'required|string',
            'bug_target'        => 'required|string',
            'solusi_fix'        => 'required|string',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
            'poin_max'          => 'integer|min:10|max:200',
            'test_cases'        => 'nullable|array',
        ]);

        $lab = LabPraktik::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lab praktik berhasil ditambahkan',
            'data'    => $lab,
        ], 201);
    }

    /**
     * PUT /api/lab/{lab}
     * Update lab praktik.
     */
    public function update(Request $request, LabPraktik $lab)
    {
        $validated = $request->validate([
            'deskripsi_kasus'   => 'string',
            'kode_soal_awal'    => 'string',
            'bug_target'        => 'string',
            'solusi_fix'        => 'string',
            'tingkat_kesulitan' => 'in:mudah,sedang,sulit',
            'poin_max'          => 'integer|min:10|max:200',
            'test_cases'        => 'nullable|array',
        ]);

        $lab->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lab praktik berhasil diperbarui',
            'data'    => $lab->fresh(),
        ]);
    }

    /**
     * DELETE /api/lab/{lab}
     * Hapus lab praktik.
     */
    public function destroy(LabPraktik $lab)
    {
        $lab->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lab praktik berhasil dihapus',
        ]);
    }
}
