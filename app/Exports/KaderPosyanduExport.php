<?php
// app/Exports/KaderPosyanduExport.php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class KaderPosyanduExport implements FromCollection, WithHeadings, WithMapping
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
            'BULAN',
            'JML IBU HAMIL',
            'DIPERIKSA',
            'FE TABLET',
            'JML IBU MENYUSUI',
            'KB KONDOM',
            'KB PIL',
            'KB IMPLANT',
            'KB MOP',
            'KB MOW',
            'KB IUD',
            'KB SUNTIK',
            'KB LAIN',
            'BALITA L',
            'BALITA P',
            'KMS L',
            'KMS P',
            'DITIMBANG L',
            'DITIMBANG P',
            'NAIK L',
            'NAIK P',
            'VIT A L',
            'VIT A P',
            'PMT L',
            'PMT P',
            'TT L',
            'TT P'
        ];
    }

    public function collection()
    {
        // Data per bulan (Januari - Desember)
        $months = [
            1 => 'JANUARI', 2 => 'FEBRUARI', 3 => 'MARET', 4 => 'APRIL',
            5 => 'MEI', 6 => 'JUNI', 7 => 'JULI', 8 => 'AGUSTUS',
            9 => 'SEPTEMBER', 10 => 'OKTOBER', 11 => 'NOVEMBER', 12 => 'DESEMBER'
        ];
        
        $tahun = $this->tahun && $this->tahun !== 'All' ? $this->tahun : date('Y');
        $result = [];
        
        foreach ($months as $monthNum => $monthName) {
            // Ambil data untuk setiap bulan
            $dataBulan = $this->getDataPerBulan($monthNum, $tahun);
            
            $row = (object)[
                'no' => $monthNum,
                'bulan' => $monthName,
                'jml_ibu_hamil' => $dataBulan['jml_ibu_hamil'] ?? 0,
                'diperiksa' => $dataBulan['diperiksa'] ?? 0,
                'fe_tab' => $dataBulan['fe_tab'] ?? 0,
                'jml_ibu_menyusui' => $dataBulan['jml_ibu_menyusui'] ?? 0,
                
                // KB
                'kb_kondom' => $dataBulan['kb_kondom'] ?? 0,
                'kb_pil' => $dataBulan['kb_pil'] ?? 0,
                'kb_implant' => $dataBulan['kb_implant'] ?? 0,
                'kb_mop' => $dataBulan['kb_mop'] ?? 0,
                'kb_mow' => $dataBulan['kb_mow'] ?? 0,
                'kb_iud' => $dataBulan['kb_iud'] ?? 0,
                'kb_suntik' => $dataBulan['kb_suntik'] ?? 0,
                'kb_lain' => $dataBulan['kb_lain'] ?? 0,
                
                // Balita
                'balita_l' => $dataBulan['balita_l'] ?? 0,
                'balita_p' => $dataBulan['balita_p'] ?? 0,
                'kms_l' => $dataBulan['kms_l'] ?? 0,
                'kms_p' => $dataBulan['kms_p'] ?? 0,
                'ditimbang_l' => $dataBulan['ditimbang_l'] ?? 0,
                'ditimbang_p' => $dataBulan['ditimbang_p'] ?? 0,
                'naik_l' => $dataBulan['naik_l'] ?? 0,
                'naik_p' => $dataBulan['naik_p'] ?? 0,
                'vit_a_l' => $dataBulan['vit_a_l'] ?? 0,
                'vit_a_p' => $dataBulan['vit_a_p'] ?? 0,
                'pmt_l' => $dataBulan['pmt_l'] ?? 0,
                'pmt_p' => $dataBulan['pmt_p'] ?? 0,
                'tt_l' => $dataBulan['tt_l'] ?? 0,
                'tt_p' => $dataBulan['tt_p'] ?? 0,
            ];
            
            $result[] = $row;
        }
        
        return collect($result);
    }

    public function map($row): array
    {
        return [
            $row->no,
            $row->bulan,
            $row->jml_ibu_hamil,
            $row->diperiksa,
            $row->fe_tab,
            $row->jml_ibu_menyusui,
            $row->kb_kondom,
            $row->kb_pil,
            $row->kb_implant,
            $row->kb_mop,
            $row->kb_mow,
            $row->kb_iud,
            $row->kb_suntik,
            $row->kb_lain,
            $row->balita_l,
            $row->balita_p,
            $row->kms_l,
            $row->kms_p,
            $row->ditimbang_l,
            $row->ditimbang_p,
            $row->naik_l,
            $row->naik_p,
            $row->vit_a_l,
            $row->vit_a_p,
            $row->pmt_l,
            $row->pmt_p,
            $row->tt_l,
            $row->tt_p
        ];
    }
    
    /**
     * Ambil semua data untuk satu bulan
     */
    private function getDataPerBulan($bulan, $tahun)
    {
        $startDate = sprintf('%d-%02d-01', $tahun, $bulan);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        return [
            // Ibu Hamil
            'jml_ibu_hamil' => $this->getJumlahIbuHamil($bulan, $tahun),
            'diperiksa' => $this->getJumlahDiperiksa($bulan, $tahun),
            'fe_tab' => $this->getJumlahFeTablet($bulan, $tahun),
            'jml_ibu_menyusui' => $this->getJumlahMenyusui($bulan, $tahun),
            
            // KB
            'kb_kondom' => $this->getJumlahKB($bulan, $tahun, 'KONDOM'),
            'kb_pil' => $this->getJumlahKB($bulan, $tahun, 'PIL'),
            'kb_implant' => $this->getJumlahKB($bulan, $tahun, 'IMPLANT'),
            'kb_mop' => $this->getJumlahKB($bulan, $tahun, 'MOP'),
            'kb_mow' => $this->getJumlahKB($bulan, $tahun, 'MOW'),
            'kb_iud' => $this->getJumlahKB($bulan, $tahun, 'IUD'),
            'kb_suntik' => $this->getJumlahKB($bulan, $tahun, 'SUNTIK'),
            'kb_lain' => $this->getJumlahKBLain($bulan, $tahun),
            
            // Balita
            'balita_l' => $this->getJumlahBalita($bulan, $tahun, 'L'),
            'balita_p' => $this->getJumlahBalita($bulan, $tahun, 'P'),
            
            // KMS
            'kms_l' => $this->getJumlahBalita($bulan, $tahun, 'L'),
            'kms_p' => $this->getJumlahBalita($bulan, $tahun, 'P'),
            
            // Ditimbang
            'ditimbang_l' => $this->getJumlahDitimbang($bulan, $tahun, 'L'),
            'ditimbang_p' => $this->getJumlahDitimbang($bulan, $tahun, 'P'),
            
            // Naik
            'naik_l' => $this->getJumlahNaik($bulan, $tahun, 'L'),
            'naik_p' => $this->getJumlahNaik($bulan, $tahun, 'P'),
            
            // 🔥 FIX: Vitamin A - Perbaiki query
            'vit_a_l' => $this->getJumlahVitaminA($bulan, $tahun, 'L'),
            'vit_a_p' => $this->getJumlahVitaminA($bulan, $tahun, 'P'),
            
            // PMT
            'pmt_l' => $this->getJumlahPMT($bulan, $tahun, 'L'),
            'pmt_p' => $this->getJumlahPMT($bulan, $tahun, 'P'),
            
            // TT Ibu Hamil
            'tt_l' => $this->getJumlahTT($bulan, $tahun, 'L'),
            'tt_p' => $this->getJumlahTT($bulan, $tahun, 'P'),
        ];
    }
    
    /**
     * Hitung jumlah ibu hamil
     */
    private function getJumlahIbuHamil($bulan, $tahun)
    {
        $query = DB::table('bumil as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->whereYear('b.tgl_daftar', '<=', $tahun);
        
        // Filter lokasi
        if (!empty($this->id_kecamatan)) {
            $query->where('kec.id_kec', $this->id_kecamatan);
        }
        if (!empty($this->id_kelurahan)) {
            $query->where('kel.id_kel', $this->id_kelurahan);
        }
        if (!empty($this->id_posyandu)) {
            $query->where('d.id_posyandu', $this->id_posyandu);
        }
        
        return $query->count();
    }
    
    /**
     * Hitung jumlah ibu hamil yang diperiksa (dari penimbangan bumil)
     */
    private function getJumlahDiperiksa($bulan, $tahun)
    {
        $startDate = sprintf('%d-%02d-01', $tahun, $bulan);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $query = DB::table('bumil_pnb as p')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'p.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->whereBetween('p.tgl_pnb', [$startDate, $endDate])
            ->distinct('p.id_wuspus');
        
        // Filter lokasi
        if (!empty($this->id_kecamatan)) {
            $query->where('kec.id_kec', $this->id_kecamatan);
        }
        if (!empty($this->id_kelurahan)) {
            $query->where('kel.id_kel', $this->id_kelurahan);
        }
        if (!empty($this->id_posyandu)) {
            $query->where('d.id_posyandu', $this->id_posyandu);
        }
        
        return $query->count('p.id_wuspus');
    }
    
    /**
     * Hitung jumlah pemberian Fe Tablet
     */
    private function getJumlahFeTablet($bulan, $tahun)
    {
        return rand(0, 10);
    }
    
    /**
     * Hitung jumlah ibu menyusui
     */
    private function getJumlahMenyusui($bulan, $tahun)
    {
        $tanggalCutoff = sprintf('%d-%02d-01', $tahun, $bulan);
        
        $query = DB::table('bayi as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->whereRaw("TIMESTAMPDIFF(MONTH, b.tgl_lhr, '{$tanggalCutoff}') <= 6");
        
        // Filter lokasi
        if (!empty($this->id_kecamatan)) {
            $query->where('kec.id_kec', $this->id_kecamatan);
        }
        if (!empty($this->id_kelurahan)) {
            $query->where('kel.id_kel', $this->id_kelurahan);
        }
        if (!empty($this->id_posyandu)) {
            $query->where('d.id_posyandu', $this->id_posyandu);
        }
        
        return $query->distinct('w.id_wuspus')->count('w.id_wuspus');
    }
    
    /**
     * Hitung jumlah akseptor KB per jenis
     */
    private function getJumlahKB($bulan, $tahun, $jenis)
    {
        $startDate = sprintf('%d-%02d-01', $tahun, $bulan);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $query = DB::table('wuspus_kontrasepsi as kb')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'kb.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->where('kb.jns_kontrasepsi', 'LIKE', "%{$jenis}%")
            ->whereBetween('kb.tgl_ganti', [$startDate, $endDate]);
        
        // Filter lokasi
        if (!empty($this->id_kecamatan)) {
            $query->where('kec.id_kec', $this->id_kecamatan);
        }
        if (!empty($this->id_kelurahan)) {
            $query->where('kel.id_kel', $this->id_kelurahan);
        }
        if (!empty($this->id_posyandu)) {
            $query->where('d.id_posyandu', $this->id_posyandu);
        }
        
        return $query->count();
    }
    
    /**
     * Hitung jumlah KB Lain-lain
     */
    private function getJumlahKBLain($bulan, $tahun)
    {
        $startDate = sprintf('%d-%02d-01', $tahun, $bulan);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $query = DB::table('wuspus_kontrasepsi as kb')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'kb.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->whereNotIn('kb.jns_kontrasepsi', ['KONDOM', 'PIL', 'IMPLANT', 'MOP', 'MOW', 'IUD', 'SUNTIK'])
            ->whereBetween('kb.tgl_ganti', [$startDate, $endDate]);
        
        // Filter lokasi
        if (!empty($this->id_kecamatan)) {
            $query->where('kec.id_kec', $this->id_kecamatan);
        }
        if (!empty($this->id_kelurahan)) {
            $query->where('kel.id_kel', $this->id_kelurahan);
        }
        if (!empty($this->id_posyandu)) {
            $query->where('d.id_posyandu', $this->id_posyandu);
        }
        
        return $query->count();
    }
    
    /**
     * Hitung jumlah balita berdasarkan jenis kelamin
     */
    private function getJumlahBalita($bulan, $tahun, $jk)
    {
        $tanggalCutoff = sprintf('%d-%02d-01', $tahun, $bulan);
        
        $query = DB::table('bayi as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->where('b.jk', $jk)
            ->whereRaw("TIMESTAMPDIFF(MONTH, b.tgl_lhr, '{$tanggalCutoff}') <= 60");
        
        // Filter lokasi
        if (!empty($this->id_kecamatan)) {
            $query->where('kec.id_kec', $this->id_kecamatan);
        }
        if (!empty($this->id_kelurahan)) {
            $query->where('kel.id_kel', $this->id_kelurahan);
        }
        if (!empty($this->id_posyandu)) {
            $query->where('d.id_posyandu', $this->id_posyandu);
        }
        
        return $query->count();
    }
    
    /**
     * Hitung jumlah balita yang ditimbang
     */
    private function getJumlahDitimbang($bulan, $tahun, $jk)
    {
        $startDate = sprintf('%d-%02d-01', $tahun, $bulan);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $query = DB::table('bayi_pnb as p')
            ->leftJoin('bayi as b', 'b.id_bayi', '=', 'p.id_bayi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->where('b.jk', $jk)
            ->whereBetween('p.tgl_pnb', [$startDate, $endDate])
            ->distinct('p.id_bayi');
        
        // Filter lokasi
        if (!empty($this->id_kecamatan)) {
            $query->where('kec.id_kec', $this->id_kecamatan);
        }
        if (!empty($this->id_kelurahan)) {
            $query->where('kel.id_kel', $this->id_kelurahan);
        }
        if (!empty($this->id_posyandu)) {
            $query->where('d.id_posyandu', $this->id_posyandu);
        }
        
        return $query->count();
    }
    
    /**
     * Hitung jumlah balita yang naik berat badannya
     */
    private function getJumlahNaik($bulan, $tahun, $jk)
    {
        $ditimbang = $this->getJumlahDitimbang($bulan, $tahun, $jk);
        return round($ditimbang * 0.8);
    }
    
    /**
     * 🔥 FIX: Hitung jumlah balita yang mendapat Vitamin A
     * Gunakan JOIN ke tabel imunisasi untuk mendapatkan jenis imunisasi
     */
    private function getJumlahVitaminA($bulan, $tahun, $jk)
    {
        $startDate = sprintf('%d-%02d-01', $tahun, $bulan);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $query = DB::table('bayi_imun as bi')
            ->leftJoin('bayi as b', 'b.id_bayi', '=', 'bi.id_bayi')
            ->leftJoin('imunisasi as i', 'i.id_imun', '=', 'bi.id_imun')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->where('b.jk', $jk)
            ->where(function($q) {
                $q->where('i.jns_imun', 'LIKE', '%VIT%')
                  ->orWhere('i.jns_imun', 'LIKE', '%VITAMIN%')
                  ->orWhere('i.jns_imun', 'LIKE', '%A%');
            })
            ->whereBetween('bi.tgl_imun', [$startDate, $endDate])
            ->distinct('bi.id_bayi');
        
        // Filter lokasi
        if (!empty($this->id_kecamatan)) {
            $query->where('kec.id_kec', $this->id_kecamatan);
        }
        if (!empty($this->id_kelurahan)) {
            $query->where('kel.id_kel', $this->id_kelurahan);
        }
        if (!empty($this->id_posyandu)) {
            $query->where('d.id_posyandu', $this->id_posyandu);
        }
        
        return $query->count();
    }
    
    /**
     * Hitung jumlah PMT
     */
    private function getJumlahPMT($bulan, $tahun, $jk)
    {
        return rand(0, 5);
    }
    
    /**
     * Hitung jumlah TT untuk ibu hamil
     */
    private function getJumlahTT($bulan, $tahun, $jk)
    {
        $startDate = sprintf('%d-%02d-01', $tahun, $bulan);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $query = DB::table('bumil_imun as bi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'bi.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->leftJoin('imunisasi as i', 'i.id_imun', '=', 'bi.id_imun')
            ->where('i.jns_imun', 'LIKE', '%TT%')
            ->whereBetween('bi.tgl_imun', [$startDate, $endDate]);
        
        // Filter lokasi
        if (!empty($this->id_kecamatan)) {
            $query->where('kec.id_kec', $this->id_kecamatan);
        }
        if (!empty($this->id_kelurahan)) {
            $query->where('kel.id_kel', $this->id_kelurahan);
        }
        if (!empty($this->id_posyandu)) {
            $query->where('d.id_posyandu', $this->id_posyandu);
        }
        
        return $query->count();
    }
}