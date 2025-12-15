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
        Schema::create('bayi_imun', function (Blueprint $table) {
            $table->integer('id_bayi_imun', true);
            $table->integer('id_bayi')->index('id_bayi');
            $table->integer('id_imun')->index('id_imun');
            $table->date('tgl_imun')->nullable();
            $table->text('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bayi_imun');
    }
};
