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
        Schema::table('ai_chat_history', function (Blueprint $table) {
            $table->foreign(['id_operator'], 'ai_chat_history_ibfk_1')->references(['id_operator'])->on('operator')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['id_wuspus'], 'ai_chat_history_ibfk_2')->references(['id_wuspus'])->on('wuspus')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_chat_history', function (Blueprint $table) {
            $table->dropForeign('ai_chat_history_ibfk_1');
            $table->dropForeign('ai_chat_history_ibfk_2');
        });
    }
};
