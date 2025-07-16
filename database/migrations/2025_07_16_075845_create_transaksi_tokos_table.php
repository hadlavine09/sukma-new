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
         Schema::create('transaksi_tokos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
        $table->foreignId('toko_id')->constrained('tokos')->onDelete('cascade');
        $table->integer('subtotal');
        $table->integer('biaya_admin_desa_persen')->default(0);
        $table->integer('biaya_pengiriman')->nullable();
        $table->integer('total_setelah_biaya');
        $table->integer('jumlah_uang')->nullable();
        $table->enum('status_pengiriman', ['proses', 'selesai'])->default('proses');
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
        Schema::dropIfExists('transaksi_tokos');
    }
};
