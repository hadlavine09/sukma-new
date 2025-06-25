<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory,SoftDeletes;
     protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $connection = 'pgsql'; // kalau pakai pgsql, wajib ini

    public static function getSemuaSupplier()
    {
        return self::all(); // Ambil semua data dari tabel kategoris
    }
    // app/Models/Supplier.php

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

}
