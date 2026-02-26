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
        Schema::table('duspy', function (Blueprint $table) {
            $table->foreign(['id_kel'], 'duspy_ibfk_1')->references(['id_kel'])->on('klrhn')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('duspy', function (Blueprint $table) {
            $table->dropForeign('duspy_ibfk_1');
        });
    }
};
