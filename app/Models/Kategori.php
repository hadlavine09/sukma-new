<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kategoris'; // pastikan nama tabel benar
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'deskripsi_kategori',
        'gambar_kategori'
    ];



    public static function getSemuaKategori()
    {
        return self::all(); // Ambil semua data dari tabel kategoris
    }
    public function produks()
    {
        return $this->hasMany(Produk::class, 'kode_kategori', 'kode_kategori');
    }


}
