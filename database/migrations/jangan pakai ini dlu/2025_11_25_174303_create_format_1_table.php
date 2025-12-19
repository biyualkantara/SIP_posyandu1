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
        Schema::create('format_1', function (Blueprint $table) {
            $table->integer('id_format1', true);
            $table->string('kecamatan', 150)->nullable();
            $table->string('kelurahan', 150)->nullable();
            $table->string('posyandu', 150)->nullable();
            $table->integer('tahun_pendataan')->nullable();
            $table->string('nama_ibu', 150)->nullable();
            $table->string('nama_ayah', 150)->nullable();
            $table->string('nama_bayi', 150)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->date('tanggal_bayi_meninggal')->nullable();
            $table->date('tanggal_ibu_meninggal')->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_1');
    }
};
