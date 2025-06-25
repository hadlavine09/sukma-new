<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Tag;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        $tags = Tag::all();
        $produks = Produk::join('kategoris', 'produks.kode_kategori', '=', 'kategoris.kode_kategori')
        ->select('produks.*', 'kategoris.nama_kategori')
        ->get();
        return view('frontend.shop',compact('kategoris','produks','tags'));
    }
    public function show_detail($kode_produk)
    {
        $produk = Produk::join('kategoris', 'produks.kode_kategori', '=', 'kategoris.kode_kategori')
        ->select('produks.*', 'kategoris.nama_kategori')
        ->first();
        return view('frontend.shop_detail',compact('produk'));
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
