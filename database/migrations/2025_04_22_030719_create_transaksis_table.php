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
        $table->enum('metode_pembayaran', ['cod', 'transfer']);
        $table->integer('subtotal');
        $table->integer('biaya_admin_desa_persen')->default(0);
        $table->integer('biaya_pengiriman')->nullable();
        $table->integer('total_setelah_biaya');
        $table->integer('jumlah_uang')->nullable();
        $table->enum('status_transaksi', ['proses','selesai'])->default('proses');
        $table->timestamps();
        $table->softDeletes();
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
