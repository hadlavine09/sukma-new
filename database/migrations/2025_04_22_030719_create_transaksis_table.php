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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique(); // Unique transaction code (for reference)
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('kode_produk');
            $table->integer('quantity')->default(1);
            $table->decimal('harga_produk', 12, 2);
            $table->decimal('total_harga_produk', 12, 2);
            $table->enum('status', ['proses', 'success', 'failed']); // Status of the transaction

            // Add user details fields
            $table->string('nama')->nullable(); // User's name
            $table->string('alamat')->nullable(); // User's address
            $table->string('no_hp')->nullable(); // User's phone number
            $table->string('catatan')->nullable(); // User's phone number

            // Define foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kode_produk')->references('kode_produk')->on('produks')->onDelete('cascade');

            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // to support soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
// !9tARrQmD83iU@Z
