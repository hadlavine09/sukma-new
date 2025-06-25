<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TransaksiMaterial extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data supplier
            $supplier = Supplier::all(); // Bisa diganti dengan query yang lebih kompleks, misalnya dengan filter atau pagination

            return DataTables::of($supplier)
                ->addIndexColumn()
                ->make(true);  // DataTables JSON response
        }
        // Mengirim data supplier untuk tampilan normal jika tidak menggunakan AJAX
        return view('backend.manajementmaterial.transaksimaterial.index');
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
