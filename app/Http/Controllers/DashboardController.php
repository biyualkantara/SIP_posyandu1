<?php

namespace App\Http\Controllers;

use App\Models\Duspy;
use App\Models\Berita;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah posyandu aktif
        $jumlahPosyandu = DB::table('duspy')->count();
        
        // Hitung jumlah posyandu bulan lalu (contoh untuk trend)
        $bulanLalu = now()->subMonth();
        $jumlahBulanLalu = DB::table('duspy')
            ->whereMonth('created_at', $bulanLalu->month)
            ->whereYear('created_at', $bulanLalu->year)
            ->count();
        
        // Hitung persentase kenaikan/penurunan
        $trendPersentase = $jumlahBulanLalu > 0 
            ? round((($jumlahPosyandu - $jumlahBulanLalu) / $jumlahBulanLalu) * 100, 1)
            : 0;
        
        // Ambil 4 berita terbaru
        $beritaTerbaru = Berita::latest()
            ->take(4)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id_berita,
                    'judul' => $item->judul,
                    'ringkasan' => $item->ringkasan,
                    'penulis' => $item->penulis,
                    'tanggal' => $item->created_at->format('d M Y'),
                    'kategori' => $this->detectKategori($item->judul, $item->ringkasan)
                ];
            });

        return Inertia::render('Dashboard', [
            'jumlahPosyandu' => $jumlahPosyandu,
            'trendPersentase' => $trendPersentase,
            'beritaTerbaru' => $beritaTerbaru,
        ]);
    }

    /**
     * Deteksi kategori berdasarkan judul/ringkasan
     */
    private function detectKategori($judul, $ringkasan)
    {
        $text = strtolower($judul . ' ' . $ringkasan);
        
        if (str_contains($text, 'penting') || str_contains($text, 'urgent') || str_contains($text, 'peringatan')) {
            return 'Penting';
        }
        
        if (str_contains($text, 'kegiatan') || str_contains($text, 'acara') || str_contains($text, 'jadwal')) {
            return 'Kegiatan';
        }
        
        if (str_contains($text, 'imunisasi') || str_contains($text, 'vaksin') || str_contains($text, 'kesehatan')) {
            return 'Kesehatan';
        }
        
        return 'Info';
    }
}