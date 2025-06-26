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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tag')->unique();
            $table->string('nama_tag');
            $table->string('gambar_tag')->nullable();
            $table->text('deskripsi_tag')->nullable();
            $table->unsignedBigInteger('kategori_produk_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('kategori_produk_id')->references('id')->on('kategori_produks')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
