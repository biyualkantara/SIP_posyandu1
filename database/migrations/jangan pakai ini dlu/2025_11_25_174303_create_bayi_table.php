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
        Schema::create('bayi', function (Blueprint $table) {
            $table->integer('id_bayi', true);
            $table->integer('id_wuspus')->nullable()->index('idx_bayi_wuspus');
            $table->string('nama_bayi', 150)->nullable();
            $table->enum('jk', ['L', 'P'])->nullable();
            $table->date('tgl_lhr')->nullable();
            $table->decimal('bb', 5)->nullable();
            $table->decimal('tb', 5)->nullable();
            $table->decimal('tb_terkini', 5)->nullable();
            $table->date('tgl_daftar')->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bayi');
    }
};
