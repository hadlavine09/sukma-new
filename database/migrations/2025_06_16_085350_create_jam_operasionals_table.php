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
        Schema::create('jam_operasionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('toko_id');
            $table->string('hari');
            $table->boolean('buka')->default(false);
            $table->time('jam_buka')->nullable();
            $table->time('jam_tutup')->nullable();
            $table->timestamps();

            $table->foreign('toko_id')->references('id')->on('tokos')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_operasionals');
    }
};
