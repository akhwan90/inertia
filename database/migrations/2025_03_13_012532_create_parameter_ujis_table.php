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
        Schema::create('parameter_ujis', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 200);
            $table->string('satuan', 100)->nullable();
            $table->string('kadar_maksimum_operator', 100)->nullable();
            $table->integer('kadar_maksimum_value')->nullable();
            $table->string('metode_uji', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_ujis');
    }
};
