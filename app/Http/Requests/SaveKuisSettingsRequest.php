<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveKuisSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'materi_id' => ['required', 'exists:materi_belajar,id'],
            'id_kuis' => ['required', 'string', 'max:100'],
            'waktu_per_soal' => ['required', 'integer', 'min:1', 'max:3600'],
            'satuan_waktu' => ['required', 'in:detik,menit,jam'],
            'kkm' => ['required', 'integer', 'min:0', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_kuis.required' => 'ID Kuis wajib diisi.',
            'waktu_per_soal.required' => 'Waktu per soal wajib diisi.',
            'kkm.required' => 'KKM wajib diisi.',
        ];
    }
}
