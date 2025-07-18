<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            // Total Toko Aktif
            $total_toko = DB::table('tokos')
                ->where('status_toko', 'izinkan')
                ->count();

            // Total User dengan role 'user'
            $total_user = User::whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })->count();

            // Penghasilan Bulan Ini
            $penghasilan_admin = DB::table('transaksis')
                ->where('status_transaksi', 'selesai')
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('biaya_admin_desa_persen');

            // Total Transaksi selesai
            $total_transaksi = DB::table('transaksis')
                ->where('status_transaksi', 'selesai')
                ->count();

            $hariMap = [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu'
            ];

            $penghasilanPerHari = array_fill_keys(array_keys($hariMap), 0);

            $penghasilan_7_hari_raw = DB::table('transaksi_tokos')
                ->where('status_transaksi', 'selesai')
                ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
                ->selectRaw("TO_CHAR(created_at, 'FMDay') as hari, SUM(subtotal + biaya_admin_desa_persen) as total_penghasilan")
                ->groupBy(DB::raw("TO_CHAR(created_at, 'FMDay')"))
                ->get();

            foreach ($penghasilan_7_hari_raw as $item) {
                $dayEnglish = trim($item->hari); // 'Monday', 'Tuesday', etc.
                if (isset($penghasilanPerHari[$dayEnglish])) {
                    $penghasilanPerHari[$dayEnglish] = (float) $item->total_penghasilan;
                }
            }

            $penghasilan_7_hari_chart = [];
            foreach ($hariMap as $en => $id) {
                $penghasilan_7_hari_chart[] = [
                    'label' => $id,
                    'value' => $penghasilanPerHari[$en]
                ];
            }

            $kategori_terlaris = DB::table('transaksi_produks')
                ->join('produks', 'transaksi_produks.nama_produk', '=', 'produks.nama_produk')
                ->join('kategori_produks', 'produks.kategori_produk_id', '=', 'kategori_produks.id')
                ->select(
                    'kategori_produks.nama_kategori_produk',
                    DB::raw('SUM(transaksi_produks.qty) as total_terjual')
                )
                ->groupBy('kategori_produks.id', 'kategori_produks.nama_kategori_produk')
                ->orderByDesc('total_terjual')
                ->limit(7)
                ->get();
            // dd($kategori_terlaris);

            $tokoTerlaris = DB::table('transaksi_produks')
                ->join('transaksi_tokos', 'transaksi_produks.transaksi_toko_id', '=', 'transaksi_tokos.id')
                ->join('tokos', 'transaksi_tokos.toko_id', '=', 'tokos.id')
                ->select(
                    'tokos.id',
                    'tokos.nama_toko',
                    DB::raw('SUM(transaksi_produks.qty) as total_terjual')
                )
                ->groupBy('tokos.id', 'tokos.nama_toko')
                ->orderByDesc('total_terjual')
                ->limit(7)
                ->get();
            $produk_terlaris = DB::table('transaksi_produks')
                ->join('produks', 'transaksi_produks.nama_produk', '=', 'produks.nama_produk')
                ->select(
                    'produks.nama_produk',
                    DB::raw('SUM(transaksi_produks.qty) as total_terjual')
                )
                ->groupBy('produks.nama_produk')
                ->orderByDesc('total_terjual')
                ->limit(7)
                ->get();

            return view('backend.dashboardsuperadmin', [
                'tokoData' => [
                    'total_toko' => $total_toko,
                    'total_pengguna' => $total_user,
                    'penghasilan_bulan_ini' => $penghasilan_admin,
                    'total_transaksi_semua_toko' => $total_transaksi,
                    'penghasilan_7_hari_chart' => $penghasilan_7_hari_chart,
                    'kategori_terlaris' => $kategori_terlaris,
                    'toko_terlaris' => $tokoTerlaris,
                    'produk_terlaris' => $produk_terlaris
                ]
            ]);
        } else {
            // Role lain tidak diizinkan
            abort(403, 'Akses ditolak. Role tidak diizinkan.');
        }
    }
}
