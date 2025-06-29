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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk')->unique();
            $table->string('nama_produk');
            $table->text('deskripsi_produk')->nullable();
            $table->unsignedInteger('stok_produk')->default(0);
            $table->string('harga_produk');
            $table->string('gambar_produk')->nullable();
            $table->unsignedBigInteger('kategori_toko_id');
            $table->enum('status_produk', ['publik', 'private'])->default('private');
            $table->enum('status_draf_produk', ['Aktif', 'Tidak Aktif'])->default('Aktif');
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
        Schema::dropIfExists('produks');
    }
};
