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
        Schema::create('kedatangan_tamu', function (Blueprint $table) {
            $table->string('id_kedatanganTamu')->primary();
            $table->string('id_pegawai');
            $table->string('id_tamu');
            $table->unsignedBigInteger('id_user');
            $table->string('qr_code');
            $table->string('tujuan');
            $table->string('instansi')->nullable();
            $table->dateTime('waktu_perjanjian');
            $table->string('foto');
            $table->dateTime('waktu_kedatangan');
            $table->enum('status', ['Menunggu konfirmasi', 'Diterima', 'Ditolak'])->default('Menunggu konfirmasi');
            $table->string('keterangan')->nullable();

            $table->timestamps();

            // Menambahkan foreign key constraints
            $table->foreign('id_pegawai')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->foreign('id_tamu')->references('id_tamu')->on('tamu')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kedatangan_tamu');
    }
};
