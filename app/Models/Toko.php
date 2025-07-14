<?php

namespace App\Models;

use App\Models\DetailToko;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Toko extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'tokos';
    protected $primaryKey = 'id';


    protected $guarded = ['id'];
    public function detailToko()
{
    return $this->hasOne(DetailToko::class, 'toko_id');
}


}
