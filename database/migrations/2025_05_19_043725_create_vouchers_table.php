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
                $table->string('kode_voucher')->unique();
                $table->string('potongan_voucher'); // Sekarang string
                $table->date('tanggal_mulai_voucher')->nullable();
                $table->date('tanggal_berakhir_voucher')->nullable();
                $table->enum('status_voucher', ['aktif', 'tidak aktif'])->default('aktif');
                $table->enum('status_draf_voucher', ['publik', 'private'])->default('publik');

                $table->timestamps();
                $table->softDeletes();
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
