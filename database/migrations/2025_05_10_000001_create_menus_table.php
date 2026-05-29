<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu');
            $table->enum('kategori', ['topping', 'minuman', 'cemilan']);
            $table->integer('harga'); // dalam rupiah
            $table->integer('stok')->default(100);
            $table->string('gambar_path')->nullable();
            $table->boolean('tersedia')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
