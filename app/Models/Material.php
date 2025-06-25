<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
   use HasFactory, SoftDeletes;

    // Tentukan nama tabel (jika berbeda dari konvensi)
    protected $table = 'materials';
    protected $primaryKey = 'id';

    // Kolom yang dapat diisi mass-assignment
    protected $fillable = [
        'kode_material',
        'nama_material',
        'jumlah_material',
        'harga_material',
        'deskripsi_material',
    ];

    protected $connection = 'pgsql'; // kalau pakai pgsql, wajib ini

    public static function getSemuaMaterial()
    {
        return self::all(); // Ambil semua data dari tabel kategoris
    }
    // app/Models/Material.php

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'material_id');
    }

}
