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
        Schema::create('ai_chat_history', function (Blueprint $table) {
            $table->integer('id_chat', true);
            $table->integer('id_operator')->nullable()->index('id_operator');
            $table->integer('id_wuspus')->nullable()->index('id_wuspus');
            $table->integer('id_pengguna')->nullable();
            $table->enum('role', ['user', 'admin', 'ai'])->nullable()->default('user');
            $table->text('pesan');
            $table->text('response')->nullable();
            $table->timestamp('waktu')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_chat_history');
    }
};
