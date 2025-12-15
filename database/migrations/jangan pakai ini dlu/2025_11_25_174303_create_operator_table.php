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
        Schema::create('operator', function (Blueprint $table) {
            $table->integer('id_operator', true);
            $table->string('username', 100)->unique('username');
            $table->string('password');
            $table->string('nama', 150)->nullable();
            $table->text('alamat')->nullable();
            $table->integer('kcmtn')->nullable()->index('kcmtn');
            $table->integer('klrhn')->nullable()->index('klrhn');
            $table->integer('id_posyandu')->nullable()->index('idx_operator_posyandu');
            $table->string('email', 150)->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->timestamp('reg_times')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator');
    }
};
