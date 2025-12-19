<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDuspyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_posyandu' => 'required|string|max:255',
            'strata_psy' => 'required|string|max:255',
            'alamat_posyandu' => 'required|string',
            'id_kel' => 'required|integer',
            'pj_umum' => 'nullable|string|max:255',
            'pj_operasional' => 'nullable|string|max:255',
            'ketuplak' => 'nullable|string|max:255',
            'sekretaris' => 'nullable|string|max:255',
            'int_paud' => 'required|boolean',
            'int_bkd' => 'required|boolean',
            'int_terpadu' => 'required|boolean',
            'kader_aktif' => 'required|integer',
            'kader_taktif' => 'required|integer',
            'ptgs_kb' => 'nullable|string|max:255',
            'ptgs_medis' => 'nullable|string|max:255',
            'ptgs_bidan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
