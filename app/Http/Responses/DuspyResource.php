<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DuspyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nama_posyandu' => $this->nama_posyandu,
            'strata_psy' => $this->strata_psy,
            'alamat_posyandu' => $this->alamat_posyandu,
            'id_kel' => $this->id_kel,
            'pj_umum' => $this->pj_umum,
            'pj_operasional' => $this->pj_operasional,
            'ketuplak' => $this->ketuplak,
            'sekretaris' => $this->sekretaris,
            'int_paud' => (bool) $this->int_paud,
            'int_bkd' => (bool) $this->int_bkd,
            'int_terpadu' => (bool) $this->int_terpadu,
            'kader_aktif' => $this->kader_aktif,
            'kader_taktif' => $this->kader_taktif,
            'ptgs_kb' => $this->ptgs_kb,
            'ptgs_medis' => $this->ptgs_medis,
            'ptgs_bidan' => $this->ptgs_bidan,
            'foto' => $this->foto,
        ];
    }
}
