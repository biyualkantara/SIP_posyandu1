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
        Schema::create('operator_log', function (Blueprint $table) {
            $table->integer('id_log', true);
            $table->integer('id_operator')->nullable()->index('id_operator');
            $table->string('aksi', 200)->nullable();
            $table->timestamp('waktu')->nullable()->useCurrent();
            $table->text('detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator_log');
    }
};
