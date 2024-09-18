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
        Schema::create('kedatangan_ekspedisi', function (Blueprint $table) {
            $table->string('id_kedatanganEkspedisi')->primary();
            $table->string('id_ekspedisi');
            $table->string('id_pegawai');
            $table->unsignedBigInteger('id_user');
            $table->string('foto');
            $table->dateTime('tanggal_waktu');
            $table->timestamps();

            // Menambahkan foreign key constraints
            $table->foreign('id_ekspedisi')->references('id_ekspedisi')->on('ekspedisi')->onDelete('cascade');
            $table->foreign('id_pegawai')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kedatangan_ekspedisi');
    }
};
