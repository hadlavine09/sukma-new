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
        Schema::create('kategori_tokos', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kategori_toko');
            $table->string('nama_kategori_toko');
            $table->string('gambar_kategori_toko')->nullable();
            $table->text('deskripsi_kategori_toko')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_tokos');
    }
};
