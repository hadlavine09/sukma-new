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
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('alamat_id')->constrained('alamats')->onDelete('cascade');

        $table->string('kode_transaksi')->unique();
        $table->enum('metode_pembayaran', ['cod', 'transfer', 'ewallet']);

        // Ringkasan
        $table->integer('subtotal'); // Sebelum diskon
        $table->integer('diskon')->default(0);
        $table->integer('total_bayar');

        // Status proses pesanan
        $table->enum('status', ['menunggu', 'diproses', 'dikirim', 'selesai', 'batal'])->default('menunggu');

        $table->json('produk'); // [{nama_produk, kode_produk, harga_satuan, jumlah, total_harga, catatan}, ...]

        $table->timestamps();
        $table->softDeletes(); // jika kamu ingin fitur soft delete
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
// !9tARrQmD83iU@Z
