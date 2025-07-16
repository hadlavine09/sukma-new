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
            $table->unsignedBigInteger('kategori_produk_id');
            $table->unsignedBigInteger('toko_id');
            $table->enum('status_produk', ['publik', 'private'])->default('private');
            $table->enum('status_draf_produk', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->unsignedTinyInteger('biaya_admin_desa_persen')->default(0); // contoh: 10%
            $table->unsignedInteger('biaya_pengiriman')->default(0);
            $table->string('harga_total'); // harga setelah admin dan pengiriman
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('kategori_produk_id')->references('id')->on('kategori_produks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('toko_id')->references('id')->on('tokos')->onUpdate('cascade')->onDelete('cascade');

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
