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
        Schema::table('bayi', function (Blueprint $table) {
            $table->foreign(['id_wuspus'], 'bayi_ibfk_1')->references(['id_wuspus'])->on('wuspus')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bayi', function (Blueprint $table) {
            $table->dropForeign('bayi_ibfk_1');
        });
    }
};
