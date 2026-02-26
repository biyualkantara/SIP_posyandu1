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
        Schema::table('bayi_pnb', function (Blueprint $table) {
            $table->foreign(['id_bayi'], 'bayi_pnb_ibfk_1')->references(['id_bayi'])->on('bayi')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bayi_pnb', function (Blueprint $table) {
            $table->dropForeign('bayi_pnb_ibfk_1');
        });
    }
};
