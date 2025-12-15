<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<SQL
CREATE TRIGGER `trg_after_prediksi_insert`
AFTER INSERT ON `ai_stunting_prediction`
FOR EACH ROW
BEGIN
    IF NEW.tingkat_risiko >= 75 THEN
        INSERT INTO ai_food_recommendation (
            id_prediksi,
            nama_makanan,
            jenis_makanan,
            kandungan_gizi,
            porsi_harian,
            catatan
        )
        VALUES 
            (NEW.id_prediksi, 'Telur Rebus', 'Protein', 'Protein tinggi, Vitamin D', '1-2 butir/hari', 'Sumber protein murah dan cepat'),
            (NEW.id_prediksi, 'Ikan Salmon/Tempe', 'Protein', 'Protein hewani/nabati', '1 porsi/hari', 'Ikan bila tersedia, tempe alternatif'),
            (NEW.id_prediksi, 'Sayur Bayam/Kangkung', 'Sayur', 'Zat besi, vitamin A', '1 mangkuk/hari', 'Tingkatkan serat dan mikronutrien');
    ELSEIF NEW.tingkat_risiko >= 50 THEN
        INSERT INTO ai_food_recommendation (
            id_prediksi,
            nama_makanan,
            jenis_makanan,
            kandungan_gizi,
            porsi_harian,
            catatan
        )
        VALUES 
            (NEW.id_prediksi, 'Telur Rebus', 'Protein', 'Protein tinggi', '1 butir/hari', 'Pemantauan lanjutan'),
            (NEW.id_prediksi, 'Sayur Hijau', 'Sayur', 'Zat besi', '1 porsi/hari', 'Masukkan sayuran lunak');
    ELSE
        INSERT INTO ai_food_recommendation (
            id_prediksi,
            nama_makanan,
            jenis_makanan,
            kandungan_gizi,
            porsi_harian,
            catatan
        )
        VALUES (
            NEW.id_prediksi,
            'ASI Eksklusif / Susu Formula',
            'Sesuai kebutuhan umur',
            'Teruskan pola makan sehat',
            'Sesuai usia bayi/anak',
            'Pertahankan pola makan seimbang'
        );
    END IF;
END
SQL);

        DB::unprepared(<<<SQL
CREATE TRIGGER `trg_ai_prediksi_autofill_height`
BEFORE INSERT ON `ai_stunting_prediction`
FOR EACH ROW
BEGIN
    DECLARE ibu_height DECIMAL(5,2);
    DECLARE ayah_height DECIMAL(5,2);

    SELECT 
        w.tinggi_ibu,
        w.tinggi_ayah
    INTO 
        ibu_height,
        ayah_height
    FROM bayi b
    LEFT JOIN wuspus w ON b.id_wuspus = w.id_wuspus
    WHERE b.id_bayi = NEW.id_bayi
    LIMIT 1;

    SET NEW.tinggi_ibu = ibu_height;
    SET NEW.tinggi_ayah = ayah_height;
END
SQL);

        DB::unprepared(<<<SQL
CREATE TRIGGER `trg_after_bayi_wafat_insert`
AFTER INSERT ON `bayi_wafat`
FOR EACH ROW
BEGIN
    UPDATE bayi
    SET ket = CONCAT(
        IFNULL(ket, ''),
        ' [Wafat pada: ',
        DATE_FORMAT(NEW.tgl_kematian, '%Y-%m-%d'),
        ']'
    )
    WHERE id_bayi = NEW.id_bayi;
END
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `trg_after_prediksi_insert`;');
        DB::unprepared('DROP TRIGGER IF EXISTS `trg_ai_prediksi_autofill_height`;');
        DB::unprepared('DROP TRIGGER IF EXISTS `trg_after_bayi_wafat_insert`;');
    }
};