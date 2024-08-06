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
        Schema::create('kedatangan-tamu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pegawai');
            $table->unsignedBigInteger('id_tamu');
            $table->unsignedBigInteger('id_user');
            $table->string('qr_code');
            $table->string('tujuan');
            $table->string('instansi');
            $table->dateTime('waktu_perjanjian');
            $table->string('foto');
            $table->dateTime('waktu_kedatangan'); // Ditambahkan kolom waktu_kedatangan

            $table->timestamps();

            // Menambahkan foreign key constraints
            $table->foreign('id_pegawai')->references('id')->on('pegawai')->onDelete('cascade');
            $table->foreign('id_tamu')->references('id')->on('tamu')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Menghapus foreign key constraints
            $table->dropForeign(['id_pegawai']);
            $table->dropForeign(['id_tamu']);
            $table->dropForeign(['id_user']);
        });

    }
};
