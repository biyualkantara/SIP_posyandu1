<?php

namespace App\Http\Controllers;

use App\Services\StuntingAiService;
use Illuminate\Support\Facades\DB;

class AiStuntingPredictController extends Controller
{
    public function predictForAll()
    {
        $bayiList = DB::table('bayi')->get();
        $berhasil = 0;

        foreach ($bayiList as $b) {

            if (!$b->tgl_lhr || !$b->bb || !$b->tb_terkini) {
                continue;
            }

            $umur = floor((time() - strtotime($b->tgl_lhr)) / (30 * 24 * 3600));
            if ($umur < 0 || $umur > 24) continue;

            $w = DB::table('wuspus')
                ->where('id_wuspus', $b->id_wuspus)
                ->first();

            $payload = [
                'umur_bulan'   => (int)$umur,
                'berat_badan'  => (float)$b->bb,
                'tinggi_badan' => (float)$b->tb_terkini,
                'jenis_kelamin'=> $b->jk === 'P' ? 'P' : 'L',
                'tinggi_ibu'   => (float)($w->tinggi_ibu ?? 150),
                'tinggi_ayah'  => (float)($w->tinggi_ayah ?? 165),
            ];

            $hasil = StuntingAiService::analisis($payload);
            if (!$hasil) continue;

            DB::transaction(function () use ($b, $payload, $hasil) {

                $idAnalisis = DB::table('ai_analisis_stunting')
                    ->updateOrInsert(
                        ['id_bayi' => $b->id_bayi],
                        [
                            'umur_bulan'      => $payload['umur_bulan'],
                            'berat_badan'     => $payload['berat_badan'],
                            'tinggi_badan'    => $payload['tinggi_badan'],
                            'jenis_kelamin'   => $payload['jenis_kelamin'],
                            'tinggi_ibu'      => $payload['tinggi_ibu'],
                            'tinggi_ayah'     => $payload['tinggi_ayah'],
                            'status_gizi'     => $hasil['status_gizi'],
                            'tingkat_risiko'  => $hasil['tingkat_risiko'],
                            'confidence'      => $hasil['confidence'],
                            'id_klaster'      => $hasil['id_klaster'],
                            'ringkasan'       => $hasil['ringkasan'],
                            'faktor_utama'    => json_encode($hasil['faktor_utama']),
                            'faktor_pendukung'=> json_encode($hasil['faktor_pendukung']),
                            'tanggal_analisis'=> now(),
                        ]
                    );

                $id = DB::table('ai_analisis_stunting')
                    ->where('id_bayi', $b->id_bayi)
                    ->value('id_analisis');

                DB::table('ai_rekomendasi_makanan')
                    ->where('id_analisis', $id)
                    ->delete();

                foreach ($hasil['rekomendasi_prioritas'] as $m) {
                    DB::table('ai_rekomendasi_makanan')->insert([
                        'id_analisis' => $id,
                        'jenis_makanan' => 'prioritas',
                        'nama_makanan' => $m,
                        'porsi_harian' => 'sesuai umur',
                        'kandungan_gizi' => '-',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });

            $berhasil++;
        }

        return response()->json([
            'success' => true,
            'diproses' => $berhasil
        ]);
    }
}
