<?php

namespace App\Exports;

use App\Models\Format5;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Format5Export implements FromQuery, WithHeadings
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
                'ID Format 5',
                'Kecamatan',
                'Kelurahan',
                'Posyandu',
                'Tahun Pendataan',
                'Bulan',
                'Bayi Laki-laki',
                'Bayi Perempuan',
                'Balita Laki-laki',
                'Balita Perempuan',
                'WUS',
                'PUS',
                'Ibu Hamil',
                'Ibu Menyusui',
                'PKK',
                'PLKB',
                'Medis',
                'Keterangan',
            ];
        }

    public function query()
    {
        return Format5::query()
                ->where('kecamatan', $this->kecamatan)
                ->where('kelurahan', $this->kelurahan)
                ->where('posyandu', $this->posyandu)
                ->where('tahun_pendataan', $this->tahun);
    }
}
