<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKuisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kuis = $this->route('kuis');

        return [
            'pertanyaan' => [
                'sometimes',
                'required',
                'string',
                $kuis->materi_id
                    ? Rule::unique('kuis_tik', 'pertanyaan')->ignore($kuis->id)->where('materi_id', $kuis->materi_id)
                    : Rule::unique('kuis_tik', 'pertanyaan')->ignore($kuis->id)->where('kuis_settings_id', $kuis->kuis_settings_id),
            ],
            'tipe' => ['sometimes', 'in:pilihan_ganda,multiple_answer,essay'],
            'opsi_jawaban' => ['nullable', 'array', 'min:2'],
            'kunci_jawaban' => ['sometimes', 'required', 'array', 'min:1'],
            'kunci_jawaban.*' => ['string'],
            'penjelasan_opsi' => ['nullable', 'array'],
            'poin' => ['sometimes', 'integer', 'min:1', 'max:200'],
            'waktu' => ['sometimes', 'integer', 'min:1', 'max:3600'],
            'urutan' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'pertanyaan.unique' => 'Pertanyaan ini sudah ada di kuis ini.',
        ];
    }
}
