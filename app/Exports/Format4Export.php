<?php

namespace App\Exports;

use App\Models\Format4;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Format4Export implements FromQuery, WithHeadings
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
                'ID Format 4',
                'Kecamatan',
                'Kelurahan',
                'Posyandu',
                'Tahun Pendataan',
                'Nama Ibu',
                'Nama Bayi',
                'Umur',
                'Kelompok Dasawisma',
                'Tanggal Daftar',
                'Umur Kehamilan',
                'LILA',
                'PMT Pemulihan',
                'Keterangan',
            ];
        }

    public function query()
    {
        return Format4::query()
                ->where('kecamatan', $this->kecamatan)
                ->where('kelurahan', $this->kelurahan)
                ->where('posyandu', $this->posyandu)
                ->where('tahun_pendataan', $this->tahun);
    }
}