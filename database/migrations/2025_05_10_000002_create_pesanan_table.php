<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan')->unique();
            $table->string('nama_pemesan');
            $table->integer('nomor_meja');
            $table->enum('metode_bayar', ['cash', 'qris']);
            $table->string('bukti_bayar_path')->nullable();
            $table->enum('status', [
                'menunggu_verifikasi',
                'belum_bayar',
                'diproses',
                'selesai',
            ])->default('belum_bayar');
            $table->integer('total_harga')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
