<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'superadmin';
    }

    public function rules(): array
    {
        return [
            'nama_alat' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:alats',
            'jumlah' => 'required|integer|min:0',
            'tgl_datang_alat' => 'required|date',
            'tgl_kalibrasi_terakhir' => 'nullable|date',
        ];
    }
}