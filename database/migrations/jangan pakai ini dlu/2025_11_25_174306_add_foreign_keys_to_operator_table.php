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
        Schema::table('operator', function (Blueprint $table) {
            $table->foreign(['kcmtn'], 'operator_ibfk_1')->references(['id_kec'])->on('kcmtn')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['klrhn'], 'operator_ibfk_2')->references(['id_kel'])->on('klrhn')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['id_posyandu'], 'operator_ibfk_3')->references(['id_posyandu'])->on('duspy')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operator', function (Blueprint $table) {
            $table->dropForeign('operator_ibfk_1');
            $table->dropForeign('operator_ibfk_2');
            $table->dropForeign('operator_ibfk_3');
        });
    }
};
