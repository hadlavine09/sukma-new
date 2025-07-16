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
    if ($request->ajax()) {
        $loginId = Auth::id();

        // Ambil toko milik user login
        $toko = DB::table('tokos')->where('pemilik_toko_id', $loginId)->first();

        if (!$toko) {
            return response()->json(['data' => []]);
        }

        // Ambil semua ID produk milik toko ini
        $produkIds = DB::table('produks')
            ->where('toko_id', $toko->id)
            ->pluck('id')
            ->toArray();

        // Ambil semua transaksi
        $allTransaksi = DB::table('transaksis')->orderByDesc('created_at')->get();

        // Filter transaksi yang memiliki produk_id milik toko ini
        $filtered = $allTransaksi->filter(function ($transaksi) use ($produkIds) {
            $produkJson = json_decode($transaksi->produk, true);

            if (!is_array($produkJson)) return false;

            foreach ($produkJson as $item) {
                if (in_array($item['produk_id'], $produkIds)) {
                    return true;
                }
            }

            return false;
        });

        return DataTables::of($filtered)
            ->addIndexColumn()
            ->editColumn('total_bayar', function ($data) {
                return 'Rp ' . number_format($data->total_bayar, 2, ',', '.');
            })
            ->editColumn('metode_pembayaran', function ($data) {
                return strtoupper($data->metode_pembayaran);
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d M Y, H:i');
            })
            ->addColumn('action', function ($data) {
                return '
                    <a href="' . route('transaksi.show', $data->id) . '" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('backend.manajementtransaksi.transaksi.index');
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
        'jumlah_uang' => 'nullable|integer|min:1', // validasi manual di bawah
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

    // Cek stok
    foreach ($cartItems as $item) {
        if ($item->quantity > $item->stok_produk) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak cukup untuk produk: ' . $item->nama_produk,
            ]);
        }
    }

    // Hitung total
    $subtotal = 0;
    foreach ($cartItems as $item) {
        $subtotal += $item->harga_produk * $item->quantity;
    }

    $biayaAdmin = intval(($subtotal * 10) / 100);
    $biayaPengiriman = intval(($subtotal * 2) / 100);
    $totalBayar = $subtotal + $biayaAdmin + $biayaPengiriman;

    // Validasi uang hanya untuk transfer
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
        // Simpan transaksi utama
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
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kelompokkan produk per toko
        $groupedByToko = $cartItems->groupBy('toko_id');

        foreach ($groupedByToko as $tokoId => $items) {
            $subtotalToko = 0;
            foreach ($items as $item) {
                $subtotalToko += $item->harga_produk * $item->quantity;
            }

            $adminToko = intval(($subtotalToko * 10) / 100);
            $ongkirToko = intval(($subtotalToko * 2) / 100);
            $totalToko = $subtotalToko + $adminToko + $ongkirToko;
            $statusTransaksi = $request->metode_pembayaran === 'cod' ? 'proses' : 'selesai';

            // Simpan transaksi toko
            $transaksiTokoId = DB::table('transaksi_tokos')->insertGetId([
                'transaksi_id' => $transaksiId,
                'toko_id' => $tokoId,
                'subtotal' => $subtotalToko,
                'biaya_admin_desa_persen' => $adminToko,
                'biaya_pengiriman' => $ongkirToko,
                'total_setelah_biaya' => $totalToko,
                'jumlah_uang' => $request->jumlah_uang,
                'status_pengiriman' => $statusTransaksi,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan produk per transaksi
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

        // Kurangi stok
        foreach ($cartItems as $item) {
            DB::table('produks')
                ->where('id', $item->produk_id)
                ->decrement('stok_produk', $item->quantity);
        }

        // Hapus isi cart
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
    // Ambil data transaksi lengkap
    $transaksi = DB::table('transaksis')
        ->where('id', $id)
        ->first();

    if (!$transaksi) {
        return redirect()->route('transaksi.index')->with('error', 'Transaksi tidak ditemukan.');
    }

    // Ambil data user
    $user = DB::table('users')->where('id', $transaksi->user_id)->first();

    // Ambil data alamat pengiriman
    $alamat = DB::table('alamats')->where('id', $transaksi->alamat_id)->first();

    // Decode produk dari JSON
    $produkItems = json_decode($transaksi->produk, true) ?: [];
    $produkDetails = [];
    $totalProduk = 0;

    foreach ($produkItems as $item) {
        if (!isset($item['produk_id'])) continue;

        $produk = DB::table('produks')->where('id', $item['produk_id'])->first();
        if (!$produk) continue;

        $harga = $item['harga'] ?? 0;
        $jumlah = $item['jumlah'] ?? ($item['qty'] ?? 0);
        $subtotal = $harga * $jumlah;
        $totalProduk += $subtotal;

        $produkDetails[] = [
            'produk_id' => $produk->id,
            'nama'      => $produk->nama_produk,
            'harga'     => $harga,
            'jumlah'    => $jumlah,
            'subtotal'  => $subtotal,
            'foto'      => $produk->foto_url ?? null, // kolom ini harus tersedia
        ];
    }

    // Tambahan untuk view
    $transaksi->user = $user;
    $transaksi->alamat = $alamat;
    $transaksi->total_produk = $totalProduk;

    return view('backend.manajementtransaksi.transaksi.show', compact('transaksi', 'produkDetails'));
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
