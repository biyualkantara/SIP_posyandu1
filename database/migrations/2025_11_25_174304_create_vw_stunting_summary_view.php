<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_stunting_summary");

        DB::statement("
            CREATE VIEW vw_stunting_summary AS
            SELECT 
                p.id_prediksi,
                b.id_bayi,
                b.nama_bayi,
                p.umur_bulan,
                p.berat_badan,
                p.tinggi_badan,
                p.tinggi_ibu,
                p.tinggi_ayah,
                p.z_score,
                p.status_gizi,
                p.tingkat_risiko,
                p.tanggal_prediksi
            FROM ai_stunting_prediction p
            LEFT JOIN bayi b ON p.id_bayi = b.id_bayi
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_stunting_summary");
    }
};