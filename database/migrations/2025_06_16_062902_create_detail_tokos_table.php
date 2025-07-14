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
          Schema::create('detail_tokos', function (Blueprint $table) {
            $table->id();

            // Foreign key ke toko
            $table->unsignedBigInteger('toko_id')->unique();
            $table->foreign('toko_id')->references('id')->on('tokos')->onDelete('cascade');

            // Dokumen kepemilikan
            $table->string('nama_ktp')->nullable();
            $table->string('nomor_ktp')->nullable();
            $table->string('nomor_kk')->nullable();
            $table->string('foto_ktp')->nullable(); // path gambar disimpan
            $table->string('foto_kk')->nullable();

            // Informasi rekening
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_pemilik_rekening')->nullable();

            // Kontak dan sosial media
            $table->string('email_cs')->nullable();
            $table->string('whatsapp_cs')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_tiktok')->nullable();

            // Lokasi & Jam Operasional
            $table->string('link_google_maps')->nullable();
            // Waktu dan penghapusan lunak
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_tokos');
    }
};
