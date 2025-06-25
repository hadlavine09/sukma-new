<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\DetailProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

class DetailProdukController extends Controller
{
public function detailproduk($nama_produk)
{
    $kode_produk = request()->query('kode');

    // Cari produk berdasarkan kode_produk
    $produk = Produk::where('kode_produk', $kode_produk)->firstOrFail();
    return view('frontend.detail_produk', compact('produk'));
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
    public function show(DetailProduk $detailProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailProduk $detailProduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailProduk $detailProduk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailProduk $detailProduk)
    {
        //
    }
}
