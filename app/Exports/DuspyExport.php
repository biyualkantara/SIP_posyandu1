<?php

namespace App\Exports;

use App\Models\Duspy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DuspyExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Duspy::select(
            'nama_posyandu',
            'strata_psy',
            'alamat_posyandu',
            'id_kel',
            'pj_umum',
            'pj_operasional',
            'ketuplak',
            'sekretaris',
            'int_paud',
            'int_bkd',
            'int_terpadu',
            'kader_aktif',
            'kader_taktif',
            'ptgs_kb',
            'ptgs_medis',
            'ptgs_bidan'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nama Posyandu',
            'Strata',
            'Alamat Posyandu',
            'ID Kelurahan',
            'PJ Umum',
            'PJ Operasional',
            'Ketua Pelaksana',
            'Sekretaris',
            'Integrasi PAUD',
            'Integrasi BKD',
            'Integrasi Terpadu',
            'Kader Aktif',
            'Kader Tidak Aktif',
            'Petugas KB',
            'Petugas Medis',
            'Petugas Bidan',
        ];
    }
}
