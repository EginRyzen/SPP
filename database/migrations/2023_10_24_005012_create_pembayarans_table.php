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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreign('id_petugas')->references('id')->on('users');
            $table->unsignedBigInteger('id_petugas');
            $table->foreign('id_siswa')->references('id')->on('siswas');
            $table->unsignedBigInteger('id_siswa');
            $table->foreign('id_spp')->references('id')->on('spps');
            $table->unsignedBigInteger('id_spp');
            $table->date('tgl_bayar')->nullable();
            $table->string('tahun_bayar', 10)->nullable();
            $table->string('bulan_bayar', 20)->nullable();
            $table->integer('jumlah_bayar')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
