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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreign('id_user')->references('id')->on('users');
            $table->unsignedBigInteger('id_user');
            $table->char('nisn', 10)->nullable();
            $table->char('nis', 8)->nullable();
            $table->string('nama', 50)->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_telp', 16)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
