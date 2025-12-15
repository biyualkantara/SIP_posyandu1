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
        Schema::create('format_4', function (Blueprint $table) {
            $table->integer('id_format4', true);
            $table->string('kecamatan', 150)->nullable();
            $table->string('kelurahan', 150)->nullable();
            $table->string('posyandu', 150)->nullable();
            $table->integer('tahun_pendataan')->nullable();
            $table->string('nama_ibu', 150)->nullable();
            $table->string('nama_bayi', 150)->nullable();
            $table->integer('umur')->nullable();
            $table->string('kelompok_dasawisma', 150)->nullable();
            $table->date('tanggal_daftar')->nullable();
            $table->integer('umur_kehamilan')->nullable();
            $table->float('lila')->nullable();
            $table->string('pmt_pemulihan', 100)->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_4');
    }
};
