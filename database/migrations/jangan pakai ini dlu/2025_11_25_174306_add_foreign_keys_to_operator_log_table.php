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
        Schema::table('operator_log', function (Blueprint $table) {
            $table->foreign(['id_operator'], 'operator_log_ibfk_1')->references(['id_operator'])->on('operator')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operator_log', function (Blueprint $table) {
            $table->dropForeign('operator_log_ibfk_1');
        });
    }
};
