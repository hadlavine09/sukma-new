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
            Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();                  // Contoh: HEMAT10
            $table->enum('tipe', ['nominal', 'persentase']);  // Jenis diskon
            $table->integer('nilai');                         // Jumlah potongan (misal: 10000 atau 10%)
            $table->integer('maksimum_potongan')->nullable(); // Maksimum potongan untuk tipe persentase
            $table->integer('minimal_belanja')->default(0);   // Syarat minimum belanja
            $table->date('mulai_berlaku');
            $table->date('berakhir');
            $table->integer('kuota')->default(0);             // Berapa kali bisa digunakan
            $table->integer('digunakan')->default(0);         // Tracking berapa kali sudah digunakan
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
