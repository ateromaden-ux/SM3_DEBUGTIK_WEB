<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MateriBelajar;
use App\Models\LabPraktik;
use Illuminate\Http\Request;

class LabApiController extends Controller
{
    public function getLab($materi_id)
    {
        $lab = LabPraktik::where('materi_id', $materi_id)->first();

        if (!$lab) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lab praktik tidak ditemukan untuk materi ini'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $lab->id,
                'id_lab' => $lab->id_lab,
                'deskripsi' => $lab->deskripsi_kasus,
                'kode_awal' => $lab->kode_soal_awal,
                'tingkat_kesulitan' => $lab->tingkat_kesulitan,
                'poin_max' => $lab->poin_max,
                'test_cases' => $lab->test_cases ?? []
            ]
        ]);
    }

    public function submitLab(Request $request, $materi_id)
    {
        $lab = LabPraktik::where('materi_id', $materi_id)->first();
        
        if (!$lab) {
            return response()->json(['status' => 'error', 'message' => 'Lab not found'], 404);
        }

        $kode_siswa = $request->input('kode');
        
        // Logika evaluasi sederhana (misal: cek string match solusi_fix)
        // Idealnya pakai sandbox runner, tapi untuk MVP cek string match / regex
        $is_correct = str_contains($kode_siswa, $lab->solusi_fix);
        $poin = $is_correct ? $lab->poin_max : 0;

        // Simpan progress
        $user = $request->user();
        if ($user && $user->siswa) {
            $user->siswa->progressBelajar()->updateOrCreate(
                ['materi_id' => $materi_id],
                [
                    'status_lab' => $is_correct ? 'selesai' : 'proses',
                    'nilai_lab' => $poin,
                    'terakhir_dipelajari' => now()
                ]
            );
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'is_correct' => $is_correct,
                'poin_dapat' => $poin,
                'feedback' => $is_correct ? 'Luar biasa! Bug berhasil diperbaiki.' : 'Hmm, sepertinya kodenya masih ada bug. Coba lagi!'
            ]
        ]);
    }
}
