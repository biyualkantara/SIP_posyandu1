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
        Schema::create('ai_stunting_prediction', function (Blueprint $table) {
            $table->integer('id_prediksi', true);
            $table->integer('id_bayi')->nullable()->index('id_bayi');
            $table->integer('umur_bulan')->nullable();
            $table->decimal('berat_badan', 6)->nullable();
            $table->decimal('tinggi_badan', 6)->nullable();
            $table->decimal('tinggi_ibu', 5)->nullable();
            $table->decimal('tinggi_ayah', 5)->nullable();
            $table->float('z_score')->nullable();
            $table->enum('status_gizi', ['Normal', 'Berisiko Stunting', 'Stunting'])->nullable()->default('Normal');
            $table->decimal('tingkat_risiko', 5)->nullable()->default(0);
            $table->date('tanggal_prediksi')->nullable()->default('curdate()');
            $table->text('rekomendasi')->nullable();
            $table->string('sumber_model', 100)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_stunting_prediction');
    }
};
