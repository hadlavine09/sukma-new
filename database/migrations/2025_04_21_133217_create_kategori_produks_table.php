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
        Schema::create('kategori_produks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kategori_produk')->unique();
            $table->string('nama_kategori_produk');
            $table->string('gambar_kategori_produk')->nullable();
            $table->text('deskripsi_kategori_produk')->nullable();
            $table->unsignedBigInteger('kategori_toko_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('kategori_toko_id')->references('id')->on('kategori_tokos')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_produks');
    }
};
