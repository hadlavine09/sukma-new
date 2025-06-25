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
        Schema::create('izin_tokos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('toko_id');
            $table->string('nomor_izin');
            $table->string('nama_dokumen');
            $table->string('file_dokumen'); // nama file / path dokumen
            $table->date('tanggal_terbit');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('toko_id')->references('id')->on('tokos')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_tokos');
    }
};
