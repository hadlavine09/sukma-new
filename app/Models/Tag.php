<?php

namespace App\Models;

use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tags'; // pastikan nama tabel benar
    protected $primaryKey = 'id';

    protected $guarded = [
        'id'
    ];



    public static function getSemuaTag()
    {
        return self::all(); // Ambil semua data dari tabel tags
    }
     public function kategoriProduk()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }
}
