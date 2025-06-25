<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
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
    public function show(Transaksi $transaksi)
    {
        //
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
