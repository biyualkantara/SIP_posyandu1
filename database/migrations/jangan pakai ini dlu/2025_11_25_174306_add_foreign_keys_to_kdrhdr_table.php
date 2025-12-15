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
        Schema::table('kdrhdr', function (Blueprint $table) {
            $table->foreign(['id_posyandu'], 'kdrhdr_ibfk_1')->references(['id_posyandu'])->on('duspy')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kdrhdr', function (Blueprint $table) {
            $table->dropForeign('kdrhdr_ibfk_1');
        });
    }
};
