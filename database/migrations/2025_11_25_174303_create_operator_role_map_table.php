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
        Schema::create('operator_role_map', function (Blueprint $table) {
            $table->integer('id_map', true);
            $table->integer('id_operator')->nullable()->index('id_operator');
            $table->integer('lvl_id')->nullable()->index('lvl_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator_role_map');
    }
};
