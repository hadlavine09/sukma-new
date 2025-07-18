<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
public function index(Request $request)
{
    $user = auth()->user();

    // Ambil role user
    $role = DB::table('role_user')
        ->where('user_id', $user->id)
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->select('roles.name')
        ->first();

    if ($request->ajax()) {
        if ($role && $role->name === 'toko') {
            // Ambil ID toko milik user login
            $tokoId = DB::table('tokos')->where('pemilik_toko_id', $user->id)->value('id');

            $transaksi = DB::table('transaksi_tokos')
                ->join('transaksis', 'transaksi_tokos.transaksi_id', '=', 'transaksis.id')
                ->join('users', 'transaksis.user_id', '=', 'users.id')
                ->where('transaksi_tokos.toko_id', $tokoId)
                ->where('transaksis.status_transaksi', 'selesai')
                ->select(
                    'transaksis.id as transaksi_id',
                    'transaksis.kode_transaksi',
                    'users.name as pembeli',
                    'transaksis.metode_pembayaran',
                    'transaksis.status_transaksi',
                    'transaksi_tokos.total_setelah_biaya as total_bayar',
                    'transaksis.created_at'
                )
                ->orderByDesc('transaksis.created_at')
                ->get();
        } else {
            // Superadmin
            $transaksi = DB::table('transaksis')
                ->join('users', 'transaksis.user_id', '=', 'users.id')
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('transaksi_tokos')
                        ->whereRaw('transaksi_tokos.transaksi_id = transaksis.id')
                        ->where('transaksi_tokos.status_pengiriman', 'proses');
                })
                ->select(
                    'transaksis.id as transaksi_id',
                    'transaksis.kode_transaksi',
                    'users.name as pembeli',
                    'transaksis.metode_pembayaran',
                    'transaksis.status_transaksi',
                    'transaksis.total_setelah_biaya as total_bayar',
                    'transaksis.created_at'
                )
                ->orderByDesc('transaksis.created_at')
                ->get();
        }
        return DataTables::of($transaksi)
            ->addIndexColumn()
            ->editColumn('metode_pembayaran', function ($data) {
                return strtoupper($data->metode_pembayaran);
            })
            ->editColumn('total_bayar', function ($data) {
                return 'Rp ' . number_format($data->total_bayar, 0, ',', '.');
            })
            ->editColumn('created_at', function ($data) {
                return \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i');
            })
            ->addColumn('action', function ($data) {
                return '
                    <a href="' . route('transaksi.show', $data->transaksi_id) . '" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('backend.manajementtransaksi.transaksi.index');
}
public function index_pengiriman(Request $request)
{
    $user = auth()->user();

    if ($request->ajax()) {
    $transaksi = DB::table('transaksi_tokos')
    ->join('transaksis', 'transaksi_tokos.transaksi_id', '=', 'transaksis.id')
    ->join('users', 'transaksis.user_id', '=', 'users.id')
    ->where('transaksi_tokos.status_pengiriman', 'proses')
    ->select(
        'transaksi_tokos.id as transaksi_toko_id',
        'transaksis.kode_transaksi',
        'users.name as pembeli',
        'transaksis.metode_pembayaran',
        'transaksis.status_transaksi',
        'transaksi_tokos.total_setelah_biaya as total_bayar',
        'transaksi_tokos.status_pengiriman',
        'transaksis.created_at'
    )
    ->orderByDesc('transaksis.created_at')
    ->get();
        return DataTables::of($transaksi)
            ->addIndexColumn()
            ->editColumn('metode_pembayaran', function ($data) {
                return strtoupper($data->metode_pembayaran);
            })
            ->editColumn('created_at', function ($data) {
                return \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i');
            })
            ->addColumn('action', function ($data) {
                return '
                    <a href="' . route('pengiriman.show', $data->transaksi_toko_id) . '" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('backend.manajementtransaksi.pengiriman.index');
}



    /**
     * Display a listing of the resource.
     */
    public function checkout()
{
    $data_checkout = DB::table('transaksis')
        ->join('produks', 'transaksis.kode_produk', '=', 'produks.kode_produk')
        ->where('transaksis.status', 'proses')
        ->select(
            'transaksis.*',
            'produks.nama_produk',
            'produks.gambar_produk',
            'produks.harga_produk as harga_satuan' // Alias jika butuh pembeda dari total_harga
        )
        ->get();

    return view('frontend.checkout', compact('data_checkout'));
}

    public function checkout_proses(Request $request)
    {
        if (!$request->has('cart_item_ids') || empty($request->cart_item_ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada item cart yang dikirim.'
            ]);
        }

        $cartIds = $request->cart_item_ids;

        $carts = DB::table('carts')
            ->join('produks', 'carts.kode_produk', '=', 'produks.kode_produk')
            ->whereIn('carts.id', $cartIds)
            ->select(
                'carts.id as id_cart',
                'carts.quantity',
                'carts.user_id',
                'produks.kode_produk',
                'produks.harga_produk',
                'produks.gambar_produk'
            )
            ->get();

        if ($carts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item tidak ditemukan.'
            ]);
        }

        $createdTransactions = [];

        DB::beginTransaction(); // Mulai transaksi database

        try {
            foreach ($carts as $item) {
                // Generate kode transaksi
                $lastTransaction = DB::table('transaksis')->orderBy('kode_transaksi', 'desc')->first();
                $lastKode = $lastTransaction ? $lastTransaction->kode_transaksi : 'TRS000';
                $lastNumber = (int) substr($lastKode, 3);
                $newNumber = $lastNumber + 1;
                $newKode = 'TRS' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

                // Hitung total harga
                $totalHarga = $item->harga_produk * $item->quantity;

                // Insert transaksi
                DB::table('transaksis')->insert([
                    'kode_transaksi' => $newKode,
                    'user_id' => $item->user_id,
                    'kode_produk' => $item->kode_produk,
                    'quantity' => $item->quantity,
                    'harga_produk' => $item->harga_produk,
                    'total_harga_produk' => $totalHarga,
                    'status' => 'proses', // GANTI SESUAI KONDISI DI DATABASE
                ]);

                $createdTransactions[] = $newKode;
            }

            DB::commit(); // Commit transaksi

            return response()->json([
                'success' => true,
                'message' => 'Checkout berhasil!',
                'transactions' => $createdTransactions,
                'redirect_url' => route('checkout.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollback(); // Rollback semua transaksi jika ada error

            // (Opsional) Log error untuk debugging
            Log::error('Checkout gagal: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Checkout gagal. ' . $e->getMessage()
            ]);
        }
    }
    public function checkout_success(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'kode_transaksi' => 'required|array|min:1', // Harus berupa array dan minimal 1 kode transaksi
        'kode_transaksi.*' => 'string|max:255|exists:transaksis,kode_transaksi', // Pastikan setiap kode transaksi ada di database
        'nama' => 'required|string|max:255',
        'no_hp' => 'required|regex:/^[0-9]+$/|min:10|max:15', // Validasi untuk no_hp (harus angka dan panjang 10-15 karakter)
        'alamat' => 'required|string|max:255',
        'catatan' => 'nullable|string|max:255', // Catatan bersifat opsional
    ]);

    // Dapatkan array kode transaksi dari request
    $kode_transaksi_list = $validatedData['kode_transaksi'];

    // Mulai transaksi database
    DB::beginTransaction();

    try {
        // Update semua transaksi berdasarkan kode transaksi yang diberikan
        DB::table('transaksis')
            ->whereIn('kode_transaksi', $kode_transaksi_list)
            ->update([
                'nama' => $validatedData['nama'],
                'no_hp' => $validatedData['no_hp'],
                'alamat' => $validatedData['alamat'],
                'catatan' => $validatedData['catatan'],
                'status' => 'success', // Status transaksi bisa diubah sesuai dengan kebutuhan
            ]);

        // Commit transaksi jika sukses
        DB::commit();

        // Mengembalikan response sukses
        return response()->json([
            'status' => true,
            'message' => 'Checkout berhasil untuk transaksi yang dipilih.',
        ]);
    } catch (\Exception $e) {
        // Rollback jika ada error
        DB::rollback();
        return response()->json([
            'status' => false,
            'message' => 'Checkout gagal. ' . $e->getMessage()
        ]);
    }
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
public function store(Request $request)
{
    $request->validate([
        'alamat_id' => 'required|exists:alamats,id',
        'cart_ids' => 'required|array|min:1',
        'catatan' => 'nullable|array',
        'metode_pembayaran' => 'required|in:cod,transfer',
        'catatan_umum' => 'nullable|string',
        'jumlah_uang' => 'nullable|integer|min:1',
    ]);

    $userId = auth()->id();

    $cartItems = DB::table('carts')
        ->whereIn('carts.id', $request->cart_ids)
        ->where('carts.user_id', $userId)
        ->join('produks', 'carts.kode_produk', '=', 'produks.kode_produk')
        ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
        ->select(
            'carts.id as cart_id',
            'produks.id as produk_id',
            'produks.nama_produk',
            'produks.stok_produk',
            'produks.toko_id',
            'tokos.nama_toko',
            'produks.biaya_admin_desa_persen',
            'produks.biaya_pengiriman',
            'carts.harga_produk',
            'carts.quantity'
        )
        ->get();

    if ($cartItems->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Keranjang kosong atau tidak valid']);
    }

    foreach ($cartItems as $item) {
        if ($item->quantity > $item->stok_produk) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak cukup untuk produk: ' . $item->nama_produk,
            ]);
        }
    }

    $subtotal = 0;
    foreach ($cartItems as $item) {
        $subtotal += $item->harga_produk * $item->quantity;
    }

    $biayaAdmin = intval(($subtotal * 10) / 100);
    $biayaPengiriman = intval(($subtotal * 2) / 100);
    $totalBayar = $subtotal + $biayaAdmin + $biayaPengiriman;
    $statusTransaksiadmin = $request->metode_pembayaran === 'cod' ? 'proses' : 'selesai';

    if ($request->metode_pembayaran === 'transfer') {
        if (empty($request->jumlah_uang) || (int)$request->jumlah_uang !== $totalBayar) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah uang harus sama dengan total pembayaran: ' . number_format($totalBayar, 0, ',', '.'),
            ]);
        }
    }

    DB::beginTransaction();

    try {
        $transaksiId = DB::table('transaksis')->insertGetId([
            'user_id' => $userId,
            'alamat_id' => $request->alamat_id,
            'kode_transaksi' => strtoupper('TRX-' . Str::random(8)),
            'metode_pembayaran' => $request->metode_pembayaran,
            'subtotal' => $subtotal,
            'biaya_admin_desa_persen' => $biayaAdmin,
            'biaya_pengiriman' => $biayaPengiriman,
            'total_setelah_biaya' => $totalBayar,
            'jumlah_uang' => $request->jumlah_uang,
            'status_transaksi' => $statusTransaksiadmin,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $groupedByToko = $cartItems->groupBy('toko_id');

        // Hitung total per toko terlebih dahulu
        $totalPerToko = [];
        foreach ($groupedByToko as $tokoId => $items) {
            $subtotalToko = 0;
            foreach ($items as $item) {
                $subtotalToko += $item->harga_produk * $item->quantity;
            }
            $adminToko = intval(($subtotalToko * 10) / 100);
            $ongkirToko = intval(($subtotalToko * 2) / 100);
            $totalPerToko[$tokoId] = $subtotalToko + $adminToko + $ongkirToko;
        }

        $totalSeluruhToko = array_sum($totalPerToko);

        foreach ($groupedByToko as $tokoId => $items) {
            $subtotalToko = 0;
            foreach ($items as $item) {
                $subtotalToko += $item->harga_produk * $item->quantity;
            }

            $adminToko = intval(($subtotalToko * 10) / 100);
            $ongkirToko = intval(($subtotalToko * 2) / 100);
            $totalToko = $subtotalToko + $adminToko + $ongkirToko;

            // Bagi jumlah uang per toko berdasarkan proporsi total toko
            $uang_bayar_toko = $request->metode_pembayaran === 'transfer'
                ? intval(($totalToko / $totalSeluruhToko) * $request->jumlah_uang)
                : null;

            $statusTransaksi = $request->metode_pembayaran === 'cod' ? 'proses' : 'selesai';

            $transaksiTokoId = DB::table('transaksi_tokos')->insertGetId([
                'transaksi_id' => $transaksiId,
                'toko_id' => $tokoId,
                'subtotal' => $subtotalToko,
                'biaya_admin_desa_persen' => $adminToko,
                'biaya_pengiriman' => $ongkirToko,
                'total_setelah_biaya' => $totalToko,
                'jumlah_uang' => $uang_bayar_toko,
                'status_pengiriman' => 'proses',
                'status_transaksi' => $statusTransaksi,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($items as $item) {
                $itemSubtotal = $item->harga_produk * $item->quantity;
                $itemAdmin = intval($itemSubtotal * 10 / 100);
                $itemOngkir = intval($itemSubtotal * 2 / 100);
                $itemTotal = $itemSubtotal + $itemAdmin + $itemOngkir;

                DB::table('transaksi_produks')->insert([
                    'transaksi_toko_id' => $transaksiTokoId,
                    'nama_produk' => $item->nama_produk,
                    'qty' => $item->quantity,
                    'harga_satuan' => $item->harga_produk,
                    'subtotal_produk' => $itemSubtotal,
                    'biaya_admin_desa_persen' => $itemAdmin,
                    'biaya_pengiriman' => $itemOngkir,
                    'total_setelah_biaya' => $itemTotal,
                    'catatan' => $request->catatan[$item->cart_id] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        foreach ($cartItems as $item) {
            DB::table('produks')
                ->where('id', $item->produk_id)
                ->decrement('stok_produk', $item->quantity);
        }

        DB::table('carts')->whereIn('id', $request->cart_ids)->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibuat.',
            'redirect_url' => url('/'),
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat transaksi: ' . $e->getMessage(),
        ]);
    }
}

public function show($id)
{
    $user = auth()->user();

    // Cek role
    $role = DB::table('role_user')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->where('role_user.user_id', $user->id)
        ->select('roles.name')
        ->first();

    $roleName = optional($role)->name;

    // Ambil transaksi utama
    $transaksi = DB::table('transaksis')
        ->join('users', 'users.id', '=', 'transaksis.user_id')
        ->join('alamats', 'alamats.id', '=', 'transaksis.alamat_id')
        ->select(
            'transaksis.*',
            'users.name as nama_user',
            'alamats.nama_alamat',
            'alamats.nama_penerima',
            'alamats.no_hp',
            'alamats.alamat_lengkap'
        )
        ->where('transaksis.id', $id)
        ->first();

    if (!$transaksi) {
        return abort(404, 'Transaksi tidak ditemukan.');
    }

    // Ambil data transaksi toko
    if ($roleName === 'toko') {
        // User toko: hanya lihat transaksinya sendiri
        $tokoId = DB::table('tokos')->where('pemilik_toko_id', $user->id)->value('id');

        $transaksiTokos = DB::table('transaksi_tokos')
            ->join('tokos', 'tokos.id', '=', 'transaksi_tokos.toko_id')
            ->where('transaksi_tokos.transaksi_id', $id)
            ->where('transaksi_tokos.toko_id', $tokoId)
            ->select('transaksi_tokos.*', 'tokos.nama_toko')
            ->get();

        if ($transaksiTokos->isEmpty()) {
            return abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }
    } else {
        // Superadmin: ambil semua toko yang terlibat
        $transaksiTokos = DB::table('transaksi_tokos')
            ->join('tokos', 'tokos.id', '=', 'transaksi_tokos.toko_id')
            ->where('transaksi_tokos.transaksi_id', $id)
            ->select('transaksi_tokos.*', 'tokos.nama_toko')
            ->get();
    }

    // Tambahkan produk-produknya
    foreach ($transaksiTokos as $toko) {
        $produk = DB::table('transaksi_produks')
            ->where('transaksi_toko_id', $toko->id)
            ->get();
        $toko->produks = $produk;
    }

    return view('backend.manajementtransaksi.transaksi.show', compact('transaksi', 'transaksiTokos', 'roleName'));
}
public function show_pengiriman($id)
{
    $transaksiToko = DB::table('transaksis')
        ->join('users', 'transaksis.user_id', '=', 'users.id')
        ->join('alamats', 'transaksis.alamat_id', '=', 'alamats.id')
        ->join('transaksi_tokos','transaksis.id','=','transaksi_tokos.transaksi_id')
        ->join('tokos', 'transaksi_tokos.toko_id', '=', 'tokos.id')
        ->select(
            'transaksis.*',
            'transaksi_tokos.id as transaksi_toko_id',
            'transaksi_tokos.status_pengiriman',
            'transaksi_tokos.status_transaksi',
            'transaksi_tokos.subtotal',
            'transaksi_tokos.biaya_admin_desa_persen',
            'transaksi_tokos.biaya_pengiriman',
            'transaksi_tokos.total_setelah_biaya',
            'transaksi_tokos.jumlah_uang',
            'users.name as nama_user',
            'tokos.nama_toko',
            'alamats.nama_alamat',
            'alamats.nama_penerima',
            'alamats.no_hp',
            'alamats.alamat_lengkap',
        )
        ->where('transaksi_tokos.id', $id)
        ->first();

    // Ambil semua produk berdasarkan transaksi_toko_id
    $produks = DB::table('transaksi_produks')
        ->where('transaksi_toko_id', $id)
        ->get();

    return view('backend.manajementtransaksi.pengiriman.show', compact('transaksiToko', 'produks'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
