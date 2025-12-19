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
        Schema::create('wuspus', function (Blueprint $table) {
            $table->integer('id_wuspus', true);
            $table->integer('id_posyandu')->nullable()->index('idx_wuspus_posyandu');
            $table->string('nik_wuspus', 50)->nullable();
            $table->string('nama_wuspus', 150)->nullable();
            $table->integer('umur')->nullable();
            $table->decimal('tinggi_ibu', 5)->nullable();
            $table->string('nama_suami', 150)->nullable();
            $table->decimal('tinggi_ayah', 5)->nullable();
            $table->string('thpn_ks', 50)->nullable();
            $table->string('klmpk_dasawisma', 100)->nullable();
            $table->integer('jml_anak_hdp')->nullable()->default(0);
            $table->integer('jml_anak_meninggal')->nullable()->default(0);
            $table->date('tgl_daftar')->nullable();
            $table->string('status', 50)->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wuspus');
    }
};
