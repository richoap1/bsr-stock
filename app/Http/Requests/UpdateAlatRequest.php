<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'superadmin';
    }

    public function rules(): array
    {
        return [
            'nama_alat' => 'required|string|max:255',
            'serial_number' => ['nullable', 'string', 'max:255', Rule::unique('alats')->ignore($this->alat)],
            'jumlah' => 'required|integer|min:0',
            'tgl_kalibrasi_terakhir' => 'nullable|date',
        ];
    }
}