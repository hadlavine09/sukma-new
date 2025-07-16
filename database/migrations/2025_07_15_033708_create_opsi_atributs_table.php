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
        Schema::create('opsi_atributs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atribut_produk_id')->constrained('atribut_produks');
            $table->string('opsi'); // Contoh: S, M, L atau Merah, Biru
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opsi_atributs');
    }
};
