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
        Schema::create('kedatangan-ekspedisi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ekspedisi');
            $table->unsignedBigInteger('id_pegawai');
            $table->unsignedBigInteger('id_user');
            $table->string('foto');
            $table->dateTime('tanggal_waktu');
            $table->timestamps();

            // Menambahkan foreign key constraints
            $table->foreign('id_ekspedisi')->references('id')->on('ekspedisi')->onDelete('cascade');
            $table->foreign('id_pegawai')->references('id')->on('pegawai')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Menghapus foreign key constraints
            $table->dropForeign(['id_ekspedisi']);
            $table->dropForeign(['id_pegawai']);
            $table->dropForeign(['id_user']);
        });

    }
};
