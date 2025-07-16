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
        Schema::create('transaksi_produks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('transaksi_toko_id')->constrained('transaksi_tokos')->onDelete('cascade');
        $table->string('nama_produk');
        $table->integer('qty');
        $table->integer('harga_satuan');
        $table->integer('subtotal_produk');
        $table->integer('biaya_admin_desa_persen')->default(0);
        $table->integer('biaya_pengiriman')->nullable();
        $table->integer('total_setelah_biaya');
        $table->text('catatan')->nullable();


        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_produks');
    }
};
