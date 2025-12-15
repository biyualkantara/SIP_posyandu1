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
        Schema::create('duspy', function (Blueprint $table) {
            $table->integer('id_posyandu', true);
            $table->string('nama_posyandu', 150);
            $table->string('strata_psy', 50)->nullable();
            $table->text('alamat_posyandu')->nullable();
            $table->integer('id_kel')->nullable()->index('id_kel');
            $table->string('pj_umum', 100)->nullable();
            $table->string('pj_operasional', 100)->nullable();
            $table->string('ketuplak', 100)->nullable();
            $table->string('sekretaris', 100)->nullable();
            $table->integer('int_paud')->nullable()->default(0);
            $table->integer('int_bkd')->nullable()->default(0);
            $table->integer('int_terpadu')->nullable()->default(0);
            $table->integer('kader_aktif')->nullable()->default(0);
            $table->integer('kader_taktif')->nullable()->default(0);
            $table->string('ptgs_kb', 100)->nullable();
            $table->string('ptgs_medis', 100)->nullable();
            $table->string('ptgs_bidan', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duspy');
    }
};
