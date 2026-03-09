<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah posyandu aktif
        $jumlahPosyandu = DB::table('duspy')->count();
        
        // HITUNG TREND POSYANDU - TANPA created_at
        $trendPersentase = 0; // Default 0 dulu
        
        // Hitung jumlah berita
        $jumlahBerita = DB::table('berita')->count();
        
        // Hitung trend berita
        $bulanLalu = now()->subMonth();
        $beritaBulanLalu = DB::table('berita')
            ->whereMonth('tanggal_waktu', $bulanLalu->month)
            ->whereYear('tanggal_waktu', $bulanLalu->year)
            ->count();
        
        $trendBerita = $beritaBulanLalu > 0 
            ? round((($jumlahBerita - $beritaBulanLalu) / $beritaBulanLalu) * 100, 1)
            : 0;
        
        // Ambil 4 berita terbaru
        $beritaTerbaru = DB::table('berita')
            ->orderBy('tanggal_waktu', 'desc')
            ->take(4)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id_berita,
                    'judul' => $item->judul,
                    'ringkasan' => $item->ringkasan,
                    'penulis' => $item->penulis,
                    'tanggal' => date('d M Y', strtotime($item->tanggal_waktu)),
                    'kategori' => $item->kategori ?? 'Info'
                ];
            });

        // KIRIM KE VIEW
        return Inertia::render('Dashboard', [
            'jumlahPosyandu' => $jumlahPosyandu,
            'trendPersentase' => $trendPersentase,
            'jumlahBerita' => $jumlahBerita,
            'trendBerita' => $trendBerita,
            'beritaTerbaru' => $beritaTerbaru,
        ]);
    }
}
