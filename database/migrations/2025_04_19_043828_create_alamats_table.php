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
        Schema::create('alamats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_alamat'); // Contoh: "Alamat Rumah", "Alamat Kantor"
            $table->string('nama_penerima');
            $table->string('no_hp');
            $table->text('alamat_lengkap');
            $table->boolean('is_utama')->default(false); // Untuk alamat default
            $table->timestamps();
                        $table->softDeletes();

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamats');
    }
};
