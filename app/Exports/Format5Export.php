<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class Format5Export implements FromCollection, WithHeadings, WithMapping
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
            'BALITA 0-12 BLN L',
            'BALITA 0-12 BLN P',
            'BALITA 1-5 TH L',
            'BALITA 1-5 TH P',
            'WUS',
            'PUS',
            'IBU HAMIL',
            'IBU MENYUSUI',
            'KADER L',
            'KADER P',
            'PLKB L',
            'PLKB P',
            'MEDIS L',
            'MEDIS P',
            'BAYI LAHIR L',
            'BAYI LAHIR P',
            'BAYI MENINGGAL L',
            'BAYI MENINGGAL P',
            'KETERANGAN'
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
            // Ambil data kehadiran kader untuk bulan ini
            $kehadiran = $this->getKehadiranKader($monthNum, $tahun);
            
            // Hitung jumlah bayi berdasarkan jenis kelamin dan umur
            $bayi = $this->getJumlahBayi($monthNum, $tahun);
            
            // Hitung jumlah WUS dan PUS
            $wuspus = $this->getJumlahWusPus($monthNum, $tahun);
            
            // Hitung jumlah ibu hamil
            $bumil = $this->getJumlahBumil($monthNum, $tahun);
            
            // Hitung jumlah ibu menyusui (asumsi dari bayi 0-6 bulan)
            $menyusui = $this->getJumlahMenyusui($monthNum, $tahun);
            
            // Hitung jumlah bayi lahir
            $lahir = $this->getJumlahLahir($monthNum, $tahun);
            
            // Hitung jumlah bayi meninggal
            $meninggal = $this->getJumlahMeninggal($monthNum, $tahun);
            
            $row = (object)[
                'no' => $monthNum,
                'bulan' => $monthName,
                'balita_0_12_l' => $bayi['0-12_l'] ?? 0,
                'balita_0_12_p' => $bayi['0-12_p'] ?? 0,
                'balita_1_5_l' => $bayi['1-5_l'] ?? 0,
                'balita_1_5_p' => $bayi['1-5_p'] ?? 0,
                'wus' => $wuspus['wus'] ?? 0,
                'pus' => $wuspus['pus'] ?? 0,
                'ibu_hamil' => $bumil ?? 0,
                'ibu_menyusui' => $menyusui ?? 0,
                'kader_l' => $kehadiran['pkk_l'] ?? 0,
                'kader_p' => $kehadiran['pkk_p'] ?? 0,
                'plkb_l' => $kehadiran['plkb_l'] ?? 0,
                'plkb_p' => $kehadiran['plkb_p'] ?? 0,
                'medis_l' => $kehadiran['medis_l'] ?? 0,
                'medis_p' => $kehadiran['medis_p'] ?? 0,
                'bayi_lahir_l' => $lahir['l'] ?? 0,
                'bayi_lahir_p' => $lahir['p'] ?? 0,
                'bayi_meninggal_l' => $meninggal['l'] ?? 0,
                'bayi_meninggal_p' => $meninggal['p'] ?? 0,
                'keterangan' => $lahir['keterangan'] ?? ($meninggal['keterangan'] ?? '-')
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
            $row->balita_0_12_l,
            $row->balita_0_12_p,
            $row->balita_1_5_l,
            $row->balita_1_5_p,
            $row->wus,
            $row->pus,
            $row->ibu_hamil,
            $row->ibu_menyusui,
            $row->kader_l,
            $row->kader_p,
            $row->plkb_l,
            $row->plkb_p,
            $row->medis_l,
            $row->medis_p,
            $row->bayi_lahir_l,
            $row->bayi_lahir_p,
            $row->bayi_meninggal_l,
            $row->bayi_meninggal_p,
            $row->keterangan
        ];
    }
    
    /**
     * Ambil data kehadiran kader untuk bulan tertentu
     */
    private function getKehadiranKader($bulan, $tahun)
    {
        $tanggal = sprintf('%d-%02d-01', $tahun, $bulan);
        
        $query = DB::table('kdrhdr as k')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'k.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->where('k.bulan', 'like', $tanggal . '%');
        
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
        
        $data = $query->get();
        
        // Akumulasi data dari semua posyandu
        $result = [
            'pkk_l' => 0, 'pkk_p' => 0,
            'plkb_l' => 0, 'plkb_p' => 0,
            'medis_l' => 0, 'medis_p' => 0
        ];
        
        foreach ($data as $item) {
            // Asumsi: pkk, plkb, medis adalah total, bukan per gender
            // Untuk sementara, kita bagi 2 asumsi L/P seimbang
            $result['pkk_l'] += ceil($item->pkk / 2);
            $result['pkk_p'] += floor($item->pkk / 2);
            $result['plkb_l'] += ceil($item->plkb / 2);
            $result['plkb_p'] += floor($item->plkb / 2);
            $result['medis_l'] += ceil($item->medis / 2);
            $result['medis_p'] += floor($item->medis / 2);
        }
        
        return $result;
    }
    
    /**
     * Hitung jumlah bayi berdasarkan umur dan jenis kelamin
     */
    private function getJumlahBayi($bulan, $tahun)
    {
        $tanggalCutoff = sprintf('%d-%02d-01', $tahun, $bulan);
        
        $query = DB::table('bayi as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select('b.jk', 'b.tgl_lhr');
        
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
        
        $bayiList = $query->get();
        
        $result = [
            '0-12_l' => 0, '0-12_p' => 0,
            '1-5_l' => 0, '1-5_p' => 0
        ];
        
        foreach ($bayiList as $bayi) {
            if (!$bayi->tgl_lhr) continue;
            
            $umurBulan = Carbon::parse($bayi->tgl_lhr)->diffInMonths($tanggalCutoff);
            $jk = $bayi->jk == 'L' ? 'l' : 'p';
            
            if ($umurBulan <= 12) {
                $result["0-12_{$jk}"]++;
            } elseif ($umurBulan <= 60) { // 5 tahun = 60 bulan
                $result["1-5_{$jk}"]++;
            }
        }
        
        return $result;
    }
    
    /**
     * Hitung jumlah WUS dan PUS
     */
    private function getJumlahWusPus($bulan, $tahun)
    {
        $query = DB::table('wuspus as w')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select('w.status');
        
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
        
        $wuspusList = $query->get();
        
        $result = ['wus' => 0, 'pus' => 0];
        
        foreach ($wuspusList as $w) {
            $result['wus']++;
            if ($w->status == 'PUS' || $w->status == 'Aktif') {
                $result['pus']++;
            }
        }
        
        return $result;
    }
    
    /**
     * Hitung jumlah ibu hamil
     */
    private function getJumlahBumil($bulan, $tahun)
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
     * Hitung jumlah ibu menyusui (bayi 0-6 bulan)
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
        
        // Satu ibu bisa punya lebih dari 1 bayi, tapi kita hitung unique id_wuspus
        return $query->distinct('w.id_wuspus')->count('w.id_wuspus');
    }
    
    /**
     * Hitung jumlah bayi lahir per bulan
     */
    private function getJumlahLahir($bulan, $tahun)
    {
        $startDate = sprintf('%d-%02d-01', $tahun, $bulan);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $query = DB::table('bayi as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->whereBetween('b.tgl_lhr', [$startDate, $endDate])
            ->select('b.jk');
        
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
        
        $bayiList = $query->get();
        
        $result = ['l' => 0, 'p' => 0, 'keterangan' => ''];
        $keterangan = [];
        
        foreach ($bayiList as $bayi) {
            if ($bayi->jk == 'L') {
                $result['l']++;
            } else {
                $result['p']++;
            }
            $keterangan[] = $bayi->jk == 'L' ? 'Lahir L' : 'Lahir P';
        }
        
        if (!empty($keterangan)) {
            $result['keterangan'] = implode(', ', array_slice($keterangan, 0, 3)) . (count($keterangan) > 3 ? '...' : '');
        }
        
        return $result;
    }
    
    /**
     * Hitung jumlah bayi meninggal per bulan
     */
    private function getJumlahMeninggal($bulan, $tahun)
    {
        $startDate = sprintf('%d-%02d-01', $tahun, $bulan);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $query = DB::table('bayi_wafat as bw')
            ->leftJoin('bayi as b', 'b.id_bayi', '=', 'bw.id_bayi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->whereBetween('bw.tgl_kematian', [$startDate, $endDate])
            ->select('b.jk', 'bw.ket');
        
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
        
        $meninggalList = $query->get();
        
        $result = ['l' => 0, 'p' => 0, 'keterangan' => ''];
        $keterangan = [];
        
        foreach ($meninggalList as $m) {
            if ($m->jk == 'L') {
                $result['l']++;
            } else {
                $result['p']++;
            }
            $keterangan[] = $m->ket ?: ($m->jk == 'L' ? 'Meninggal L' : 'Meninggal P');
        }
        
        if (!empty($keterangan)) {
            $result['keterangan'] = implode(', ', array_slice($keterangan, 0, 3)) . (count($keterangan) > 3 ? '...' : '');
        }
        
        return $result;
    }
}