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
        Schema::create('format_5', function (Blueprint $table) {
            $table->integer('id_format5', true);
            $table->string('kecamatan', 150)->nullable();
            $table->string('kelurahan', 150)->nullable();
            $table->string('posyandu', 150)->nullable();
            $table->integer('tahun_pendataan')->nullable();
            $table->string('bln', 50)->nullable();
            $table->integer('bayi_l')->nullable();
            $table->integer('bayi_p')->nullable();
            $table->integer('balita_l')->nullable();
            $table->integer('balita_p')->nullable();
            $table->integer('wus')->nullable();
            $table->integer('pus')->nullable();
            $table->integer('ibu_hamil')->nullable();
            $table->integer('ibu_menyusui')->nullable();
            $table->integer('pkk')->nullable();
            $table->integer('plkb')->nullable();
            $table->integer('medis')->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_5');
    }
};
