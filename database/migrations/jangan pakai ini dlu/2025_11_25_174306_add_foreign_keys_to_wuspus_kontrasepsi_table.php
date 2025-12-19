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
        Schema::table('wuspus_kontrasepsi', function (Blueprint $table) {
            $table->foreign(['id_wuspus'], 'wuspus_kontrasepsi_ibfk_1')->references(['id_wuspus'])->on('wuspus')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wuspus_kontrasepsi', function (Blueprint $table) {
            $table->dropForeign('wuspus_kontrasepsi_ibfk_1');
        });
    }
};
