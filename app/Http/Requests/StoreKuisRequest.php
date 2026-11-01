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
            'waktu' => ['required', 'integer', 'min:1', 'max:3600'],
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
}
