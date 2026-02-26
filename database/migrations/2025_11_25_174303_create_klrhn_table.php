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
        Schema::create('klrhn', function (Blueprint $table) {
            $table->integer('id_kel', true);
            $table->integer('id_kec')->index('id_kec');
            $table->string('nama_kel', 150);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klrhn');
    }
};
