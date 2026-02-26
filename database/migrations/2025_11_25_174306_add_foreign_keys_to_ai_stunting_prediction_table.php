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
        Schema::table('ai_stunting_prediction', function (Blueprint $table) {
            $table->foreign(['id_bayi'], 'ai_stunting_prediction_ibfk_1')->references(['id_bayi'])->on('bayi')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_stunting_prediction', function (Blueprint $table) {
            $table->dropForeign('ai_stunting_prediction_ibfk_1');
        });
    }
};
