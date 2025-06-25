<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UmkmAuthController extends Controller
{
    public function alur()
    {
        return view('frontend.umkm.alur'); // Pastikan view ini tersedia
    }

    public function index()
    {
        return view('frontend.umkm.register'); // Pastikan view ini tersedia
    }
}
