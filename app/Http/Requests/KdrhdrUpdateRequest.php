<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KdrhdrUpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'id_posyandu'   => ['required', 'integer', 'exists:duspy,id_posyandu'],
            'bulan_tahun'   => ['required', 'date'],
            'pkk'           => ['required', 'integer', 'min:0'],
            'plkb'          => ['required', 'integer', 'min:0'],
            'medis'         => ['required', 'integer', 'min:0'],
        ];
    }
}