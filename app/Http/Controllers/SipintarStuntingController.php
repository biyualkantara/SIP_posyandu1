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
            'total' => $stunting->count(),
            'normal' => $stunting->where('status_gizi','Normal')->count(),
            'stunting' => $stunting->where('status_gizi','!=','Normal')->count(),
            'avg_risk' => round($stunting->avg('tingkat_risiko') ?? 0, 1),
        ];

        $food = DB::table('ai_rekomendasi_makanan')->get()
            ->groupBy('id_analisis');

        return Inertia::render('sipintar/stunting/Index', [
            'stunting' => $stunting,
            'summary' => $summary,
            'heatmap' => [],
            'trend' => [],
            'topKelurahan' => [],
            'ageDist' => [],
            'foodRecommendations' => $food,
        ]);
    }
}
