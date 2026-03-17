<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class Format3Export implements FromCollection, WithHeadings, WithMapping
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
            'NAMA WUS/PUS',
            'UMUR',
            'NAMA SUAMI',
            'TAHAPAN KS',
            'KELOMPOK DASAWISMA',
            'JUMLAH ANAK HIDUP',
            'JUMLAH ANAK MENINGGAL',
            'PENGUKURAN LILA',
            'KAPSUL YODIUM',
            'IMUNISASI TT I',
            'IMUNISASI TT II',
            'IMUNISASI TT LENGKAP',
            'JENIS KONTRASEPSI',
            'TANGGAL PERGANTIAN',
            'KONTRASEPSI BARU',
            'KETERANGAN'
        ];
    }

    public function collection()
    {
        // Query utama dari tabel wuspus
        $query = DB::table('wuspus as w')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            
            // LEFT JOIN untuk kontrasepsi (ambil yang terbaru)
            ->leftJoin('wuspus_kontrasepsi as kb', function($join) {
                $join->on('kb.id_wuspus', '=', 'w.id_wuspus')
                     ->whereRaw('kb.id_wkp = (SELECT id_wkp FROM wuspus_kontrasepsi 
                                             WHERE id_wuspus = w.id_wuspus 
                                             ORDER BY tgl_ganti DESC LIMIT 1)');
            })
            
            // LEFT JOIN untuk kematian (untuk cek status)
            ->leftJoin('wuspus_kematians as wk', 'wk.id_wuspus', '=', 'w.id_wuspus')
            
            ->select([
                'w.id_wuspus',
                'w.nama_wuspus',
                'w.umur',
                'w.nama_suami',
                'w.thpn_ks as tahapan_ks',
                'w.klmpk_dasawisma',
                'w.jml_anak_hdp',
                'w.jml_anak_meninggal',
                DB::raw("'-' as lila"), // Kolom belum ada di tabel
                DB::raw("'-' as kapsul_yodium"), // Kolom belum ada
                
                // Untuk imunisasi TT (akan diisi nanti per id_wuspus)
                DB::raw("'-' as tt_i"),
                DB::raw("'-' as tt_ii"),
                DB::raw("'-' as tt_lengkap"),
                
                // Kontrasepsi
                'kb.jns_kontrasepsi',
                'kb.tgl_ganti',
                'kb.kontrasepsi_baru',
                
                // Status dan keterangan
                'w.status',
                'w.ket',
                
                // Lokasi untuk filter
                'kec.id_kec',
                'kel.id_kel',
                'd.id_posyandu',
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

        $wuspusList = $query->get();
        
        $result = [];
        
        foreach ($wuspusList as $wuspus) {
            // Ambil data imunisasi TT untuk WUS ini
            $imunisasiTT = DB::table('wuspus_imun as wi')
                ->join('imunisasi as i', 'i.id_imun', '=', 'wi.id_imun')
                ->where('wi.id_wuspus', $wuspus->id_wuspus)
                ->where('i.imun_untuk', 'WUS/PUS')
                ->where('i.jns_imun', 'LIKE', '%TT%')
                ->select('i.jns_imun', 'wi.tgl_imun')
                ->get();
            
            $ttCount = 0;
            $ttList = [];
            foreach ($imunisasiTT as $tt) {
                $ttList[] = $tt->jns_imun;
                if (strpos($tt->jns_imun, 'TT') !== false) {
                    $ttCount++;
                }
            }
            
            // Hitung jumlah TT
            $tt_i = in_array('TT I', $ttList) || in_array('TT-1', $ttList) ? '✓' : '-';
            $tt_ii = in_array('TT II', $ttList) || in_array('TT-2', $ttList) ? '✓' : '-';
            $tt_lengkap = $ttCount >= 2 ? '✓' : '-'; // Atau sesuai kriteria lengkap
            
            // Ambil data kapsul yodium (mungkin dari tabel lain)
            $kapsulYodium = '-'; // Default, nanti bisa dikembangkan
            
            // Ambil data LILA (mungkin dari tabel bumil atau pemeriksaan)
            $lila = '-'; // Default
            
            // Format kontrasepsi baru
            $kontrasepsiBaru = '';
            if ($wuspus->kontrasepsi_baru == 1) {
                $kontrasepsiBaru = 'Ya';
            } elseif ($wuspus->kontrasepsi_baru == 0) {
                $kontrasepsiBaru = 'Tidak';
            } else {
                $kontrasepsiBaru = '-';
            }
            
            $row = (object)[
                'no' => count($result) + 1,
                'nama_wuspus' => $wuspus->nama_wuspus ?? '-',
                'umur' => $wuspus->umur ?? '-',
                'nama_suami' => $wuspus->nama_suami ?? '-',
                'tahapan_ks' => $wuspus->tahapan_ks ?? '-',
                'klmpk_dasawisma' => $wuspus->klmpk_dasawisma ?? '-',
                'jml_anak_hdp' => $wuspus->jml_anak_hdp ?? '0',
                'jml_anak_meninggal' => $wuspus->jml_anak_meninggal ?? '0',
                'lila' => $lila,
                'kapsul_yodium' => $kapsulYodium,
                'tt_i' => $tt_i,
                'tt_ii' => $tt_ii,
                'tt_lengkap' => $tt_lengkap,
                'jns_kontrasepsi' => $wuspus->jns_kontrasepsi ?? '-',
                'tgl_ganti' => $wuspus->tgl_ganti,
                'kontrasepsi_baru' => $kontrasepsiBaru,
                'keterangan' => $wuspus->status == 'Meninggal' ? 'Meninggal' : ($wuspus->ket ?? '-')
            ];
            
            $result[] = $row;
        }
        
        return collect($result);
    }

    public function map($row): array
    {
        return [
            $row->no,
            $row->nama_wuspus,
            $row->umur,
            $row->nama_suami,
            $row->tahapan_ks,
            $row->klmpk_dasawisma,
            $row->jml_anak_hdp,
            $row->jml_anak_meninggal,
            $row->lila,
            $row->kapsul_yodium,
            $row->tt_i,
            $row->tt_ii,
            $row->tt_lengkap,
            $row->jns_kontrasepsi,
            $row->tgl_ganti ? Carbon::parse($row->tgl_ganti)->format('d-m-Y') : '-',
            $row->kontrasepsi_baru,
            $row->keterangan
        ];
    }
}