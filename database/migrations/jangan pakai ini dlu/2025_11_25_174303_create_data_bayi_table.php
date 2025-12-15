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
        Schema::create('data_bayi', function (Blueprint $table) {
            $table->integer('id_data', true);
            $table->string('nama_posyandu', 150)->nullable();
            $table->integer('id_bayi')->nullable()->index('id_bayi');
            $table->string('nama_bayi', 150)->nullable();
            $table->enum('jk', ['L', 'P'])->nullable();
            $table->date('tgl_lhr')->nullable();
            $table->decimal('bb', 5)->nullable();
            $table->decimal('tb', 5)->nullable();
            $table->string('nama_wuspus', 150)->nullable();
            $table->string('nama_suami', 150)->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bayi');
    }
};
