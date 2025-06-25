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
        Schema::create('tag_produks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tag');
            $table->string('kode_produk');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('kode_tag')->references('kode_tag')->on('tags')->onDelete('cascade');
            $table->foreign('kode_produk')->references('kode_produk')->on('produks')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_produks');

    }
};
