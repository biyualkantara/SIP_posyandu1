<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class Format4Export implements FromCollection, WithHeadings, WithMapping
{
    protected $id_kecamatan;
    protected $id_kelurahan;
    protected $id_posyandu;
    protected $tahun;

    public function __construct($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun)
    {
        $this->id_kecamatan = $id_kecamatan;
        $this->id_kelurahan = $id_kelurahan;
        $this->id_posyandu = $id_posyandu;
        $this->tahun = $tahun;
    }

    public function headings(): array
    {
        return [
            'NO',
            'NAMA IBU HAMIL',
            'UMUR',
            'KELOMPOK DASA WISMA',
            'TGL DAFTAR',
            'UMUR KEHAMILAN',
            'HAMIL KE',
            'PMT PEMULIHAN',
            'LILA (cm)',
            'KETERANGAN',
            'KECAMATAN',
            'KELURAHAN',
            'POSYANDU',
            'TAHUN'
        ];
    }

    public function collection()
    {
        $query = DB::table('bumil as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'b.id_bumil',
                'w.nama_wuspus as nama_ibu',
                'w.umur',
                'w.klmpk_dasawisma',
                'b.tgl_daftar',
                'b.umur_kehamilan',
                'b.hamil_ke',
                'b.pmt_pemulihan',
                'b.lila',
                'b.ket',
                'kec.nama_kec',
                'kel.nama_kel',
                'd.nama_posyandu',
                DB::raw('YEAR(b.tgl_daftar) as tahun')
            ]);

        // Filter kecamatan
        if (!empty($this->id_kecamatan)) {
            $query->where('kec.id_kec', $this->id_kecamatan);
        }

        // Filter kelurahan
        if (!empty($this->id_kelurahan)) {
            $query->where('kel.id_kel', $this->id_kelurahan);
        }

        // Filter posyandu
        if (!empty($this->id_posyandu)) {
            $query->where('d.id_posyandu', $this->id_posyandu);
        }

        // Filter tahun
        if (!empty($this->tahun) && $this->tahun !== 'All') {
            $query->whereYear('b.tgl_daftar', $this->tahun);
        }

        return $query->get();
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->nama_ibu ?? '-',
            $row->umur ?? '-',
            $row->klmpk_dasawisma ?? '-',
            $row->tgl_daftar ? Carbon::parse($row->tgl_daftar)->format('d-m-Y') : '-',
            $row->umur_kehamilan ?? '-',
            $row->hamil_ke ?? '-',
            $row->pmt_pemulihan ?? '-',
            $row->lila ?? '-',
            $row->ket ?? '-',
            $row->nama_kec ?? '-',
            $row->nama_kel ?? '-',
            $row->nama_posyandu ?? '-',
            $row->tahun ?? '-'
        ];
    }
}