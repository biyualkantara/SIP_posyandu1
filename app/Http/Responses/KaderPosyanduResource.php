<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KaderPosyanduResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'duspy_id' => $this->duspy_id,
            'posyandu_nama' => $this->duspy->nama_posyandu ?? null,
            'nama' => $this->nama,
            'umur' => $this->umur,
            'jabatan' => $this->jabatan,
            'no_hp' => $this->no_hp,
            'alamat' => $this->alamat,
            'status' => $this->status,
            'foto' => $this->foto,
        ];
    }
}
