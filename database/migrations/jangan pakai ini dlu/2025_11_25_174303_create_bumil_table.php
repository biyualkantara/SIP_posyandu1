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
        Schema::create('bumil', function (Blueprint $table) {
            $table->integer('id_bumil', true);
            $table->integer('id_wuspus')->unique('id_wuspus');
            $table->date('tgl_daftar')->nullable();
            $table->integer('umur_kehamilan')->nullable();
            $table->integer('hamil_ke')->nullable();
            $table->string('pmt_pemulihan', 100)->nullable();
            $table->float('lila')->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bumil');
    }
};
