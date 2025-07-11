<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'alamats';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
