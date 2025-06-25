<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IzinToko extends Model
{
      use HasFactory,SoftDeletes;

    protected $table = 'izin_tokos';
    protected $primaryKey = 'id';


    protected $guarded = ['id'];
}
