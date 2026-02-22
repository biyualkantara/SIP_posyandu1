<?php

namespace App\Exports;

use App\Models\Format2;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Format2Export implements FromQuery, WithHeadings
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
                'ID Format 2',
                'Kecamatan',
                'Kelurahan',
                'Posyandu',
                'Tahun Pendataan',
                'ID Bayi',
                'Nama Bayi',
                'Jenis Kelamin',
                'Tanggal Lahir',
                'Berat Badan Lahir',
                'Keterangan',
            ];
        }

    public function query()
    {
        return Format2::query()
                ->where('kecamatan', $this->kecamatan)
                ->where('kelurahan', $this->kelurahan)
                ->where('posyandu', $this->posyandu)
                ->where('tahun_pendataan', $this->tahun);
    }
}
