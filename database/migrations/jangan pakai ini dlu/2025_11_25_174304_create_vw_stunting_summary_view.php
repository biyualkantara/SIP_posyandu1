<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE VIEW `vw_stunting_summary` AS select `p`.`id_prediksi` AS `id_prediksi`,`b`.`id_bayi` AS `id_bayi`,`b`.`nama_bayi` AS `nama_bayi`,`p`.`umur_bulan` AS `umur_bulan`,`p`.`berat_badan` AS `berat_badan`,`p`.`tinggi_badan` AS `tinggi_badan`,`p`.`tinggi_ibu` AS `tinggi_ibu`,`p`.`tinggi_ayah` AS `tinggi_ayah`,`p`.`z_score` AS `z_score`,`p`.`status_gizi` AS `status_gizi`,`p`.`tingkat_risiko` AS `tingkat_risiko`,`p`.`tanggal_prediksi` AS `tanggal_prediksi` from (`SIP_posyandu`.`ai_stunting_prediction` `p` left join `SIP_posyandu`.`bayi` `b` on((`p`.`id_bayi` = `b`.`id_bayi`)))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vw_stunting_summary`");
    }
};
