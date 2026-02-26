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
        Schema::table('wuspus_imun', function (Blueprint $table) {
            $table->foreign(['id_wuspus'], 'wuspus_imun_ibfk_1')->references(['id_wuspus'])->on('wuspus')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['id_imun'], 'wuspus_imun_ibfk_2')->references(['id_imun'])->on('imunisasi')->onUpdate('no action')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wuspus_imun', function (Blueprint $table) {
            $table->dropForeign('wuspus_imun_ibfk_1');
            $table->dropForeign('wuspus_imun_ibfk_2');
        });
    }
};
