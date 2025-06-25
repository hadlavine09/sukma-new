<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MaterialController extends Controller
{

   public function index(Request $request)
    {
        // dd($material = Material::all());
        if ($request->ajax()) {
            // Ambil data produk
            $material = Material::all(); // Bisa diganti dengan query yang lebih kompleks, misalnya dengan filter atau pagination

            return DataTables::of($material)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('material.show', $data->kode_material) . '" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Show
                        </a>
                        <a href="' . route('material.edit', $data->kode_material) . '" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="' . $data->id . '" data-nm="' . $data->nama_material . '">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    ';
                })
                ->rawColumns(['action']) // Menandai kolom 'action' sebagai raw HTML untuk menghindari escaping
                ->make(true);  // DataTables JSON response
        }
        return view('backend.manajementmaterial.material.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.manajementmaterial.material.create');

    }

    public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // Validasi request
        $validated = $request->validate([
            'nama_material'      => 'required',
            'jumlah_material'    => 'required|integer|min:1',
            'harga_material'     => 'required|numeric|min:1',
            'deskripsi_material' => 'required|string|min:10',
        ]);

        // Ambil kode terakhir
        $lastMaterial = DB::table('materials')->orderBy('kode_material', 'desc')->first();

        if ($lastMaterial) {
            $lastCode = (int)substr($lastMaterial->kode_material, 3); // ambil angka setelah 'MTR'
            $newCode = 'MTR' . str_pad($lastCode + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newCode = 'MTR001';
        }

        // Simpan material
        Material::create([
            'kode_material'      => $newCode,
            'nama_material'      => $validated['nama_material'],
            'jumlah_material'    => $validated['jumlah_material'],
            'harga_material'     => $validated['harga_material'],
            'deskripsi_material' => $validated['deskripsi_material'],
        ]);

        DB::commit();

        return redirect()->route('material.index')->with('success', 'Material berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()])
            ->withInput();
    }
}

public function show($kode_material)
{
    $material = Material::where('kode_material', $kode_material)->firstOrFail();
    return view('backend.manajementmaterial.material.show', compact('material'));
}

public function edit($kode_material)
{
    $material = Material::where('kode_material', $kode_material)->firstOrFail();
    return view('backend.manajementmaterial.material.edit', compact('material'));
}

public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {
        $validated = $request->validate([
            'nama_material'      => 'required',
            'jumlah_material'    => 'required|integer|min:1',
            'harga_material'     => 'required|numeric|min:1',
            'deskripsi_material' => 'required|string|min:10',
        ]);

        $material = Material::where('id', $id)->firstOrFail();

        $material->update($validated);

        DB::commit();

        return redirect()->route('material.index')->with('success', 'Material berhasil diperbarui!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->withErrors(['error' => 'Gagal memperbarui: ' . $e->getMessage()])
            ->withInput();
    }
}

public function destroy(Request $request)
{
    try {
        $id = $request->id;
        $material = Material::where('id', $id)->firstOrFail();
        $material->delete();
        return redirect()->route('material.index')->with('success', 'Data Material berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->route('material.index')->with('error', 'Terjadi kesalahan dalam menghapus data');
    }
}

}
