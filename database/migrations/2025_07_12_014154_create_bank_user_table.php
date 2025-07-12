<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankUserTable extends Migration
{
    public function up()
    {
        Schema::create('bank_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_bank');
            $table->string('no_rekening');
            $table->string('nama_pemilik');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_user');
    }
}

