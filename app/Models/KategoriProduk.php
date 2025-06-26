<?php

namespace App\Models;

use App\Models\kategori_toko;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriProduk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kategori_produks'; // pastikan nama tabel benar
    protected $primaryKey = 'id';

    protected $guarded = ['id'];



    public static function getSemuaKategori()
    {
        return self::all(); // Ambil semua data dari tabel kategoris
    }
    public function produks()
    {
        return $this->hasMany(Produk::class, 'kode_kategori_produk', 'kode_kategori_produk');
    }
    public function kategoriToko()
{
    return $this->belongsTo(kategori_toko::class, 'kategori_toko_id');
}


}
