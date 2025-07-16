<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

public function profile_toko()
{
    $user = Auth::user();

    $tokoshow = DB::table('tokos')
        ->join('users', 'tokos.pemilik_toko_id', '=', 'users.id')
        ->join('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
        ->join('detail_tokos', 'tokos.id', '=', 'detail_tokos.toko_id')
        ->where('tokos.pemilik_toko_id', $user->id)
        ->whereNull('tokos.deleted_at')
        ->whereNull('kategori_tokos.deleted_at')
        ->select(
            'tokos.*',
            'users.username as nama_pemilik',
            'kategori_tokos.nama_kategori_toko',
            'detail_tokos.nama_ktp',
            'detail_tokos.nomor_ktp',
            'detail_tokos.nomor_kk',
            'detail_tokos.foto_ktp',
            'detail_tokos.foto_kk',
            'detail_tokos.nama_bank',
            'detail_tokos.nomor_rekening',
            'detail_tokos.nama_pemilik_rekening',
            'detail_tokos.email_cs',
            'detail_tokos.whatsapp_cs',
            'detail_tokos.link_instagram',
            'detail_tokos.link_facebook',
            'detail_tokos.link_tiktok',
            'detail_tokos.link_google_maps',
            'tokos.logo_toko'
        )
        ->first();

    if (!$tokoshow) {
        return redirect()->back()->with('error', 'Toko tidak ditemukan.');
    }

    $jadwalOperasional = DB::table('jam_operasionals')
        ->where('toko_id', $tokoshow->id)
        ->orderByRaw("CASE
            WHEN hari = 'Senin' THEN 1
            WHEN hari = 'Selasa' THEN 2
            WHEN hari = 'Rabu' THEN 3
            WHEN hari = 'Kamis' THEN 4
            WHEN hari = 'Jumat' THEN 5
            WHEN hari = 'Sabtu' THEN 6
            WHEN hari = 'Minggu' THEN 7
            ELSE 8 END")
        ->get();

    return view('backend.profile_toko', compact('tokoshow', 'jadwalOperasional'));
}

public function index()
{
    $user = Auth::user();

    // Ambil role user dari tabel role_user dan roles
    $role = DB::table('role_user')
        ->where('user_id', $user->id)
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->select('roles.name')
        ->first();

    if (!$role) {
        abort(403, 'Akses ditolak. Role tidak ditemukan.');
    }

    $roleName = $role->name;

    if ($roleName === 'toko') {
        // Dashboard khusus untuk admin toko
        $tokoData = [
            'nama_toko' => 'Toko Haddad',
            'penghasilan_bulan_ini' => 12500000,
            'total_follower' => 1240,
            'produk_disukai' => 570,
            'jumlah_produk' => 48,
            'total_transaksi' => 320,
            'rating_toko' => 4.7,
            'penghasilan_7_hari' => [200000, 350000, 400000, 280000, 600000, 750000, 1000000],
            'produk_likes_top' => [
                ['name' => 'Sambal Pedas', 'value' => 120],
                ['name' => 'Keripik Kentang', 'value' => 85],
                ['name' => 'Brownies', 'value' => 75],
            ],
            'kategori_terjual' => [
                ['name' => 'Makanan', 'value' => 200],
                ['name' => 'Minuman', 'value' => 100],
                ['name' => 'Snack', 'value' => 150],
            ],
            'transaksi_status' => [
                ['name' => 'Sukses', 'value' => 320],
                ['name' => 'Pending', 'value' => 80],
                ['name' => 'Gagal', 'value' => 15],
            ]
        ];

        return view('backend.dashboard', compact('tokoData'));

    } elseif ($roleName === 'superadmin') {
        // Dashboard khusus untuk superadmin
        $tokoData = [
            'total_toko' => 232323,
            'total_pengguna' => 23232,
            'penghasilan_bulan_ini' => 12500000,
            'total_transaksi_semua_toko' => 320,
            'rating_toko_semua' => 4.7,
            'penghasilan_7_hari_toko' => [200000, 350000, 400000, 280000, 600000, 750000, 1000000],
            'produk_likes_top' => [
                ['name' => 'Sambal Pedas', 'value' => 120],
                ['name' => 'Keripik Kentang', 'value' => 85],
                ['name' => 'Brownies', 'value' => 75],
            ],
            'kategori_terjual' => [
                ['name' => 'Makanan', 'value' => 200],
                ['name' => 'Minuman', 'value' => 100],
                ['name' => 'Snack', 'value' => 150],
            ],
            'transaksi_status' => [
                ['name' => 'Sukses', 'value' => 320],
                ['name' => 'Pending', 'value' => 80],
                ['name' => 'Gagal', 'value' => 15],
            ]
        ];

        return view('backend.dashboardsuperadmin', compact('tokoData','roleName'));
    } else {
        // Role lain tidak diizinkan
        abort(403, 'Akses ditolak. Role tidak diizinkan.');
    }
}
}
