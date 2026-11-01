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
            'guru_id' => ['nullable', 'exists:gurus,id'],
            'nama_kuis' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'id_kuis' => ['required', 'string', 'max:100'],
            'kkm' => ['required', 'integer', 'min:0', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kuis.required' => 'Nama kuis wajib diisi.',
            'id_kuis.required' => 'ID Kuis wajib diisi.',
            'kkm.required' => 'KKM wajib diisi.',
        ];
    }
}
