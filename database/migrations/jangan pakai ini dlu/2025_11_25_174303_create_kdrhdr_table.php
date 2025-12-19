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
        Schema::create('kdrhdr', function (Blueprint $table) {
            $table->integer('id_kdrhdr', true);
            $table->integer('id_posyandu')->nullable()->index('id_posyandu');
            $table->string('bulan', 50)->nullable();
            $table->string('pkk', 150)->nullable();
            $table->string('plkb', 150)->nullable();
            $table->string('medis', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kdrhdr');
    }
};
