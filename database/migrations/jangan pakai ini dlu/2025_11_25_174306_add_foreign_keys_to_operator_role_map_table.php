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
        Schema::table('operator_role_map', function (Blueprint $table) {
            $table->foreign(['id_operator'], 'operator_role_map_ibfk_1')->references(['id_operator'])->on('operator')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['lvl_id'], 'operator_role_map_ibfk_2')->references(['lvl_id'])->on('oplvl')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operator_role_map', function (Blueprint $table) {
            $table->dropForeign('operator_role_map_ibfk_1');
            $table->dropForeign('operator_role_map_ibfk_2');
        });
    }
};
