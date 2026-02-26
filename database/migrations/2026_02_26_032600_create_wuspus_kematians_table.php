<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wuspus_kematians', function (Blueprint $table) {
            $table->integer('id', true); // primary key
            $table->integer('id_wuspus')->nullable(); // SAMA dengan tabel wuspus
            $table->date('tgl_wafat');
            $table->string('penyebab')->nullable();
            $table->text('ket')->nullable();
            $table->timestamps();

            $table->foreign('id_wuspus')
                  ->references('id_wuspus')
                  ->on('wuspus')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wuspus_kematians');
    }
};