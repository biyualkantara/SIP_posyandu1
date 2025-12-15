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
        Schema::create('bumil_pnb', function (Blueprint $table) {
            $table->integer('id_bumil_pnb', true);
            $table->integer('id_wuspus')->index('id_wuspus');
            $table->string('bln_hamil', 50)->nullable();
            $table->date('tgl_pnb')->nullable();
            $table->decimal('berat', 5)->nullable();
            $table->string('hasil', 100)->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bumil_pnb');
    }
};
