<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('porsi_pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->cascadeOnDelete();
            $table->string('nama_porsi'); // e.g., 'Mangkuk 1'
            $table->enum('level_pedas', ['0', '1', '2', '3', '4', '5'])->default('0');
            $table->enum('jenis_rasa', ['gurih', 'gurih_manis'])->default('gurih');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('porsi_pesanans');
    }
};
