<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class Format1Export implements FromCollection, WithHeadings, WithMapping
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
            'NAMA IBU',
            'NAMA AYAH',
            'NAMA BAYI',
            'TANGGAL LAHIR',
            'TANGGAL BAYI MENINGGAL',
            'TANGGAL IBU MENINGGAL',
            'KETERANGAN',
            'KECAMATAN',
            'KELURAHAN',
            'POSYANDU',
            'TAHUN'
        ];
    }

    public function collection()
    {
        $query = DB::table('bayi as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->leftJoin('bayi_wafat as bw', 'bw.id_bayi', '=', 'b.id_bayi')
            ->leftJoin('wuspus_kematians as wk', 'wk.id_wuspus', '=', 'w.id_wuspus')
            ->select([
                'w.nama_wuspus as nama_ibu',
                DB::raw("'-' as nama_ayah"),
                'b.nama_bayi',
                'b.tgl_lhr as tgl_lahir',
                'bw.tgl_kematian as tgl_meninggal_bayi',
                'wk.tgl_wafat as tgl_meninggal_ibu',
                DB::raw("CONCAT(
                    COALESCE(b.ket, ''),
                    CASE WHEN bw.ket IS NOT NULL THEN CONCAT('; Bayi: ', bw.ket) ELSE '' END,
                    CASE WHEN wk.ket IS NOT NULL THEN CONCAT('; Ibu: ', wk.ket) ELSE '' END
                ) as keterangan"),
                'kec.nama_kec',
                'kel.nama_kel',
                'd.nama_posyandu',
                DB::raw('YEAR(b.tgl_lhr) as tahun')
            ])
            ->orderBy('b.tgl_lhr', 'desc');

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
            $query->whereYear('b.tgl_lhr', $this->tahun);
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
            $row->nama_ayah ?? '-',
            $row->nama_bayi ?? '-',
            $row->tgl_lahir ? Carbon::parse($row->tgl_lahir)->format('d-m-Y') : '-',
            $row->tgl_meninggal_bayi ? Carbon::parse($row->tgl_meninggal_bayi)->format('d-m-Y') : '-',
            $row->tgl_meninggal_ibu ? Carbon::parse($row->tgl_meninggal_ibu)->format('d-m-Y') : '-',
            $row->keterangan ?? '-',
            $row->nama_kec ?? '-',
            $row->nama_kel ?? '-',
            $row->nama_posyandu ?? '-',
            $row->tahun ?? '-'
        ];
    }
}