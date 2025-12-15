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
        Schema::create('bayi_pnb', function (Blueprint $table) {
            $table->integer('id_bayi_pnb', true);
            $table->integer('id_bayi')->index('id_bayi');
            $table->date('tgl_pnb')->nullable();
            $table->decimal('berat', 5)->nullable();
            $table->decimal('tb', 5)->nullable();
            $table->string('hasil', 100)->nullable();
            $table->string('pmt', 100)->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bayi_pnb');
    }
};
