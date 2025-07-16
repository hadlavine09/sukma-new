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
        Schema::create('tokos', function (Blueprint $table) {
            $table->id();
            $table->string('kode_toko')->unique();
            $table->unsignedBigInteger('pemilik_toko_id');
            $table->unsignedBigInteger('kategori_toko_id');
            $table->string('nama_toko');
            $table->string('logo_toko')->nullable();
            $table->string('no_hp_toko');
            $table->string('alamat_toko');
            $table->text('deskripsi_toko')->nullable();
            $table->enum('status_toko', ['izinkan', 'tidak_diizinkan', 'proses','belum_beres'])->default('belum_beres');
            $table->boolean('status_aktif_toko')->default(true);
            $table->string('kategori_lain')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->text('catatan_penolakan')->nullable();

            $table->foreign('pemilik_toko_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kategori_toko_id')->references('id')->on('kategori_tokos')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokos');
    }
};
