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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_supplier');
            $table->string('nama_supplier');
            $table->string('contact_supplier')->nullable();
            $table->string('alamat_supplier')->nullable();
            // Ubah ke unsignedBigInteger dan tambah foreign key
            $table->unsignedBigInteger('material_id')->nullable();
            $table->integer('jumlah_material_supplier');
            $table->decimal('total_harga_material_supplier', 15, 2);
            $table->string('deskripsi')->nullable();
            $table->date('tanggal');
            $table->timestamps();
            $table->softDeletes();
            // Foreign key constraint
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
