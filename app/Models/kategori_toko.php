<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kategori_toko extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kategori_tokos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_kategori_toko',
        'nama_kategori_toko',
        'gambar_kategori_toko',
        'deskripsi_kategori_toko'
    ];
}
