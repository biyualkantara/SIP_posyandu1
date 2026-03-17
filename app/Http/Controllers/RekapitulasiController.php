<?php

namespace App\Http\Controllers;

use App\Exports\Format1Export;
use App\Exports\Format2Export;
use App\Exports\Format3Export;
use App\Exports\Format4Export;
use App\Exports\Format5Export;
use App\Models\Duspy;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Wuspus;
use App\Models\WuspusKematian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel; // 🔥 TAMBAHKAN INI!

class RekapitulasiController extends Controller
{
    public function showRekapitulasiView() 
    {
        return Inertia::render("rekapitulasi/Rekapitulasi", [
            "kecamatan" => Kecamatan::all(),
            "kelurahan" => Kelurahan::all()->groupBy('id_kec'),
            "posyandu" => Duspy::all()->groupBy("id_kel"),
            "wuspus" => Wuspus::all()->groupBy("id_posyandu"),
        ]);
    }

    public function exportFormat(Request $request, $format) 
    {
        // Ambil parameter filter
        $id_kecamatan = $request->query('id_kecamatan');
        $id_kelurahan = $request->query('id_kelurahan');
        $id_posyandu = $request->query('id_posyandu');
        $tahun = $request->query('tahun');
        $output = $request->query('output', 'pdf'); // default PDF
        
        // Ambil data untuk header
        $kecamatan = $id_kecamatan ? Kecamatan::find($id_kecamatan) : null;
        $kelurahan = $id_kelurahan ? Kelurahan::find($id_kelurahan) : null;
        $posyandu = $id_posyandu ? Duspy::find($id_posyandu) : null;
        
        // Handle filter tahun
        $tahun = ($tahun === 'All' || !$tahun) ? '' : $tahun;
        
        // Validasi tahun tidak boleh lebih dari tahun sekarang
        $tahunSekarang = date('Y');
        if ($tahun && $tahun > $tahunSekarang) {
            return back()->with('error', "Data untuk tahun $tahun belum tersedia. Maksimal tahun $tahunSekarang.");
        }
        
        // ============= FORMAT 1 =============
        if ($format === 'f1') {
            if ($output === 'excel') {
                // EXPORT EXCEL
                return Excel::download(
                    new Format1Export($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun),
                    'format1_' . date('Ymd') . '.xlsx'
                );
            } else {
                // EXPORT PDF
                $records = $this->getDataFormat1(
                    $id_kecamatan,
                    $id_kelurahan,
                    $id_posyandu,
                    $tahun
                );
                
                return Pdf::loadView('rekapitulasi.format_1', [
                    'kecamatan' => $kecamatan->nama_kec ?? 'SEMUA KECAMATAN',
                    'kelurahan' => $kelurahan->nama_kel ?? 'SEMUA KELURAHAN',
                    'posyandu' => $posyandu->nama_posyandu ?? 'SEMUA POSYANDU',
                    'tahun' => $tahun ?: 'SEMUA TAHUN',
                    'records' => $records,
                    'total' => count($records),
                    'tahunSekarang' => $tahunSekarang
                ])
                ->setPaper('a4', 'landscape')
                ->download('rekapitulasi_format1.pdf');
            }
        }
        
        // ============= FORMAT 2 =============
        if ($format === 'f2') {
            if ($output === 'excel') {
                // EXPORT EXCEL FORMAT 2
                return Excel::download(
                    new Format2Export($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun),
                    'format2_' . date('Ymd') . '.xlsx'
                );
            } else {
                // EXPORT PDF FORMAT 2 - PERBAIKAN: Tambah $records
                $records = $this->getDataFormat2(
                    $id_kecamatan,
                    $id_kelurahan,
                    $id_posyandu,
                    $tahun
                );
                
                return Pdf::loadView('rekapitulasi.format_2', [
                    'kecamatan' => $kecamatan->nama_kec ?? 'SEMUA KECAMATAN',
                    'kelurahan' => $kelurahan->nama_kel ?? 'SEMUA KELURAHAN',
                    'posyandu' => $posyandu->nama_posyandu ?? 'SEMUA POSYANDU',
                    'tahun' => $tahun ?: date('Y'),
                    'records' => $records // 🔥 INI PENTING!
                ])
                ->setPaper('a4', 'landscape')
                ->download('format2.pdf');
            }
        }
        
        // ============= FORMAT 3 =============
        if ($format === 'f3') {
            if ($output === 'excel') {
                // EXPORT EXCEL FORMAT 3
                return Excel::download(
                    new Format3Export($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun),
                    'format3_' . date('Ymd') . '.xlsx'
                );
            } else {
                // EXPORT PDF FORMAT 3
                $records = $this->getDataFormat3(
                    $id_kecamatan,
                    $id_kelurahan,
                    $id_posyandu,
                    $tahun
                );
                
                return Pdf::loadView('rekapitulasi.format_3', [
                    'kecamatan' => $kecamatan->nama_kec ?? 'SEMUA KECAMATAN',
                    'kelurahan' => $kelurahan->nama_kel ?? 'SEMUA KELURAHAN',
                    'posyandu' => $posyandu->nama_posyandu ?? 'SEMUA POSYANDU',
                    'tahun' => $tahun ?: date('Y'),
                    'records' => $records
                ])
                ->setPaper('a4', 'landscape')
                ->download('format3.pdf');
            }
        }
       // ============= FORMAT 4 =============
        if ($format === 'f4') {
            if ($output === 'excel') {
                // EXPORT EXCEL FORMAT 4
                return Excel::download(
                    new Format4Export($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun),
                    'format4_' . date('Ymd') . '.xlsx'
                );
            } else {
                // EXPORT PDF FORMAT 4
                $records = $this->getDataFormat4(
                    $id_kecamatan,
                    $id_kelurahan,
                    $id_posyandu,
                    $tahun
                );
                
                return Pdf::loadView('rekapitulasi.format_4', [
                    'kecamatan' => $kecamatan->nama_kec ?? 'SEMUA KECAMATAN',
                    'kelurahan' => $kelurahan->nama_kel ?? 'SEMUA KELURAHAN',
                    'posyandu' => $posyandu->nama_posyandu ?? 'SEMUA POSYANDU',
                    'tahun' => $tahun ?: date('Y'),
                    'records' => $records
                ])
                ->setPaper('a4', 'landscape')
                ->download('format4.pdf');
            }
        }
        
       // ============= FORMAT 5 =============
        if ($format === 'f5') {
            if ($output === 'excel') {
                // EXPORT EXCEL FORMAT 5
                return Excel::download(
                    new Format5Export($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun),
                    'format5_' . date('Ymd') . '.xlsx'
                );
            } else {
                // EXPORT PDF FORMAT 5
                $records = $this->getDataFormat5(
                    $id_kecamatan,
                    $id_kelurahan,
                    $id_posyandu,
                    $tahun
                );
                
                return Pdf::loadView('rekapitulasi.format_5', [
                    'kecamatan' => $kecamatan->nama_kec ?? 'SEMUA KECAMATAN',
                    'kelurahan' => $kelurahan->nama_kel ?? 'SEMUA KELURAHAN',
                    'posyandu' => $posyandu->nama_posyandu ?? 'SEMUA POSYANDU',
                    'tahun' => $tahun ?: date('Y'),
                    'records' => $records
                ])
                ->setPaper('a4', 'landscape')
                ->download('format5.pdf');
            }
        }

        // ============= FORMAT 6 =============
    if ($format === 'f6') {
        if ($output === 'excel') {
            // EXPORT EXCEL FORMAT 6
            return Excel::download(
                new KaderPosyanduExport($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun),
                'format6_' . date('Ymd') . '.xlsx'
            );
        } else {
            // EXPORT PDF FORMAT 6
            $records = $this->getDataKaderPosyandu(
                $id_kecamatan,
                $id_kelurahan,
                $id_posyandu,
                $tahun
            );
            
            return Pdf::loadView('rekapitulasi.format_6', [
                'kecamatan' => $kecamatan->nama_kec ?? 'SEMUA KECAMATAN',
                'kelurahan' => $kelurahan->nama_kel ?? 'SEMUA KELURAHAN',
                'posyandu' => $posyandu->nama_posyandu ?? 'SEMUA POSYANDU',
                'tahun' => $tahun ?: date('Y'),
                'records' => $records
            ])
            ->setPaper('a4', 'landscape')
            ->download('format6.pdf');
        }
    }
        
        // Kalau format tidak dikenal
        return back()->with('error', 'Format tidak tersedia');

    }

    

    /**
     * Get data untuk Format 1
     */
    private function getDataFormat1($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun)
    {
        // Query utama
        $query = DB::table('bayi as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            
            // Join untuk kematian bayi
            ->leftJoin('bayi_wafat as bw', 'bw.id_bayi', '=', 'b.id_bayi')
            
            // Join untuk kematian ibu (wuspus)
            ->leftJoin('wuspus_kematians as wk', 'wk.id_wuspus', '=', 'w.id_wuspus')
            
            ->select([
                // Data Ibu
                'w.nama_wuspus as nama_ibu',
                'w.nik_wuspus',
                DB::raw("'-' as nama_bapak"),
                
                // Data Bayi
                'b.id_bayi',
                'b.nama_bayi',
                'b.tgl_lhr as tgl_lahir',
                'b.jk',
                'b.bb',
                
                // Data Kematian Bayi
                'bw.id_wafat as id_wafat_bayi',
                'bw.tgl_kematian as tgl_meninggal_bayi',
                'bw.ket as ket_bayi',
                
                // Data Kematian Ibu
                'wk.id as id_wafat_ibu',
                'wk.tgl_wafat as tgl_meninggal_ibu',
                'wk.penyebab',
                'wk.ket as ket_ibu',
                
                // Data lokasi
                'kec.id_kec',
                'kec.nama_kec',
                'kel.id_kel',
                'kel.nama_kel',
                'd.id_posyandu',
                'd.nama_posyandu',
            ])
            ->orderBy('b.tgl_lhr', 'desc');

        // Filter kecamatan
        if (!empty($id_kecamatan)) {
            $query->where('kec.id_kec', $id_kecamatan);
        }
        
        // Filter kelurahan
        if (!empty($id_kelurahan)) {
            $query->where('kel.id_kel', $id_kelurahan);
        }
        
        // Filter posyandu
        if (!empty($id_posyandu)) {
            $query->where('d.id_posyandu', $id_posyandu);
        }
        
        // Filter tahun - hanya jika tahun valid
        if (!empty($tahun) && $tahun <= date('Y')) {
            $query->whereYear('b.tgl_lhr', $tahun);
        }
        
        $results = $query->get();
        
        // Format data untuk view
        $formatted = [];
        
        foreach ($results as $row) {
            // Buat keterangan
            $keterangan = [];
            
            if ($row->tgl_meninggal_bayi) {
                $keterangan[] = 'Bayi meninggal: ' . ($row->ket_bayi ?: '-');
            }
            
            if ($row->tgl_meninggal_ibu) {
                $keterangan[] = 'Ibu meninggal: ' . ($row->penyebab ?: $row->ket_ibu ?: '-');
            }
            
            if (empty($keterangan)) {
                $keterangan[] = 'Bayi hidup';
            }
            
            $formatted[] = (object)[
                'nama_ibu' => $row->nama_ibu ?? '-',
                'nama_bapak' => '-',
                'nama_bayi' => $row->nama_bayi ?? '-',
                'tgl_lahir' => $row->tgl_lahir,
                'tgl_meninggal_bayi' => $row->tgl_meninggal_bayi,
                'tgl_meninggal_ibu' => $row->tgl_meninggal_ibu,
                'keterangan' => implode('; ', $keterangan)
            ];
        }
        
        return $formatted;
    }

  private function getDataFormat2($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun)
{
    // CEK DULU TABEL YANG ADA
    $tables = DB::select('SHOW TABLES');
    $tableNames = array_map('current', $tables);
    
    $hasPenimbangan = in_array('bayi_penimbangan', $tableNames);
    $hasImunisasi = in_array('bayi_imunisasi', $tableNames);
    
    // Log untuk debugging
    \Log::info('Tabel yang tersedia:', [
        'hasPenimbangan' => $hasPenimbangan,
        'hasImunisasi' => $hasImunisasi
    ]);
    
    // Ambil semua bayi dengan filter lokasi
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
            DB::raw("COALESCE(b.ket, '') as ket_bayi"),
        ]);

    // Filter lokasi
    if (!empty($id_kecamatan)) {
        $bayiQuery->where('kec.id_kec', $id_kecamatan);
    }
    if (!empty($id_kelurahan)) {
        $bayiQuery->where('kel.id_kel', $id_kelurahan);
    }
    if (!empty($id_posyandu)) {
        $bayiQuery->where('d.id_posyandu', $id_posyandu);
    }
    
    // Filter tahun
    if (!empty($tahun) && $tahun !== 'All') {
        $bayiQuery->whereYear('b.tgl_lhr', $tahun);
    }
    
    $bayiList = $bayiQuery->get();
    
    $result = [];
    
    foreach ($bayiList as $bayi) {
        // DEFAULT: Semua data kosong
        $penimbanganPerBulan = [];
        $imunisasiList = [];
        $vitACount = 0;
        
        // Ambil data penimbangan JIKA TABELNYA ADA
        if ($hasPenimbangan) {
            try {
                $penimbangan = DB::table('bayi_penimbangan')
                    ->where('id_bayi', $bayi->id_bayi)
                    ->whereYear('tanggal', $tahun && $tahun !== 'All' ? $tahun : date('Y'))
                    ->selectRaw('MONTH(tanggal) as bulan, berat_badan')
                    ->get()
                    ->keyBy('bulan');
                    
                foreach ($penimbangan as $bulan => $data) {
                    $penimbanganPerBulan[$bulan] = $data->berat_badan;
                }
            } catch (\Exception $e) {
                \Log::warning('Gagal ambil penimbangan: ' . $e->getMessage());
            }
        }
        
        // Ambil data imunisasi JIKA TABELNYA ADA
        if ($hasImunisasi) {
            try {
                $imunisasi = DB::table('bayi_imunisasi')
                    ->where('id_bayi', $bayi->id_bayi)
                    ->select('jenis')
                    ->get()
                    ->pluck('jenis')
                    ->map(function($item) {
                        return strtoupper(trim($item));
                    });
                
                $imunisasiList = $imunisasi->toArray();
                
                // Hitung Vit A
                foreach ($imunisasi as $item) {
                    if (strpos($item, 'VIT') !== false || 
                        strpos($item, 'A') !== false || 
                        strpos($item, 'VITAMIN') !== false) {
                        $vitACount++;
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('Gagal ambil imunisasi: ' . $e->getMessage());
            }
        }
        
        // Mapping imunisasi
        $bcg = in_array('BCG', $imunisasiList) ? '✓' : '-';
        $dpt1 = (in_array('DPT-1', $imunisasiList) || in_array('DPT 1', $imunisasiList) || in_array('DPT1', $imunisasiList)) ? '✓' : '-';
        $dpt2 = (in_array('DPT-2', $imunisasiList) || in_array('DPT 2', $imunisasiList) || in_array('DPT2', $imunisasiList)) ? '✓' : '-';
        $dpt3 = (in_array('DPT-3', $imunisasiList) || in_array('DPT 3', $imunisasiList) || in_array('DPT3', $imunisasiList)) ? '✓' : '-';
        $polio1 = (in_array('POLIO-1', $imunisasiList) || in_array('POLIO 1', $imunisasiList) || in_array('POLIO1', $imunisasiList)) ? '✓' : '-';
        $polio2 = (in_array('POLIO-2', $imunisasiList) || in_array('POLIO 2', $imunisasiList) || in_array('POLIO2', $imunisasiList)) ? '✓' : '-';
        $polio3 = (in_array('POLIO-3', $imunisasiList) || in_array('POLIO 3', $imunisasiList) || in_array('POLIO3', $imunisasiList)) ? '✓' : '-';
        $polio4 = (in_array('POLIO-4', $imunisasiList) || in_array('POLIO 4', $imunisasiList) || in_array('POLIO4', $imunisasiList)) ? '✓' : '-';
        $campak = (in_array('CAMPAK', $imunisasiList) || in_array('CAMPAK', $imunisasiList)) ? '✓' : '-';
        $hep1 = (in_array('HEP-1', $imunisasiList) || in_array('HEP 1', $imunisasiList) || in_array('HEP1', $imunisasiList) || in_array('HEPATITIS 1', $imunisasiList)) ? '✓' : '-';
        $hep2 = (in_array('HEP-2', $imunisasiList) || in_array('HEP 2', $imunisasiList) || in_array('HEP2', $imunisasiList) || in_array('HEPATITIS 2', $imunisasiList)) ? '✓' : '-';
        $hep3 = (in_array('HEP-3', $imunisasiList) || in_array('HEP 3', $imunisasiList) || in_array('HEP3', $imunisasiList) || in_array('HEPATITIS 3', $imunisasiList)) ? '✓' : '-';
        
        $row = (object)[
            'nama_bayi' => $bayi->nama_bayi ?? '-',
            'tgl_lahir' => $bayi->tgl_lhr,
            'bb_lahir' => $bayi->bb_lahir ?? '-',
            'nama_ayah' => '-',
            'nama_ibu' => $bayi->nama_ibu ?? '-',
            'dasa_wisma' => '-',
            
            // Hasil penimbangan per bulan (AMAN)
            'bb_jan' => $penimbanganPerBulan[1] ?? '-',
            'bb_feb' => $penimbanganPerBulan[2] ?? '-',
            'bb_mar' => $penimbanganPerBulan[3] ?? '-',
            'bb_apr' => $penimbanganPerBulan[4] ?? '-',
            'bb_mei' => $penimbanganPerBulan[5] ?? '-',
            'bb_jun' => $penimbanganPerBulan[6] ?? '-',
            'bb_jul' => $penimbanganPerBulan[7] ?? '-',
            'bb_ags' => $penimbanganPerBulan[8] ?? '-',
            'bb_sep' => $penimbanganPerBulan[9] ?? '-',
            'bb_okt' => $penimbanganPerBulan[10] ?? '-',
            'bb_nov' => $penimbanganPerBulan[11] ?? '-',
            'bb_des' => $penimbanganPerBulan[12] ?? '-',
            
            // Vit A
            'vit_a1' => $vitACount >= 1 ? '✓' : '-',
            'vit_a2' => $vitACount >= 2 ? '✓' : '-',
            
            // Imunisasi
            'bcg' => $bcg,
            'dpt1' => $dpt1,
            'dpt2' => $dpt2,
            'dpt3' => $dpt3,
            'polio1' => $polio1,
            'polio2' => $polio2,
            'polio3' => $polio3,
            'polio4' => $polio4,
            'campak' => $campak,
            'hep1' => $hep1,
            'hep2' => $hep2,
            'hep3' => $hep3,
            
            // Kematian
            'tgl_meninggal' => $bayi->tgl_kematian,
            'keterangan' => $bayi->ket_wafat ?: ($bayi->ket_bayi ?: '-')
        ];
        
        $result[] = $row;
    }
    
    return $result;
}

/**
 * Get data untuk Format 3 (WUS/PUS)
 */
private function getDataFormat3($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun)
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
        
        ->select([
            'w.id_wuspus',
            'w.nama_wuspus',
            'w.umur',
            'w.nama_suami',
            'w.thpn_ks as tahapan_ks',
            'w.klmpk_dasawisma',
            'w.jml_anak_hdp',
            'w.jml_anak_meninggal',
            DB::raw("'-' as lila"),
            'w.status',
            'w.ket',
            
            // Kontrasepsi
            'kb.jns_kontrasepsi',
            'kb.tgl_ganti',
            'kb.kontrasepsi_baru',
            
            // Lokasi untuk filter
            'kec.id_kec',
            'kel.id_kel',
            'd.id_posyandu',
        ]);

    // Filter lokasi
    if (!empty($id_kecamatan)) {
        $query->where('kec.id_kec', $id_kecamatan);
    }
    if (!empty($id_kelurahan)) {
        $query->where('kel.id_kel', $id_kelurahan);
    }
    if (!empty($id_posyandu)) {
        $query->where('d.id_posyandu', $id_posyandu);
    }
    
    // Filter tahun (berdasarkan tgl_daftar)
    if (!empty($tahun) && $tahun !== 'All') {
        $query->whereYear('w.tgl_daftar', $tahun);
    }
    
    $wuspusList = $query->get();
    
    $result = [];
    
    foreach ($wuspusList as $wuspus) {
        // Ambil data imunisasi TT
        $imunisasiTT = DB::table('wuspus_imun as wi')
            ->join('imunisasi as i', 'i.id_imun', '=', 'wi.id_imun')
            ->where('wi.id_wuspus', $wuspus->id_wuspus)
            ->where('i.imun_untuk', 'WUS/PUS')
            ->where('i.jns_imun', 'LIKE', '%TT%')
            ->select('i.jns_imun')
            ->get()
            ->pluck('jns_imun')
            ->toArray();
        
        $tt_i = in_array('TT I', $imunisasiTT) || in_array('TT-1', $imunisasiTT) ? '✓' : '-';
        $tt_ii = in_array('TT II', $imunisasiTT) || in_array('TT-2', $imunisasiTT) ? '✓' : '-';
        $tt_lengkap = count($imunisasiTT) >= 2 ? '✓' : '-';
        
        // Format kontrasepsi baru
        $kontrasepsiBaru = '-';
        if ($wuspus->kontrasepsi_baru == 1) {
            $kontrasepsiBaru = 'Ya';
        } elseif ($wuspus->kontrasepsi_baru == 0) {
            $kontrasepsiBaru = 'Tidak';
        }
        
        // Keterangan (status)
        $keterangan = $wuspus->status ?? '-';
        if ($keterangan == 'Meninggal') {
            $keterangan = 'MENINGGAL';
        } elseif ($keterangan == 'Pindah') {
            $keterangan = 'PINDAH';
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
            'lila' => '-',
            'kapsul_yodium' => '-',
            'tt_i' => $tt_i,
            'tt_ii' => $tt_ii,
            'tt_lengkap' => $tt_lengkap,
            'jns_kontrasepsi' => $wuspus->jns_kontrasepsi ?? '-',
            'tgl_ganti' => $wuspus->tgl_ganti,
            'kontrasepsi_baru' => $kontrasepsiBaru,
            'keterangan' => $keterangan
        ];
        
        $result[] = $row;
    }
    
    return $result;
}

/**
 * Get data untuk Format 4 (Ibu Hamil)
 */
private function getDataFormat4($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun)
{
    // Query utama dari tabel bumil
    $query = DB::table('bumil as b')
        ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
        ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
        ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
        ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
        
        // LEFT JOIN untuk penimbangan (ambil data terbaru per bulan)
        ->leftJoin('bumil_pnb as p', function($join) {
            $join->on('p.id_wuspus', '=', 'w.id_wuspus');
        })
        
        // LEFT JOIN untuk imunisasi TT
        ->leftJoin('bumil_imun as bi', function($join) {
            $join->on('bi.id_wuspus', '=', 'w.id_wuspus');
        })
        
        // LEFT JOIN untuk imunisasi (jenis imunisasi)
        ->leftJoin('imunisasi as i', 'i.id_imun', '=', 'bi.id_imun')
        
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
            
            // Data penimbangan
            'p.tgl_pnb',
            'p.berat',
            'p.bln_hamil as bulan_hamil',
            'p.hasil as hasil_pnb',
            
            // Data imunisasi TT
            'bi.tgl_imun',
            'i.jns_imun',
            
            // Lokasi untuk filter
            'kec.id_kec',
            'kel.id_kel',
            'd.id_posyandu',
        ]);

    // Filter lokasi
    if (!empty($id_kecamatan)) {
        $query->where('kec.id_kec', $id_kecamatan);
    }
    if (!empty($id_kelurahan)) {
        $query->where('kel.id_kel', $id_kelurahan);
    }
    if (!empty($id_posyandu)) {
        $query->where('d.id_posyandu', $id_posyandu);
    }
    
    // Filter tahun
    if (!empty($tahun) && $tahun !== 'All') {
        $query->whereYear('b.tgl_daftar', $tahun);
    }
    
    $bumilList = $query->get();
    
    // Kelompokkan data per ibu hamil
    $grouped = [];
    foreach ($bumilList as $row) {
        $key = $row->id_bumil;
        if (!isset($grouped[$key])) {
            $grouped[$key] = [
                'bumil' => $row,
                'penimbangan' => [],
                'imunisasi' => []
            ];
        }
        
        // Kumpulkan penimbangan
        if ($row->tgl_pnb) {
            $bulan = date('n', strtotime($row->tgl_pnb));
            $grouped[$key]['penimbangan'][$bulan] = $row->berat;
        }
        
        // Kumpulkan imunisasi TT
        if ($row->jns_imun && strpos($row->jns_imun, 'TT') !== false) {
            $grouped[$key]['imunisasi'][] = $row->jns_imun;
        }
    }
    
    $result = [];
    
    foreach ($grouped as $item) {
        $bumil = $item['bumil'];
        $penimbangan = $item['penimbangan'];
        $imunisasi = $item['imunisasi'];
        
        // Cek imunisasi TT
        $tt_i = in_array('TT I', $imunisasi) || in_array('TT-1', $imunisasi) ? '✓' : '-';
        $tt_ii = in_array('TT II', $imunisasi) || in_array('TT-2', $imunisasi) ? '✓' : '-';
        
        // Kapsul Yodium (default '-', bisa dikembangkan)
        $kapsul_yodium = '-';
        
        // Resiko (default '-', bisa dikembangkan)
        $resiko = $bumil->lila && $bumil->lila < 23.5 ? 'Risiko' : '-';
        
        // Data melahirkan (default kosong, bisa dikembangkan)
        $tgl_melahirkan = '-';
        $nakes = '-';
        $dukun = '-';
        
        // Data bayi (default kosong)
        $bayi_lt2kg = '-';
        $bayi_2_25 = '-';
        $bayi_gt25 = '-';
        $bayi_mati = '-';
        
        // Kematian ibu (default '-')
        $ibu_meninggal = '-';
        
        $row = (object)[
            'no' => count($result) + 1,
            'nama_ibu' => $bumil->nama_ibu ?? '-',
            'umur' => $bumil->umur ?? '-',
            'dasa_wisma' => $bumil->klmpk_dasawisma ?? '-',
            'tgl_daftar' => $bumil->tgl_daftar,
            'uk' => $bumil->umur_kehamilan ?? '-',
            'hamil_ke' => $bumil->hamil_ke ?? '-',
            
            // Pil tambah darah (I, II, III) - default kosong
            'pil_i' => '-',
            'pil_ii' => '-',
            'pil_iii' => '-',
            
            // Imunisasi TT
            'tt_i' => $tt_i,
            'tt_ii' => $tt_ii,
            
            // Kapsul Yodium
            'kapsul_yodium' => $kapsul_yodium,
            
            // Hasil penimbangan per bulan
            'bb_jan' => $penimbangan[1] ?? '-',
            'bb_feb' => $penimbangan[2] ?? '-',
            'bb_mar' => $penimbangan[3] ?? '-',
            'bb_apr' => $penimbangan[4] ?? '-',
            'bb_mei' => $penimbangan[5] ?? '-',
            'bb_jun' => $penimbangan[6] ?? '-',
            'bb_jul' => $penimbangan[7] ?? '-',
            'bb_ags' => $penimbangan[8] ?? '-',
            'bb_sep' => $penimbangan[9] ?? '-',
            'bb_okt' => $penimbangan[10] ?? '-',
            'bb_nov' => $penimbangan[11] ?? '-',
            'bb_des' => $penimbangan[12] ?? '-',
            
            // Resiko
            'resiko' => $resiko,
            
            // Melahirkan
            'tgl_melahirkan' => $tgl_melahirkan,
            'nakes' => $nakes,
            'dukun' => $dukun,
            
            // Bayi
            'bayi_lt2kg' => $bayi_lt2kg,
            'bayi_2_25' => $bayi_2_25,
            'bayi_gt25' => $bayi_gt25,
            'bayi_mati' => $bayi_mati,
            
            // Ibu meninggal
            'ibu_meninggal' => $ibu_meninggal,
        ];
        
        $result[] = $row;
    }
    
    return $result;
}

/**
 * Get data untuk Format 5 (Data Pengunjung & Petugas)
 */
private function getDataFormat5($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun)
{
    // Data per bulan (Januari - Desember)
    $months = [
        1 => 'JANUARI', 2 => 'FEBRUARI', 3 => 'MARET', 4 => 'APRIL',
        5 => 'MEI', 6 => 'JUNI', 7 => 'JULI', 8 => 'AGUSTUS',
        9 => 'SEPTEMBER', 10 => 'OKTOBER', 11 => 'NOVEMBER', 12 => 'DESEMBER'
    ];
    
    $tahun = $tahun && $tahun !== 'All' ? $tahun : date('Y');
    $result = [];
    
    foreach ($months as $monthNum => $monthName) {
        // Ambil data kehadiran kader untuk bulan ini
        $kehadiran = $this->getKehadiranKaderFormat5($monthNum, $tahun, $id_kecamatan, $id_kelurahan, $id_posyandu);
        
        // Hitung jumlah bayi
        $bayi = $this->getJumlahBayiFormat5($monthNum, $tahun, $id_kecamatan, $id_kelurahan, $id_posyandu);
        
        // Hitung jumlah WUS dan PUS
        $wuspus = $this->getJumlahWusPusFormat5($id_kecamatan, $id_kelurahan, $id_posyandu);
        
        // Hitung jumlah ibu hamil
        $bumil = $this->getJumlahBumilFormat5($id_kecamatan, $id_kelurahan, $id_posyandu);
        
        // Hitung jumlah ibu menyusui
        $menyusui = $this->getJumlahMenyusuiFormat5($monthNum, $tahun, $id_kecamatan, $id_kelurahan, $id_posyandu);
        
        // Hitung jumlah bayi lahir
        $lahir = $this->getJumlahLahirFormat5($monthNum, $tahun, $id_kecamatan, $id_kelurahan, $id_posyandu);
        
        // Hitung jumlah bayi meninggal
        $meninggal = $this->getJumlahMeninggalFormat5($monthNum, $tahun, $id_kecamatan, $id_kelurahan, $id_posyandu);
        
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
            'keterangan' => $this->formatKeterangan($lahir, $meninggal)
        ];
        
        $result[] = $row;
    }
    
    return $result;
}

/**
 * Ambil data kehadiran kader untuk format 5
 */
private function getKehadiranKaderFormat5($bulan, $tahun, $id_kecamatan, $id_kelurahan, $id_posyandu)
{
    $tanggal = sprintf('%d-%02d-01', $tahun, $bulan);
    
    $query = DB::table('kdrhdr as k')
        ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'k.id_posyandu')
        ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
        ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
        ->where('k.bulan', 'like', $tanggal . '%');
    
    // Filter lokasi
    if (!empty($id_kecamatan)) {
        $query->where('kec.id_kec', $id_kecamatan);
    }
    if (!empty($id_kelurahan)) {
        $query->where('kel.id_kel', $id_kelurahan);
    }
    if (!empty($id_posyandu)) {
        $query->where('d.id_posyandu', $id_posyandu);
    }
    
    $data = $query->get();
    
    $result = [
        'pkk_l' => 0, 'pkk_p' => 0,
        'plkb_l' => 0, 'plkb_p' => 0,
        'medis_l' => 0, 'medis_p' => 0
    ];
    
    foreach ($data as $item) {
        // Asumsi L/P seimbang
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
 * Hitung jumlah bayi untuk format 5
 */
private function getJumlahBayiFormat5($bulan, $tahun, $id_kecamatan, $id_kelurahan, $id_posyandu)
{
    $tanggalCutoff = sprintf('%d-%02d-01', $tahun, $bulan);
    
    $query = DB::table('bayi as b')
        ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
        ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
        ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
        ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
        ->select('b.jk', 'b.tgl_lhr');
    
    // Filter lokasi
    if (!empty($id_kecamatan)) {
        $query->where('kec.id_kec', $id_kecamatan);
    }
    if (!empty($id_kelurahan)) {
        $query->where('kel.id_kel', $id_kelurahan);
    }
    if (!empty($id_posyandu)) {
        $query->where('d.id_posyandu', $id_posyandu);
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
        } elseif ($umurBulan <= 60) {
            $result["1-5_{$jk}"]++;
        }
    }
    
    return $result;
}

/**
 * Hitung jumlah WUS dan PUS untuk format 5
 */
private function getJumlahWusPusFormat5($id_kecamatan, $id_kelurahan, $id_posyandu)
{
    $query = DB::table('wuspus as w')
        ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
        ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
        ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
        ->select('w.status');
    
    // Filter lokasi
    if (!empty($id_kecamatan)) {
        $query->where('kec.id_kec', $id_kecamatan);
    }
    if (!empty($id_kelurahan)) {
        $query->where('kel.id_kel', $id_kelurahan);
    }
    if (!empty($id_posyandu)) {
        $query->where('d.id_posyandu', $id_posyandu);
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
 * Hitung jumlah ibu hamil untuk format 5
 */
private function getJumlahBumilFormat5($id_kecamatan, $id_kelurahan, $id_posyandu)
{
    $query = DB::table('bumil as b')
        ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
        ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
        ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
        ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec');
    
    // Filter lokasi
    if (!empty($id_kecamatan)) {
        $query->where('kec.id_kec', $id_kecamatan);
    }
    if (!empty($id_kelurahan)) {
        $query->where('kel.id_kel', $id_kelurahan);
    }
    if (!empty($id_posyandu)) {
        $query->where('d.id_posyandu', $id_posyandu);
    }
    
    return $query->count();
}

/**
 * Hitung jumlah ibu menyusui untuk format 5
 */
private function getJumlahMenyusuiFormat5($bulan, $tahun, $id_kecamatan, $id_kelurahan, $id_posyandu)
{
    $tanggalCutoff = sprintf('%d-%02d-01', $tahun, $bulan);
    
    $query = DB::table('bayi as b')
        ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
        ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
        ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
        ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
        ->whereRaw("TIMESTAMPDIFF(MONTH, b.tgl_lhr, '{$tanggalCutoff}') <= 6");
    
    // Filter lokasi
    if (!empty($id_kecamatan)) {
        $query->where('kec.id_kec', $id_kecamatan);
    }
    if (!empty($id_kelurahan)) {
        $query->where('kel.id_kel', $id_kelurahan);
    }
    if (!empty($id_posyandu)) {
        $query->where('d.id_posyandu', $id_posyandu);
    }
    
    return $query->distinct('w.id_wuspus')->count('w.id_wuspus');
}

/**
 * Hitung jumlah bayi lahir untuk format 5
 */
private function getJumlahLahirFormat5($bulan, $tahun, $id_kecamatan, $id_kelurahan, $id_posyandu)
{
    $startDate = sprintf('%d-%02d-01', $tahun, $bulan);
    $endDate = date('Y-m-t', strtotime($startDate));
    
    $query = DB::table('bayi as b')
        ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
        ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
        ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
        ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
        ->whereBetween('b.tgl_lhr', [$startDate, $endDate])
        ->select('b.jk', 'b.nama_bayi');
    
    // Filter lokasi
    if (!empty($id_kecamatan)) {
        $query->where('kec.id_kec', $id_kecamatan);
    }
    if (!empty($id_kelurahan)) {
        $query->where('kel.id_kel', $id_kelurahan);
    }
    if (!empty($id_posyandu)) {
        $query->where('d.id_posyandu', $id_posyandu);
    }
    
    $bayiList = $query->get();
    
    $result = ['l' => 0, 'p' => 0];
    
    foreach ($bayiList as $bayi) {
        if ($bayi->jk == 'L') {
            $result['l']++;
        } else {
            $result['p']++;
        }
    }
    
    return $result;
}

/**
 * Hitung jumlah bayi meninggal untuk format 5
 */
private function getJumlahMeninggalFormat5($bulan, $tahun, $id_kecamatan, $id_kelurahan, $id_posyandu)
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
        ->select('b.jk');
    
    // Filter lokasi
    if (!empty($id_kecamatan)) {
        $query->where('kec.id_kec', $id_kecamatan);
    }
    if (!empty($id_kelurahan)) {
        $query->where('kel.id_kel', $id_kelurahan);
    }
    if (!empty($id_posyandu)) {
        $query->where('d.id_posyandu', $id_posyandu);
    }
    
    $meninggalList = $query->get();
    
    $result = ['l' => 0, 'p' => 0];
    
    foreach ($meninggalList as $m) {
        if ($m->jk == 'L') {
            $result['l']++;
        } else {
            $result['p']++;
        }
    }
    
    return $result;
}

/**
 * Format keterangan untuk format 5
 */
private function formatKeterangan($lahir, $meninggal)
{
    $keterangan = [];
    
    if ($lahir['l'] > 0 || $lahir['p'] > 0) {
        $keterangan[] = "Lahir: L{$lahir['l']}/P{$lahir['p']}";
    }
    
    if ($meninggal['l'] > 0 || $meninggal['p'] > 0) {
        $keterangan[] = "Meninggal: L{$meninggal['l']}/P{$meninggal['p']}";
    }
    
    return implode(', ', $keterangan);
}

/**
 * Get data untuk Format 6 (Data Kegiatan Posyandu)
 */
private function getDataKaderPosyandu($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun)
{
    // Data per bulan (Januari - Desember)
    $months = [
        1 => 'JANUARI', 2 => 'FEBRUARI', 3 => 'MARET', 4 => 'APRIL',
        5 => 'MEI', 6 => 'JUNI', 7 => 'JULI', 8 => 'AGUSTUS',
        9 => 'SEPTEMBER', 10 => 'OKTOBER', 11 => 'NOVEMBER', 12 => 'DESEMBER'
    ];
    
    $tahun = $tahun && $tahun !== 'All' ? $tahun : date('Y');
    $result = [];
    
    // Buat instance export untuk memanggil method-methodnya
    $export = new \App\Exports\KaderPosyanduExport($id_kecamatan, $id_kelurahan, $id_posyandu, $tahun);
    
    // Gunakan reflection untuk akses private methods
    $reflection = new \ReflectionClass($export);
    
    foreach ($months as $monthNum => $monthName) {
        // Panggil method getDataPerBulan melalui reflection
        $method = $reflection->getMethod('getDataPerBulan');
        $method->setAccessible(true);
        $dataBulan = $method->invoke($export, $monthNum, $tahun);
        
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
    
    return $result;
}

}