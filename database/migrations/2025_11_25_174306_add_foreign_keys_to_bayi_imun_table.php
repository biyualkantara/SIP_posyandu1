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
        Schema::table('bayi_imun', function (Blueprint $table) {
            $table->foreign(['id_bayi'], 'bayi_imun_ibfk_1')->references(['id_bayi'])->on('bayi')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['id_imun'], 'bayi_imun_ibfk_2')->references(['id_imun'])->on('imunisasi')->onUpdate('no action')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bayi_imun', function (Blueprint $table) {
            $table->dropForeign('bayi_imun_ibfk_1');
            $table->dropForeign('bayi_imun_ibfk_2');
        });
    }
};
