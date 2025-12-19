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
        Schema::create('wuspus_kontrasepsi', function (Blueprint $table) {
            $table->integer('id_wkp', true);
            $table->integer('id_wuspus')->index('id_wuspus');
            $table->string('jns_kontrasepsi', 100)->nullable();
            $table->date('tgl_ganti')->nullable();
            $table->string('kontrasepsi_baru', 100)->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wuspus_kontrasepsi');
    }
};
