<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data produk
            $produk = Produk::all(); // Bisa diganti dengan query yang lebih kompleks, misalnya dengan filter atau pagination

            return DataTables::of($produk)
                ->addIndexColumn()
                ->editColumn('harga_produk', function ($data) {
                    return 'Rp ' . number_format($data->harga_produk, 2, ',', '.'); // Format harga
                })
                ->editColumn('created_at', function ($data) {
                    return \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i'); // Format waktu
                })
                ->addColumn('action', function ($data) {
                    // Tombol untuk Show, Edit dan Hapus
                    return '
                        <a href="' . route('produk.show', $data->kode_produk) . '" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Show
                        </a>
                        <a href="' . route('produk.edit', $data->kode_produk) . '" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="' . $data->kode_produk . '" data-nm="' . $data->nama_produk . '">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    ';
                })
                ->rawColumns(['action']) // Menandai kolom 'action' sebagai raw HTML untuk menghindari escaping
                ->make(true);  // DataTables JSON response
        }
        // $produk = Produk::all(); // Bisa diganti dengan query yang lebih kompleks, misalnya dengan filter atau pagination
        // dd($produk);

        // Mengirim data produk untuk tampilan normal jika tidak menggunakan AJAX
        return view('backend.manajementuser.user.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
