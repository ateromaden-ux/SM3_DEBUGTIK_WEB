<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKuisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $materiId = $this->input('materi_id');
        $kuisSettingsId = $this->input('kuis_settings_id');

        return [
            'materi_id' => ['nullable', 'exists:materi_belajar,id'],
            'kuis_settings_id' => ['nullable', 'exists:kuis_settings,id'],
            'id_soal' => ['nullable', 'string', 'unique:kuis_tik,id_soal'],
            'pertanyaan' => [
                'required',
                'string',
                // unique per materi jika ada, atau per kuis_settings jika standalone
                $materiId
                    ? Rule::unique('kuis_tik', 'pertanyaan')->where('materi_id', $materiId)
                    : Rule::unique('kuis_tik', 'pertanyaan')->where('kuis_settings_id', $kuisSettingsId),
            ],
            'tipe' => ['required', 'in:pilihan_ganda,multiple_answer,essay'],
            'opsi_jawaban' => ['nullable', 'array', 'min:2'],
            'kunci_jawaban' => ['required', 'array', 'min:1'],
            'kunci_jawaban.*' => ['string'],
            'penjelasan_opsi' => ['nullable', 'array'],
            'poin' => ['required', 'integer', 'min:1', 'max:200'],
            'waktu' => ['nullable', 'integer', 'min:1', 'max:3600'],
            'urutan' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'pertanyaan.unique' => 'Pertanyaan ini sudah ada di kuis ini.',
            'poin.required' => 'Poin wajib diisi.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Skip essay soal
            if ($this->input('tipe') === 'essay') {
                return;
            }

            $kuisSettingsId = $this->input('kuis_settings_id');
            $materiId = $this->input('materi_id');
            $kunciJawaban = $this->input('kunci_jawaban');
            $opsiJawaban = $this->input('opsi_jawaban');

            if (!$kunciJawaban || !$opsiJawaban) {
                return;
            }

            // Cari index huruf dari kunci jawaban
            $kunciIndex = [];
            foreach ($kunciJawaban as $kunci) {
                $index = array_search($kunci, $opsiJawaban);
                if ($index !== false) {
                    $kunciIndex[] = $index;
                }
            }

            if (empty($kunciIndex)) {
                return;
            }

            // Ambil semua soal existing dalam kuis yang sama
            $query = \App\Models\KuisTik::query();
            if ($kuisSettingsId) {
                $query->where('kuis_settings_id', $kuisSettingsId);
            } elseif ($materiId) {
                $query->where('materi_id', $materiId)->whereNull('kuis_settings_id');
            } else {
                return;
            }

            $existingSoal = $query->where('tipe', '!=', 'essay')->get();

            // Hitung distribusi kunci jawaban yang sudah ada
            $distribusi = [0 => 0, 1 => 0, 2 => 0, 3 => 0]; // index 0=A, 1=B, 2=C, 3=D

            foreach ($existingSoal as $soal) {
                $opsi = $soal->opsi_jawaban ?? [];
                $kunci = $soal->kunci_jawaban ?? [];
                
                foreach ($kunci as $k) {
                    $idx = array_search($k, $opsi);
                    if ($idx !== false && $idx < 4) {
                        $distribusi[$idx]++;
                    }
                }
            }

            // Tambahkan soal baru ke distribusi
            foreach ($kunciIndex as $idx) {
                if ($idx < 4) {
                    $distribusi[$idx]++;
                }
            }

            $totalSoal = $existingSoal->count() + 1;

            // Cek apakah ada satu opsi yang dominan (>60% dari total soal)
            $maxDistribusi = max($distribusi);
            $persentase = ($maxDistribusi / $totalSoal) * 100;

            if ($totalSoal >= 5 && $persentase > 60) {
                $huruf = ['A', 'B', 'C', 'D'];
                $dominanIndex = array_search($maxDistribusi, $distribusi);
                $validator->errors()->add(
                    'kunci_jawaban',
                    "Distribusi jawaban tidak merata. Opsi {$huruf[$dominanIndex]} sudah muncul {$maxDistribusi}x dari {$totalSoal} soal ({$persentase}%). Variasikan jawaban benar agar siswa tidak mudah menebak pola."
                );
            }
        });
    }
}
