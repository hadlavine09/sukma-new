<?php

namespace App\Models;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    // Tentukan nama tabel (jika berbeda dari konvensi)
    protected $table = 'produks';
    protected $primaryKey = 'id';

    // Kolom yang dapat diisi mass-assignment
    protected $guarded = ['id'];

    protected $connection = 'pgsql'; // kalau pakai pgsql, wajib ini

    public static function getSemuaProduk()
    {
        return self::all(); // Ambil semua data dari tabel kategoris
    }
    public function kategoriproduk()
{
    return $this->belongsTo(KategoriProduk::class, 'kode_kategori_produk', 'kode_kategori_produk');
}

}
