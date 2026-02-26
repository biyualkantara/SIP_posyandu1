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
        Schema::table('data_bayi', function (Blueprint $table) {
            $table->foreign(['id_bayi'], 'data_bayi_ibfk_1')->references(['id_bayi'])->on('bayi')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_bayi', function (Blueprint $table) {
            $table->dropForeign('data_bayi_ibfk_1');
        });
    }
};
