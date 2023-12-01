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
        Schema::create('setting_spps', function (Blueprint $table) {
            $table->id();
            $table->foreign('id_spp')->references('id')->on('spps');
            $table->unsignedBigInteger('id_spp');
            $table->foreign('id_periode')->references('id')->on('periode_kbms');
            $table->unsignedBigInteger('id_periode');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_spps');
    }
};
