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
        Schema::table('ai_food_recommendation', function (Blueprint $table) {
            $table->foreign(['id_prediksi'], 'ai_food_recommendation_ibfk_1')->references(['id_prediksi'])->on('ai_stunting_prediction')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_food_recommendation', function (Blueprint $table) {
            $table->dropForeign('ai_food_recommendation_ibfk_1');
        });
    }
};
