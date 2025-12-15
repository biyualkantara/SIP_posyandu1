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
            $table->id('id_format2'); // Primary Key

            $table->string('kecamatan', 150)->nullable();
            $table->string('kelurahan', 150)->nullable();
            $table->string('posyandu', 150)->nullable();
            $table->integer('tahun_pendataan')->nullable();
            
            // Foreign Key
            $table->unsignedBigInteger('id_bayi')->nullable();
            
            $table->string('nama_bayi', 150)->nullable();
            $table->enum('jk', ['L', 'P'])->nullable();
            $table->date('tgl_lhr')->nullable();
            $table->float('bbl')->nullable(); // Berat Badan Lahir (BBL)
            $table->text('ket')->nullable();

            // Definisi Foreign Key Constraint
            $table->foreign('id_bayi')->references('id_bayi')->on('bayi')->onDelete('set null');
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