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
        Schema::create('format_2', function (Blueprint $table) {
            $table->integer('id_format2', true);
            $table->string('kecamatan', 150)->nullable();
            $table->string('kelurahan', 150)->nullable();
            $table->string('posyandu', 150)->nullable();
            $table->integer('tahun_pendataan')->nullable();
            $table->integer('id_bayi')->nullable()->index('id_bayi');
            $table->string('nama_bayi', 150)->nullable();
            $table->enum('jk', ['L', 'P'])->nullable();
            $table->date('tgl_lhr')->nullable();
            $table->float('bbl')->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_2');
    }
};
