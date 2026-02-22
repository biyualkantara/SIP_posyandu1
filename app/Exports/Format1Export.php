<?php

namespace App\Exports;

use App\Models\Format1;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Format1Export implements FromQuery, WithHeadings
{
    private $kecamatan, $kelurahan, $posyandu, $tahun;

    public function __construct(string $kecamatan, string $kelurahan, string $posyandu, string $tahun) {
        $this->kecamatan = $kecamatan;
        $this->kelurahan = $kelurahan;
        $this->posyandu = $posyandu;
        $this->tahun = $tahun;
    }

    public function headings(): array
    {
        return [
            'ID Format 1',
            'Kecamatan',
            'Kelurahan',
            'Posyandu',
            'Tahun Pendataan',
            'Nama Ibu',
            'Nama Ayah',
            'Nama Bayi',
            'Tanggal Lahir',
            'Tanggal Bayi Meninggal',
            'Tanggal Ibu Meninggal',
            'Keterangan',
        ];
    }

    public function query() {
        return Format1::query()
                ->where('kecamatan', $this->kecamatan)
                ->where('kelurahan', $this->kelurahan)
                ->where('posyandu', $this->posyandu)
                ->where('tahun_pendataan', $this->tahun);
}
}
