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
        Schema::create('berita', function (Blueprint $table) {
            $table->integer('id_berita', true);
            $table->string('judul')->nullable();
            $table->text('ringkasan')->nullable();
            $table->longText('isi')->nullable();
            $table->string('penulis', 150)->nullable();
            $table->dateTime('tanggal_waktu')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
