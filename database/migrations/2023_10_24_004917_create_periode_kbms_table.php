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
        Schema::create('periode_kbms', function (Blueprint $table) {
            $table->id();
            $table->string('periodekbm_periode', 45)->nullable();
            $table->date('periodekbm_tanggalawal')->nullable();
            $table->date('periodekbm_tanggalakhir')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_kbms');
    }
};
