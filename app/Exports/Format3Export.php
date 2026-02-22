<?php

namespace App\Exports;

use App\Models\Format3;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Format3Export implements FromQuery, WithHeadings
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
                'ID Format 3',
                'Kecamatan',
                'Kelurahan',
                'Posyandu',
                'Tahun Pendataan',
                'Nama WUS/PUS',
                'Umur',
                'Nama Suami',
                'Tahapan KS',
                'Kelompok Dasawisma',
                'Jumlah Anak Hidup',
                'Jumlah Anak Meninggal',
                'Pengukuran LILA',
                'Kapsul Yodium',
                'Imunisasi TTI',
                'Jenis Kontrasepsi',
                'Tanggal Pergantian',
                'Keterangan',
            ];
        }

    public function query()
    {
        return Format3::query()
                ->where('kecamatan', $this->kecamatan)
                ->where('kelurahan', $this->kelurahan)
                ->where('posyandu', $this->posyandu)
                ->where('tahun_pendataan', $this->tahun);
    }
}
