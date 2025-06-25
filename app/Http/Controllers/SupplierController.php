<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Kategori;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
   public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data supplier
            $supplier = Supplier::all(); // Bisa diganti dengan query yang lebih kompleks, misalnya dengan filter atau pagination

            return DataTables::of($supplier)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    // Tombol untuk Show, Edit dan Hapus
                    return '
                        <a href="' . route('supplier.show', $data->id) . '" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Show
                        </a>
                        <a href="' . route('supplier.edit', $data->id) . '" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="' . $data->id . '" data-nm="' . $data->nama_supplier . '">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    ';
                })
                ->rawColumns(['action']) // Menandai kolom 'action' sebagai raw HTML untuk menghindari escaping
                ->make(true);  // DataTables JSON response
        }
        // Mengirim data supplier untuk tampilan normal jika tidak menggunakan AJAX
        return view('backend.manajementmaterial.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materials = Material::getSemuaMaterial();
        return view('backend.manajementmaterial.supplier.create',compact('materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // Validasi data
        $validated = $request->validate([
            'nama_supplier'            => 'required|string|max:255',
            'contact_supplier'         => 'nullable|string|max:255',
            'material_id'              => 'required|exists:materials,id',
            'jumlah_material_supplier' => 'required|integer|min:1',
            'total_harga_material_supplier'  => 'required|numeric|min:1',
            'alamat_supplier'          => 'nullable|string',
            'deskripsi'                => 'nullable|string|max:1000',
        ]);

        // Ambil kode terakhir
        $lastSupplier = DB::table('suppliers')->orderBy('kode_supplier', 'desc')->first();

        if ($lastSupplier && preg_match('/SPR(\d+)/', $lastSupplier->kode_supplier, $matches)) {
            $lastCode = (int) $matches[1];
            $newCode = 'SPR' . str_pad($lastCode + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newCode = 'SPR001';
        }

        // Simpan data supplier
        Supplier::create([
            'kode_supplier'            => $newCode,
            'nama_supplier'            => $validated['nama_supplier'],
            'contact_supplier'         => $validated['contact_supplier'],
            'material_id'              => $validated['material_id'],
            'jumlah_material_supplier' => $validated['jumlah_material_supplier'],
            'total_harga_material_supplier'  => $validated['total_harga_material_supplier'],
            'alamat_supplier'          => $validated['alamat_supplier'],
            'deskripsi'                => $validated['deskripsi'],
            'tanggal'                  => Carbon::now(), // Diperbaiki di sini
        ]);

        DB::commit();

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()
            ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()])
            ->withInput();
    }
}


    /**
     * Display the specified resource.
     */
   public function show($id)
{
    $supplier = Supplier::with('material')->findOrFail($id);
    return view('backend.manajementmaterial.supplier.show', compact('supplier'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::with('material')->findOrFail($id);
        $materials = Material::all();
        return view('backend.manajementmaterial.supplier.edit', compact('supplier','materials'));

    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {
        // Validasi data
        $validated = $request->validate([
            'nama_supplier'            => 'required|string|max:255',
            'contact_supplier'         => 'nullable|string|max:255',
            'material_id'              => 'required|exists:materials,id',
            'jumlah_material_supplier' => 'required|integer|min:1',
            'total_harga_material_supplier'  => 'required|numeric|min:1',
            'alamat_supplier'          => 'nullable|string',
            'deskripsi'                => 'nullable|string|max:1000',
        ]);

        // Temukan supplier
        $supplier = Supplier::findOrFail($id);

        // Update data supplier
        $supplier->update([
            'nama_supplier'            => $validated['nama_supplier'],
            'contact_supplier'         => $validated['contact_supplier'],
            'material_id'              => $validated['material_id'],
            'jumlah_material_supplier' => $validated['jumlah_material_supplier'],
            'total_harga_material_supplier'  => $validated['total_harga_material_supplier'],
            'alamat_supplier'          => $validated['alamat_supplier'],
            'deskripsi'                => $validated['deskripsi'],
            // 'kode_supplier' dan 'tanggal' tidak diubah
        ]);

        DB::commit();

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui!');
    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()
            ->withErrors(['error' => 'Terjadi kesalahan saat mengupdate: ' . $e->getMessage()])
            ->withInput();
    }
}


    public function destroy(Request $request)
{
    $id = $request->id;
    DB::beginTransaction();

    try {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete(); // Soft delete (tidak benar-benar dihapus dari DB)

        DB::commit();
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('supplier.index')->withErrors(['error' => 'Gagal menghapus supplier: ' . $e->getMessage()]);
    }
}



}
