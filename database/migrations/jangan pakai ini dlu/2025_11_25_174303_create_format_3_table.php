<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('format_3', function (Blueprint $table) {
            $table->integer('id_format3', true);
            $table->string('kecamatan', 150)->nullable();
            $table->string('kelurahan', 150)->nullable();
            $table->string('posyandu', 150)->nullable();
            $table->integer('tahun_pendataan')->nullable();
            $table->string('nama_wuspus', 150)->nullable();
            $table->integer('umur')->nullable();
            $table->string('nama_suami', 150)->nullable();
            $table->string('tahapan_ks', 150)->nullable();
            $table->string('kelompok_dasawisma', 150)->nullable();
            $table->integer('jumlah_anak_hidup')->nullable();
            $table->integer('jumlah_anak_meninggal')->nullable();
            $table->float('pengukuran_lila')->nullable();
            $table->string('kapsul_yodium', 100)->nullable();
            $table->string('imunisasi_tti', 100)->nullable();
            $table->string('jenis_kontrasepsi', 150)->nullable();
            $table->date('tgl_pergantian')->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_3');
    }
};
