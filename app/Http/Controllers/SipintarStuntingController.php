<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SipintarStuntingController extends Controller
{
    public function index()
    {
        $stunting = DB::table('ai_analisis_stunting as a')
            ->join('bayi as b','b.id_bayi','=','a.id_bayi')
            ->leftJoin('wuspus as w','w.id_wuspus','=','b.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->select(
                'a.id_analisis as id_prediksi',
                'b.nama_bayi',
                'a.umur_bulan',
                'a.berat_badan',
                'a.tinggi_badan',
                'a.status_gizi',
                'a.tingkat_risiko',
                'a.ringkasan as rekomendasi',
                'kec.nama_kec as kecamatan',
                'kel.nama_kel as kelurahan',
                'd.nama_posyandu'
            )
            ->orderByDesc('a.tanggal_analisis')
            ->get();

        $summary = [
            'total'    => $stunting->count(),
            'normal'   => $stunting->where('status_gizi','Normal')->count(),
            'stunting' => $stunting->where('status_gizi','!=','Normal')->count(),
            'avg_risk' => round($stunting->avg('tingkat_risiko') ?? 0, 1),
        ];

        // A. DISTRIBUSI UMUR (PIE)
        $ageDist = DB::table('ai_analisis_stunting')
            ->selectRaw("
                CASE
                    WHEN umur_bulan BETWEEN 0 AND 5 THEN '0-5 bulan'
                    WHEN umur_bulan BETWEEN 6 AND 11 THEN '6-11 bulan'
                    WHEN umur_bulan BETWEEN 12 AND 17 THEN '12-17 bulan'
                    ELSE '18-24 bulan'
                END as label,
                COUNT(*) as jumlah
            ")
            ->groupBy('label')
            ->get();

        // B. TOP 5 KELURAHAN (BAR)
        $topKelurahan = DB::table('ai_analisis_stunting as a')
            ->leftJoin('bayi as b','b.id_bayi','=','a.id_bayi')
            ->leftJoin('wuspus as w','w.id_wuspus','=','b.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->select(
                DB::raw("COALESCE(kel.nama_kel,'Tidak diketahui') as kelurahan"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('kelurahan')
            ->orderByDesc('jumlah')
            ->limit(5)
            ->get();

        // C. TREND 6 BULAN TERAKHIR (BAR)
        $trend = DB::table('ai_analisis_stunting as a')
            ->leftJoin('bayi as b','b.id_bayi','=','a.id_bayi')
            ->leftJoin('wuspus as w','w.id_wuspus','=','b.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->selectRaw("
                DATE_FORMAT(a.tanggal_analisis, '%Y-%m') as periode,
                COALESCE(kec.nama_kec,'Tidak diketahui') as kecamatan,
                COUNT(*) as jumlah
            ")
            ->where('a.tanggal_analisis','>=', now()->subMonths(6))
            ->groupBy('periode','kecamatan')
            ->orderBy('periode')
            ->get();

        // D. HEATMAP (KECAMATAN x BULAN)
        $heatmap = DB::table('ai_analisis_stunting as a')
            ->leftJoin('bayi as b','b.id_bayi','=','a.id_bayi')
            ->leftJoin('wuspus as w','w.id_wuspus','=','b.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->selectRaw("
                COALESCE(kec.nama_kec,'Tidak diketahui') as kecamatan,
                MONTH(a.tanggal_analisis) as bulan,
                COUNT(*) as jumlah
            ")
            ->groupBy('kecamatan','bulan')
            ->get();


        $foodRaw = DB::table('ai_rekomendasi_makanan')->get();

        $food = [];
        foreach ($foodRaw as $f) {
            $food[$f->id_analisis][] = [
                'jenis_makanan'  => $f->jenis_makanan,
                'nama_makanan'   => $f->nama_makanan,
                'porsi_harian'   => $f->porsi_harian,
                'kandungan_gizi' => $f->kandungan_gizi,
                'catatan'        => $f->catatan ?? null,
            ];
        }

        return Inertia::render('sipintar/stunting/Index', [
            'stunting'            => $stunting,
            'summary'             => $summary,
            'heatmap'             => $heatmap,
            'trend'               => $trend,
            'topKelurahan'        => $topKelurahan,
            'ageDist'             => $ageDist,
            'foodRecommendations' => $food,
        ]);
    }
}