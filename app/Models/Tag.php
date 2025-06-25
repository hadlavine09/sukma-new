<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tags'; // pastikan nama tabel benar
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_tag',
        'nama_tag',
        'deskripsi_tag',
        'gambar_tag'
    ];



    public static function getSemuaTag()
    {
        return self::all(); // Ambil semua data dari tabel tags
    }
}
