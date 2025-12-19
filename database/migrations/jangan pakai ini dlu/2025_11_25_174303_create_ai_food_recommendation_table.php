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
        Schema::create('ai_food_recommendation', function (Blueprint $table) {
            $table->integer('id_rekomendasi', true);
            $table->integer('id_prediksi')->index('id_prediksi');
            $table->string('nama_makanan', 200)->nullable();
            $table->string('jenis_makanan', 100)->nullable();
            $table->text('kandungan_gizi')->nullable();
            $table->string('porsi_harian', 100)->nullable();
            $table->text('catatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_food_recommendation');
    }
};
