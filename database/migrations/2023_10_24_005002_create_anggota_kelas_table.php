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
        Schema::create('anggota_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreign('id_kelas')->references('id')->on('kelas');
            $table->unsignedBigInteger('id_kelas');
            $table->foreign('id_siswa')->references('id')->on('siswas');
            $table->unsignedBigInteger('id_siswa');
            $table->foreign('id_setting_spp')->references('id')->on('setting_spps');
            $table->unsignedBigInteger('id_setting_spp');
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
        Schema::dropIfExists('anggota_kelas');
    }
};
