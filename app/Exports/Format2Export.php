<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class Format2Export implements FromCollection, WithHeadings, WithMapping
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
            'NAMA BAYI',
            'TANGGAL LAHIR',
            'BERAT BADAN LAHIR',
            'NAMA AYAH',
            'NAMA IBU',
            'KLP DASA WISMA',
            'JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN',
            'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES',
            'VIT A I', 'VIT A II',
            'BCG',
            'DPT 1', 'DPT 2', 'DPT 3',
            'POLIO 1', 'POLIO 2', 'POLIO 3', 'POLIO 4',
            'CAMPAK',
            'HEP 1', 'HEP 2', 'HEP 3',
            'TGL MENINGGAL',
            'KETERANGAN'
        ];
    }

    public function collection()
    {
        // Ambil semua bayi dengan filter
        $bayiQuery = DB::table('bayi as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->leftJoin('bayi_wafat as bw', 'bw.id_bayi', '=', 'b.id_bayi')
            ->select([
                'b.id_bayi',
                'b.nama_bayi',
                'b.tgl_lhr',
                'b.bb as bb_lahir',
                DB::raw("'-' as nama_ayah"),
                'w.nama_wuspus as nama_ibu',
                DB::raw("'-' as dasa_wisma"),
                'bw.tgl_kematian',
                'bw.ket as ket_wafat',
            ]);

        // Filter lokasi
        if (!empty($this->id_kecamatan)) {
            $bayiQuery->where('kec.id_kec', $this->id_kecamatan);
        }
        if (!empty($this->id_kelurahan)) {
            $bayiQuery->where('kel.id_kel', $this->id_kelurahan);
        }
        if (!empty($this->id_posyandu)) {
            $bayiQuery->where('d.id_posyandu', $this->id_posyandu);
        }
        
        // Filter tahun
        $tahunFilter = $this->tahun && $this->tahun !== 'All' ? $this->tahun : date('Y');
        $bayiQuery->whereYear('b.tgl_lhr', $tahunFilter);
        
        $bayiList = $bayiQuery->get();
        
        $result = [];
        
        foreach ($bayiList as $bayi) {
            // Ambil penimbangan per bulan
            $penimbangan = DB::table('bayi_penimbangan')
                ->where('id_bayi', $bayi->id_bayi)
                ->whereYear('tanggal', $tahunFilter)
                ->selectRaw('MONTH(tanggal) as bulan, berat_badan')
                ->get()
                ->keyBy('bulan');
            
            // Ambil imunisasi
            $imunisasi = DB::table('bayi_imunisasi')
                ->where('id_bayi', $bayi->id_bayi)
                ->select('jenis')
                ->get()
                ->pluck('jenis')
                ->map(function($item) {
                    return strtoupper(trim($item));
                });
            
            // Mapping imunisasi
            $imunisasiMap = [
                'bcg' => $imunisasi->contains(function($item) {
                    return strpos($item, 'BCG') !== false;
                }) ? '✓' : '-',
                
                'dpt1' => $imunisasi->contains(function($item) {
                    return strpos($item, 'DPT1') !== false || strpos($item, 'DPT-1') !== false;
                }) ? '✓' : '-',
                
                'dpt2' => $imunisasi->contains(function($item) {
                    return strpos($item, 'DPT2') !== false || strpos($item, 'DPT-2') !== false;
                }) ? '✓' : '-',
                
                'dpt3' => $imunisasi->contains(function($item) {
                    return strpos($item, 'DPT3') !== false || strpos($item, 'DPT-3') !== false;
                }) ? '✓' : '-',
                
                'polio1' => $imunisasi->contains(function($item) {
                    return strpos($item, 'POLIO1') !== false || strpos($item, 'POLIO-1') !== false;
                }) ? '✓' : '-',
                
                'polio2' => $imunisasi->contains(function($item) {
                    return strpos($item, 'POLIO2') !== false || strpos($item, 'POLIO-2') !== false;
                }) ? '✓' : '-',
                
                'polio3' => $imunisasi->contains(function($item) {
                    return strpos($item, 'POLIO3') !== false || strpos($item, 'POLIO-3') !== false;
                }) ? '✓' : '-',
                
                'polio4' => $imunisasi->contains(function($item) {
                    return strpos($item, 'POLIO4') !== false || strpos($item, 'POLIO-4') !== false;
                }) ? '✓' : '-',
                
                'campak' => $imunisasi->contains(function($item) {
                    return strpos($item, 'CAMPAK') !== false;
                }) ? '✓' : '-',
                
                'hep1' => $imunisasi->contains(function($item) {
                    return (strpos($item, 'HEP1') !== false || strpos($item, 'HEP-1') !== false) &&
                           !strpos($item, 'HEP B') !== false;
                }) ? '✓' : '-',
                
                'hep2' => $imunisasi->contains(function($item) {
                    return strpos($item, 'HEP2') !== false || strpos($item, 'HEP-2') !== false;
                }) ? '✓' : '-',
                
                'hep3' => $imunisasi->contains(function($item) {
                    return strpos($item, 'HEP3') !== false || strpos($item, 'HEP-3') !== false;
                }) ? '✓' : '-',
            ];
            
            // Vit A
            $vitA = $imunisasi->filter(function($item) {
                return strpos($item, 'VIT') !== false || strpos($item, 'A') !== false;
            })->count();
            
            $row = (object)[
                'no' => count($result) + 1,
                'nama_bayi' => $bayi->nama_bayi ?? '-',
                'tgl_lahir' => $bayi->tgl_lhr,
                'bb_lahir' => $bayi->bb_lahir ?? '-',
                'nama_ayah' => '-',
                'nama_ibu' => $bayi->nama_ibu ?? '-',
                'dasa_wisma' => '-',
                
                // BB per bulan
                'bb_jan' => $penimbangan[1]->berat_badan ?? '-',
                'bb_feb' => $penimbangan[2]->berat_badan ?? '-',
                'bb_mar' => $penimbangan[3]->berat_badan ?? '-',
                'bb_apr' => $penimbangan[4]->berat_badan ?? '-',
                'bb_mei' => $penimbangan[5]->berat_badan ?? '-',
                'bb_jun' => $penimbangan[6]->berat_badan ?? '-',
                'bb_jul' => $penimbangan[7]->berat_badan ?? '-',
                'bb_ags' => $penimbangan[8]->berat_badan ?? '-',
                'bb_sep' => $penimbangan[9]->berat_badan ?? '-',
                'bb_okt' => $penimbangan[10]->berat_badan ?? '-',
                'bb_nov' => $penimbangan[11]->berat_badan ?? '-',
                'bb_des' => $penimbangan[12]->berat_badan ?? '-',
                
                // Vit A
                'vit_a1' => $vitA >= 1 ? '✓' : '-',
                'vit_a2' => $vitA >= 2 ? '✓' : '-',
                
                // Imunisasi
                'bcg' => $imunisasiMap['bcg'],
                'dpt1' => $imunisasiMap['dpt1'],
                'dpt2' => $imunisasiMap['dpt2'],
                'dpt3' => $imunisasiMap['dpt3'],
                'polio1' => $imunisasiMap['polio1'],
                'polio2' => $imunisasiMap['polio2'],
                'polio3' => $imunisasiMap['polio3'],
                'polio4' => $imunisasiMap['polio4'],
                'campak' => $imunisasiMap['campak'],
                'hep1' => $imunisasiMap['hep1'],
                'hep2' => $imunisasiMap['hep2'],
                'hep3' => $imunisasiMap['hep3'],
                
                // Kematian
                'tgl_meninggal' => $bayi->tgl_kematian,
                'keterangan' => $bayi->ket_wafat ?: '-'
            ];
            
            $result[] = $row;
        }
        
        return collect($result);
    }

    public function map($row): array
    {
        return [
            $row->no,
            $row->nama_bayi,
            $row->tgl_lahir ? Carbon::parse($row->tgl_lahir)->format('d-m-Y') : '-',
            $row->bb_lahir,
            $row->nama_ayah,
            $row->nama_ibu,
            $row->dasa_wisma,
            $row->bb_jan, $row->bb_feb, $row->bb_mar, $row->bb_apr,
            $row->bb_mei, $row->bb_jun, $row->bb_jul, $row->bb_ags,
            $row->bb_sep, $row->bb_okt, $row->bb_nov, $row->bb_des,
            $row->vit_a1, $row->vit_a2,
            $row->bcg,
            $row->dpt1, $row->dpt2, $row->dpt3,
            $row->polio1, $row->polio2, $row->polio3, $row->polio4,
            $row->campak,
            $row->hep1, $row->hep2, $row->hep3,
            $row->tgl_meninggal ? Carbon::parse($row->tgl_meninggal)->format('d-m-Y') : '-',
            $row->keterangan
        ];
    }
}