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

            // validasi minimal data bayi
            if (!$b->tgl_lhr || !$b->bb || !$b->tb_terkini) {
                continue;
            }

            $umur = (int) floor((time() - strtotime($b->tgl_lhr)) / (30 * 24 * 3600));
            if ($umur < 0 || $umur > 24) {
                continue;
            }

            $w = DB::table('wuspus')
                ->where('id_wuspus', $b->id_wuspus)
                ->first();

            $payload = [
                'umur_bulan'    => (int) $umur,
                'berat_badan'   => (float) $b->bb,
                'tinggi_badan'  => (float) $b->tb_terkini,
                'jenis_kelamin' => $b->jk === 'P' ? 'P' : 'L',
                'tinggi_ibu'    => (float) ($w->tinggi_ibu ?? 150),
                'tinggi_ayah'   => (float) ($w->tinggi_ayah ?? 165),
            ];

            $hasil = StuntingAiService::analisis($payload);
            if (!$hasil) continue;

            // normalisasi output AI agar aman
            $statusGizi = (string) ($hasil['status_gizi'] ?? 'Normal');
            $risk       = (float)  ($hasil['tingkat_risiko'] ?? 0);
            $confidence = (float)  ($hasil['confidence'] ?? 0);
            $idKlaster  = (int)    ($hasil['id_klaster'] ?? 0);
            $ringkasan  = (string) ($hasil['ringkasan'] ?? '');
            $zScore     = $hasil['z_score'] ?? null;

            $faktorUtama     = $hasil['faktor_utama'] ?? [];
            $faktorPendukung = $hasil['faktor_pendukung'] ?? [];

            // rekomendasi dari AI kalau ada (tetap disimpan di kolom JSON ai_analisis_stunting)
            $rekomAI = $hasil['rekomendasi_prioritas'] ?? [];
            if (!is_array($rekomAI)) $rekomAI = [];

            $rekomFinal = $this->buildRekomendasiIndonesia(
                umurBulan: $umur,
                statusGizi: $statusGizi,
                tingkatRisiko: $risk
            );

            DB::transaction(function () use (
                $b,
                $payload,
                $statusGizi,
                $risk,
                $confidence,
                $idKlaster,
                $ringkasan,
                $zScore,
                $faktorUtama,
                $faktorPendukung,
                $rekomAI,
                $rekomFinal
            ) {

                DB::table('ai_analisis_stunting')
                    ->updateOrInsert(
                        ['id_bayi' => $b->id_bayi],
                        [
                            'umur_bulan'      => $payload['umur_bulan'],
                            'berat_badan'     => $payload['berat_badan'],
                            'tinggi_badan'    => $payload['tinggi_badan'],
                            'jenis_kelamin'   => $payload['jenis_kelamin'],

                            'status_gizi'     => $statusGizi,
                            'tingkat_risiko'  => $risk,
                            'confidence'      => $confidence,
                            'id_klaster'      => $idKlaster,
                            'ringkasan'       => $ringkasan,
                            'z_score'         => $zScore,

                            'faktor_utama'     => json_encode($faktorUtama),
                            'faktor_pendukung' => json_encode($faktorPendukung),

                            // tetap simpan rekom AI 
                            'rekomendasi_prioritas' => json_encode($rekomAI),

                            'tanggal_analisis' => now(),
                            'updated_at'       => now(),
                        ]
                    );

                $idAnalisis = DB::table('ai_analisis_stunting')
                    ->where('id_bayi', $b->id_bayi)
                    ->value('id_analisis');

                // reset rekomendasi makanan utk analisis ini
                DB::table('ai_rekomendasi_makanan')
                    ->where('id_analisis', $idAnalisis)
                    ->delete();

                // insert rekomendasi final (rule-based, sesuai usia)
                foreach ($rekomFinal as $item) {
                    DB::table('ai_rekomendasi_makanan')->insert([
                        'id_analisis'    => $idAnalisis,
                        'jenis_makanan'  => $item['jenis_makanan'],   
                        'nama_makanan'   => $item['nama_makanan'],   
                        'porsi_harian'   => $item['porsi_harian'],    
                        'kandungan_gizi' => $item['kandungan_gizi'], 
                        'catatan'        => $item['catatan'],       
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
            });

            $berhasil++;
        }

        return response()->json([
            'success'  => true,
            'diproses' => $berhasil,
        ]);
    }

    /**
     * Rule-based rekomendasi Indonesia sesuai umur 0–24 bulan + hasil AI.
     * - Umur < 6 bulan: TIDAK boleh MPASI/PMT (hanya ASI eksklusif + intervensi aman)
     * - Umur 6–24 bulan: MPASI/makanan keluarga + intervensi
     */
    private function buildRekomendasiIndonesia(int $umurBulan, string $statusGizi, float $tingkatRisiko): array
    {
        // clamp umur supaya aman
        if ($umurBulan < 0) $umurBulan = 0;
        if ($umurBulan > 24) $umurBulan = 24;

        // kategorikan risiko (biar rule gampang)
        $riskPct = $tingkatRisiko;
        $isHighRisk = $riskPct >= 70 || stripos($statusGizi, 'berisiko') !== false || stripos($statusGizi, 'stunting') !== false;
        $isMidRisk  = $riskPct >= 30 && $riskPct < 70;

        $items = [];

        // 0–5 bulan (ASI eksklusif)
        if ($umurBulan <= 5) {
            $items[] = [
                'jenis_makanan'  => 'gizi',
                'nama_makanan'   => 'ASI Eksklusif',
                'porsi_harian'   => '8–12x/hari (±60–120 ml per sesi); menyusu on-demand, termasuk malam',
                'kandungan_gizi' => 'Energi, protein, lemak esensial, antibodi',
                'catatan'        => 'Bayi usia <6 bulan belum dianjurkan MPASI/PMT. Fokus peningkatan frekuensi & kualitas ASI.',
            ];

            $items[] = [
                'jenis_makanan'  => 'gaya_hidup',
                'nama_makanan'   => 'Berjemur pagi',
                'porsi_harian'   => '5–10 menit, pukul 06.30–08.00 (wajah & tangan terpapar, hindari matahari terik)',
                'kandungan_gizi' => 'Mendukung vitamin D (tulang & imunitas)',
                'catatan'        => 'Durasi dibuat aman untuk bayi kecil. Hentikan jika bayi rewel/kemerahan.',
            ];

            $items[] = [
                'jenis_makanan'  => 'intervensi',
                'nama_makanan'   => 'Pemantauan berat & panjang badan',
                'porsi_harian'   => '1x/bulan di posyandu (lebih sering jika risiko tinggi)',
                'kandungan_gizi' => 'Deteksi dini masalah pertumbuhan',
                'catatan'        => $isHighRisk
                    ? 'Risiko tinggi: disarankan pemantauan lebih sering dan konseling laktasi.'
                    : 'Pantau rutin untuk memastikan pertumbuhan sesuai usia.',
            ];

            if ($isHighRisk) {
                $items[] = [
                    'jenis_makanan'  => 'rujukan',
                    'nama_makanan'   => 'Konseling laktasi / tenaga kesehatan',
                    'porsi_harian'   => 'Segera (1–3 hari) untuk evaluasi menyusu & kemungkinan masalah medis',
                    'kandungan_gizi' => 'Optimasi asupan ASI & evaluasi faktor risiko',
                    'catatan'        => 'Untuk bayi <6 bulan, intervensi utama adalah perbaikan praktik menyusui, bukan penambahan makanan.',
                ];
            }

            return $items;
        }

        // 6–8 bulan (MPASI lembut)
        if ($umurBulan >= 6 && $umurBulan <= 8) {
            $items[] = [
                'jenis_makanan'  => 'gizi',
                'nama_makanan'   => 'MPASI tekstur lembut (bubur saring / tim halus)',
                'porsi_harian'   => '2–3x makan utama/hari + ASI tetap; mulai 2–3 sdm, naik bertahap sampai ±1/2 mangkuk (±125 ml) per makan',
                'kandungan_gizi' => 'Energi & zat gizi makro/mikro',
                'catatan'        => 'Utamakan menu padat gizi. Tekstur harus lembut sesuai kemampuan menelan bayi.',
            ];

            $items[] = [
                'jenis_makanan'  => 'gizi',
                'nama_makanan'   => 'Bubur tim beras + ayam + hati ayam + sayur (wortel/bayam) + 1 sdt minyak',
                'porsi_harian'   => '1x/hari dari 2–3x makan; porsi mengikuti target 2–3 sdm → 1/2 mangkuk',
                'kandungan_gizi' => 'Protein hewani, zat besi, vitamin A, energi',
                'catatan'        => $isHighRisk ? 'Prioritaskan protein hewani & lemak tambahan untuk mengejar pertumbuhan.' : 'Menu seimbang, variasi bahan tiap hari.',
            ];

            $items[] = [
                'jenis_makanan'  => 'gizi',
                'nama_makanan'   => 'Bubur kacang hijau HALUS (tanpa santan, tanpa gula) + ASI',
                'porsi_harian'   => 'Opsional 2–3x/minggu (bukan harian), 2–3 sdm → bertahap sesuai toleransi',
                'kandungan_gizi' => 'Energi, protein nabati',
                'catatan'        => 'Hanya untuk usia ≥6 bulan. Hentikan jika kembung/diare.',
            ];

            $items[] = [
                'jenis_makanan'  => 'gaya_hidup',
                'nama_makanan'   => 'Berjemur pagi',
                'porsi_harian'   => '10 menit, pukul 06.30–08.00',
                'kandungan_gizi' => 'Vitamin D',
                'catatan'        => 'Tetap aman: hindari jam terik.',
            ];

            if ($isHighRisk) {
                $items[] = [
                    'jenis_makanan'  => 'intervensi',
                    'nama_makanan'   => 'Tambahkan sumber protein hewani setiap makan',
                    'porsi_harian'   => 'Setiap makan utama: ayam/ikan/telur (±2–3 sdm campuran protein pada bubur)',
                    'kandungan_gizi' => 'Protein kualitas tinggi & zat besi',
                    'catatan'        => 'Protein hewani berperan besar untuk perbaikan pertumbuhan pada risiko stunting.',
                ];
            }

            return $items;
        }

        // 9–11 bulan (MPASI kasar)
        if ($umurBulan >= 9 && $umurBulan <= 11) {
            $items[] = [
                'jenis_makanan'  => 'gizi',
                'nama_makanan'   => 'MPASI tekstur lebih kasar (nasi tim / makanan cincang lembut)',
                'porsi_harian'   => '3–4x makan utama/hari + 1–2x selingan; porsi ±1/2–3/4 mangkuk (±125–180 ml) per makan',
                'kandungan_gizi' => 'Energi, protein, mineral',
                'catatan'        => 'Tingkatkan tekstur bertahap untuk melatih mengunyah.',
            ];

            $items[] = [
                'jenis_makanan'  => 'gizi',
                'nama_makanan'   => 'Nasi tim + ikan kembung/tongkol + tahu/tempe + sayur (labu/bayam) + 1 sdt minyak',
                'porsi_harian'   => '1x/hari dari makan utama; porsi mengikuti target ±1/2–3/4 mangkuk',
                'kandungan_gizi' => 'Protein hewani, omega-3, energi',
                'catatan'        => $isHighRisk ? 'Utamakan ikan & telur lebih sering untuk kejar tumbuh.' : 'Variasi protein harian dianjurkan.',
            ];

            $items[] = [
                'jenis_makanan'  => 'gizi',
                'nama_makanan'   => 'Telur (orak-arik halus / telur dadar lembut)',
                'porsi_harian'   => '3–4x/minggu, ±1/2 butir → 1 butir (sesuaikan toleransi)',
                'kandungan_gizi' => 'Protein, kolin',
                'catatan'        => 'Pastikan matang sempurna.',
            ];

            $items[] = [
                'jenis_makanan'  => 'gaya_hidup',
                'nama_makanan'   => 'Aktif bermain (tummy time / merangkak)',
                'porsi_harian'   => '2–3 sesi/hari @ 10–15 menit',
                'kandungan_gizi' => 'Stimulasi motorik, nafsu makan lebih baik',
                'catatan'        => 'Aktivitas sesuai kemampuan bayi.',
            ];

            if ($isHighRisk) {
                $items[] = [
                    'jenis_makanan'  => 'intervensi',
                    'nama_makanan'   => 'Pemantauan pertumbuhan lebih sering',
                    'porsi_harian'   => '2x/bulan sampai risiko menurun',
                    'kandungan_gizi' => 'Deteksi & koreksi dini',
                    'catatan'        => 'Risiko tinggi memerlukan kontrol lebih rapat.',
                ];
            }

            return $items;
        }
        // 12–24 bulan (makanan keluarga)
        // $umurBulan 12..24
        $items[] = [
            'jenis_makanan'  => 'gizi',
            'nama_makanan'   => 'Makanan keluarga (tekstur normal)',
            'porsi_harian'   => '3–4x makan utama/hari + 1–2x selingan; porsi ±3/4–1 mangkuk (±180–250 ml) per makan',
            'kandungan_gizi' => 'Energi & zat gizi lengkap',
            'catatan'        => 'Tetap padat gizi, batasi makanan ultra-proses & minuman manis.',
        ];

        $items[] = [
            'jenis_makanan'  => 'gizi',
            'nama_makanan'   => 'Nasi + lauk protein hewani (ayam/ikan/telur) + sayur + buah',
            'porsi_harian'   => 'Setiap makan utama: protein hewani minimal 1 porsi (±1 potong kecil/±2–3 sdm)',
            'kandungan_gizi' => 'Protein tinggi, zat besi, vitamin',
            'catatan'        => $isHighRisk ? 'Utamakan protein hewani setiap makan untuk mengejar pertumbuhan.' : 'Menu seimbang dan bervariasi.',
        ];

        $items[] = [
            'jenis_makanan'  => 'gizi',
            'nama_makanan'   => 'Selingan padat gizi (pilih salah satu)',
            'porsi_harian'   => '1–2x/hari: pisang/pepaya, roti + telur, bubur kacang hijau, puding susu tanpa gula berlebih',
            'kandungan_gizi' => 'Energi tambahan, vitamin, mineral',
            'catatan'        => 'Selingan bukan pengganti makan utama.',
        ];

        $items[] = [
            'jenis_makanan'  => 'gaya_hidup',
            'nama_makanan'   => 'Tidur cukup & rutinitas',
            'porsi_harian'   => 'Total 11–14 jam/hari (termasuk tidur siang)',
            'kandungan_gizi' => 'Mendukung hormon pertumbuhan',
            'catatan'        => 'Kurang tidur dapat mengganggu nafsu makan & tumbuh kembang.',
        ];

        if ($isHighRisk) {
            $items[] = [
                'jenis_makanan'  => 'intervensi',
                'nama_makanan'   => 'Porsi “padat energi” (tambahkan lemak sehat)',
                'porsi_harian'   => 'Tambahkan 1 sdt minyak/mentega/kaldu kental ke tiap porsi makan utama',
                'kandungan_gizi' => 'Energi lebih tinggi untuk catch-up growth',
                'catatan'        => 'Cara aman menaikkan energi tanpa menambah volume berlebihan.',
            ];

            $items[] = [
                'jenis_makanan'  => 'rujukan',
                'nama_makanan'   => 'Konsultasi tenaga kesehatan bila sulit naik BB/TB',
                'porsi_harian'   => 'Dalam 1–2 minggu bila tidak ada perbaikan',
                'kandungan_gizi' => 'Evaluasi penyebab & intervensi lanjutan',
                'catatan'        => 'Risiko tinggi perlu evaluasi: pola makan, infeksi berulang, anemia, dll.',
            ];
        } elseif ($isMidRisk) {
            $items[] = [
                'jenis_makanan'  => 'intervensi',
                'nama_makanan'   => 'Fokus menu tinggi protein 1–2 minggu',
                'porsi_harian'   => 'Protein hewani setiap makan + selingan tinggi gizi 1x/hari',
                'kandungan_gizi' => 'Perbaikan status gizi',
                'catatan'        => 'Risiko sedang: intervensi gizi intensif biasanya efektif.',
            ];
        }

        return $items;
    }
}