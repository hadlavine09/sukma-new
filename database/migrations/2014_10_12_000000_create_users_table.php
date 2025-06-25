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
         Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->nuunique()->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('profile')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(); // Boleh nullable untuk pengguna Google login
            $table->string('google_id')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Unique constraint untuk kolom nullable harus dibuat terpisah (index bersyarat)
            $table->unique('no_hp');
            $table->unique('no_ktp');
            $table->unique('google_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
// K7VMLV9LCLJB4AUCE22A8C1V
