<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function getUsers()
    {
        $users = DB::table('users')->get(['id', 'name', 'email', 'username', 'no_hp', 'no_ktp', 'profile', 'email_verified_at', 'password', 'google_id', 'avatar', 'remember_token', 'created_at', 'updated_at']);

        return response()->json($users);
    }

    public function bankKartu()
    {
        return view('frontend.profile.bank_kartu');
    }
    public function alamat()
    {
        return view('frontend.profile.alamat');
    }
    public function ubahPassword()
    {
        return view('frontend.profile.ubah_password');
    }
    public function notifikasiSetting()
    {
        return view('frontend.profile.notifikasi_setting');
    }
    public function privasiSetting()
    {
        return view('frontend.profile.privasi_setting');
    }

    public function pesanan()
    {
        // Dummy data pesanan sesuai kategori tab
        $pesanan = [
            [
                'id' => 1,
                'produk' => 'Baju Batik',
                'jumlah' => 2,
                'harga' => 150000,
                'status' => 'Belum Bayar',
                'tanggal' => '2024-06-11'
            ],
            [
                'id' => 2,
                'produk' => 'Sepatu Sneakers',
                'jumlah' => 1,
                'harga' => 350000,
                'status' => 'Diproses',
                'tanggal' => '2024-06-10'
            ],
            [
                'id' => 3,
                'produk' => 'Tas Kulit',
                'jumlah' => 1,
                'harga' => 250000,
                'status' => 'Dikirim',
                'tanggal' => '2024-06-09'
            ],
            [
                'id' => 4,
                'produk' => 'Jam Tangan',
                'jumlah' => 1,
                'harga' => 500000,
                'status' => 'Selesai',
                'tanggal' => '2024-06-08'
            ],
            [
                'id' => 5,
                'produk' => 'Kemeja Pria',
                'jumlah' => 3,
                'harga' => 300000,
                'status' => 'Diproses',
                'tanggal' => '2024-06-07'
            ]
        ];

        return view('frontend.profile.pesanan', compact('pesanan'));
    }
    public function notifikasi()
    {
        return view('frontend.profile.notifikasi');
    }
    public function voucher()
    {
        return view('frontend.profile.voucher');
    }
    public function koin()
    {
        return view('frontend.profile.koin');
    }
}
