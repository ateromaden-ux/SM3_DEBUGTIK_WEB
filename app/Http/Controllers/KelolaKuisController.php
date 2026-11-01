<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\KuisSettings;
use App\Models\MateriBelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelolaKuisController extends Controller
{
    /**
     * GET /kelola-kuis
     */
    public function index()
    {
        $guru = Auth::guard('guru')->user() ?? Guru::first();

        // Semua kuis milik guru ini
        $kuisList = KuisSettings::where('guru_id', $guru->id)
            ->with(['materi', 'soal'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Materi untuk dropdown (opsional saat buat kuis baru)
        $materiList = MateriBelajar::where('guru_id', $guru->id)
            ->orderBy('judul')
            ->get();

        $stats = [
            'total_kuis' => $kuisList->count(),
            'total_soal' => $kuisList->sum(fn ($k) => $k->soal->count()),
            'total_published' => $kuisList->filter(fn ($k) => $k->isPublished())->count(),
            'total_draft' => $kuisList->filter(fn ($k) => $k->isDraft())->count(),
        ];

        return view('kelola-kuis.index', compact('guru', 'kuisList', 'materiList', 'stats'));
    }

    /**
     * POST /kelola-kuis
     * Buat kuis baru (standalone atau terikat materi).
     */
    public function store(Request $request)
    {
        $guru = Auth::guard('guru')->user() ?? Guru::first();

        $validated = $request->validate([
            'nama_kuis' => ['required', 'string', 'max:150'],
            'id_kuis' => ['required', 'string', 'max:100', 'unique:kuis_settings,id_kuis'],
            'deskripsi' => ['nullable', 'string'],
            'kkm' => ['required', 'integer', 'min:0', 'max:100'],
        ], [
            'nama_kuis.required' => 'Nama kuis wajib diisi.',
            'id_kuis.unique' => 'ID Kuis sudah digunakan, pilih yang lain.',
        ]);

        $validated['guru_id'] = $guru->id;
        $validated['status'] = 'draft';

        $settings = KuisSettings::create($validated);

        return redirect()
            ->route('kuis.page', $settings->id)
            ->with('success', 'Kuis "'.$settings->nama_kuis.'" berhasil dibuat. Mulai tambah soal!');
    }
}
