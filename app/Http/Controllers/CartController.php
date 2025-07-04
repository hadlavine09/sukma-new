<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = DB::table('carts')->get();
        return view('backend.manajementtransaksi.cart.index', compact('carts'));
    }
    public function keranjang()
    {
        $keranjang = DB::table('carts')
            ->join('produks', 'carts.kode_produk', '=', 'produks.kode_produk')
            ->join('kategori_produks', 'produks.kategori_produk_id', '=', 'kategori_produks.id')
            ->where('carts.user_id', Auth::user()->id)
            ->select('carts.*', 'produks.nama_produk', 'produks.gambar_produk', 'produks.kategori_produk_id', 'kategori_produks.nama_kategori_produk')
            ->get();
        // dd($keranjang); // Hapus saat production
        return view('frontend.keranjang', compact('keranjang'));
    }
    public function keranjang_dropdown()
    {
        $keranjang = DB::table('carts')
            ->join('produks', 'carts.kode_produk', '=', 'produks.kode_produk')
            ->join('kategoris', 'produks.kode_kategori', '=', 'kategoris.kode_kategori')
            ->where('carts.user_id', Auth::user()->id)
            ->select('carts.*', 'produks.nama_produk', 'produks.gambar_produk', 'produks.kode_kategori', 'kategoris.nama_kategori')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $keranjang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();

        $produks = Produk::all();
        return view('backend.manajementtransaksi.cart.create', compact('produks', 'users'));
    }

public function prepareCheckout(Request $request)
{
    $ids = $request->input('ids'); // array id dari JS

    if (empty($ids) || !is_array($ids)) {
        return response()->json(['status' => 'error', 'message' => 'ID tidak valid'], 400);
    }

    // Buat kode acak 100 karakter (termasuk simbol, huruf besar kecil, angka)
    $kode = Str::random(70) . substr(md5(rand()), 0, 30); // Total 100 karakter

    // Simpan mapping di session
    session()->put('checkout_kode_' . $kode, $ids);

    return response()->json(['status' => 'success', 'redirect' => route('frontend.checkout', ['kode' => $kode])]);
}
 public function checkout($kode)
{
    $ids = session('checkout_kode_' . $kode);

    if (!$ids) {
        abort(404, 'Kode checkout tidak ditemukan atau sudah kadaluarsa.');
    }

    $user = auth()->user();

    // Ambil alamat list dari tabel 'alamats' berdasarkan user_id
    $alamatList = DB::table('alamats')
        ->where('user_id', $user->id)
        ->limit(5)
        ->get();

    // // Cek jika user sudah memiliki alamat
    // $alamatTersedia = $alamatList->isNotEmpty();

    // // Ambil semua voucher
    // $voucherList = DB::table('vouchers')->get();

    // // Ambil voucher yang dipilih dari session (jika ada)
    // $voucherTerpilih = collect($voucherList)->firstWhere('id', session('voucher_id'));

    // // Ambil produk dari keranjang

 // Ambil data produk beserta tag (left join)
       // Ambil produk dengan tag dan relasi lainnya
// 1️⃣ Ambil produk di keranjang user
  $produkWithTagsRaw = DB::table('carts')
        ->join('produks', 'carts.kode_produk', '=', 'produks.kode_produk')
        ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
        ->join('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
        ->leftJoin('kategori_produks', 'produks.kategori_produk_id', '=', 'kategori_produks.id')
        ->leftJoin('tag_produks', 'produks.id', '=', 'tag_produks.produk_id')
        ->leftJoin('tags', 'tag_produks.tag_id', '=', 'tags.id')
        ->select(
            'carts.id as cart_id',
            'carts.quantity',
            'carts.harga_produk as harga_di_cart',
            'produks.kode_produk',
            'produks.nama_produk',
            'produks.deskripsi_produk',
            'produks.stok_produk',
            'produks.harga_produk',
            'produks.gambar_produk',
            'produks.status_produk',
            'produks.status_draf_produk',
            'produks.kategori_produk_id',
            'produks.toko_id',
            'tokos.nama_toko',
            'tokos.deskripsi_toko',
            'kategori_tokos.nama_kategori_toko',
            'kategori_tokos.deskripsi_kategori_toko',
            'kategori_produks.nama_kategori_produk',
            'kategori_produks.deskripsi_kategori_produk',
            'tags.id as tag_id',
            'tags.nama_tag',
            'tags.deskripsi_tag'
        )
        ->where('carts.user_id', $user->id)
        ->whereIn('carts.id', $ids)
        ->orderBy('produks.id', 'desc')
        ->get();

    // Grouping by cart id
    $produkGrouped = [];
    foreach ($produkWithTagsRaw as $item) {
        $cartId = $item->cart_id;

        if (!isset($produkGrouped[$cartId])) {
            $produkGrouped[$cartId] = [
                'cart_id' => $cartId,
                'quantity' => $item->quantity,
                'harga_di_cart' => $item->harga_di_cart,
                'produk' => [
                    'kode_produk' => $item->kode_produk,
                    'nama_produk' => $item->nama_produk,
                    'deskripsi_produk' => $item->deskripsi_produk,
                    'stok_produk' => $item->stok_produk,
                    'harga_produk' => $item->harga_produk,
                    'gambar_produk' => $item->gambar_produk,
                    'status_produk' => $item->status_produk,
                    'status_draf_produk' => $item->status_draf_produk,
                    'kategori_produk_id' => $item->kategori_produk_id,
                    'toko' => [
                        'id' => $item->toko_id,
                        'nama_toko' => $item->nama_toko,
                        'deskripsi_toko' => $item->deskripsi_toko,
                    ],
                    'kategori_toko' => [
                        'nama_kategori_toko' => $item->nama_kategori_toko,
                        'deskripsi_kategori_toko' => $item->deskripsi_kategori_toko,
                    ],
                    'kategori_produk' => [
                        'nama_kategori_produk' => $item->nama_kategori_produk,
                        'deskripsi_kategori_produk' => $item->deskripsi_kategori_produk,
                    ],
                    'tags' => [],
                ]
            ];
        }

        // Tambahkan tag kalau ada
        if (!is_null($item->tag_id)) {
            $produkGrouped[$cartId]['produk']['tags'][] = [
                'id' => $item->tag_id,
                'nama_tag' => $item->nama_tag,
                'deskripsi_tag' => $item->deskripsi_tag,
            ];
        }
    }

    $produkResult = array_values($produkGrouped);

    // Hitung total
    $totalProduk = collect($produkResult)->sum(function ($item) {
        return $item['harga_di_cart'] * $item['quantity'];
    });
    $totalPotongan = $voucherTerpilih->potongan ?? 0;
    $totalBayar = $totalProduk - $totalPotongan;

//    dd([
//     'produk_grouped' => array_values($produkGrouped),
//     'total_produk' => $totalProduk,
//     'total_potongan' => $totalPotongan,
//     'total_bayar' => $totalBayar,
// ]);

    return view('frontend.checkout');
}



    // Fungsi untuk menyimpan alamat yang dipilih
    public function pilihAlamat(Request $request)
    {
        $request->validate([
            'alamat_terpilih' => 'required|string'
        ]);

        session(['alamat_terpilih' => $request->alamat_terpilih]);

        return redirect()->back();
    }

    // Fungsi untuk menyimpan voucher yang dipilih
    public function pilihVoucher(Request $request)
    {
        $request->validate([
            'voucher_id' => 'required|integer'
        ]);

        session(['voucher_id' => $request->voucher_id]);

        return redirect()->back();
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kode_produk' => 'required|exists:produks,kode_produk',
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil data produk
        $produk = DB::table('produks')->where('kode_produk', $request->kode_produk)->first();

        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        // Hitung total quantity saat ini jika sudah ada di cart
        $existing = DB::table('carts')->where('user_id', $request->user_id)->where('kode_produk', $request->kode_produk)->whereNull('deleted_at')->first();

        $totalQuantity = $request->quantity;
        if ($existing) {
            $totalQuantity += $existing->quantity;
        }

        if ($totalQuantity > $produk->stok_produk) {
            return back()->with('error', 'Jumlah melebihi stok produk. Stok tersedia: ' . $produk->stok_produk);
        }

        if ($existing) {
            // Update quantity
            DB::table('carts')
                ->where('id', $existing->id)
                ->update([
                    'quantity' => $existing->quantity + $request->quantity,
                    'updated_at' => now(),
                ]);
        } else {
            // Insert cart baru
            DB::table('carts')->insert([
                'user_id' => $request->user_id,
                'kode_produk' => $request->kode_produk,
                'quantity' => $request->quantity,
                'harga_produk' => $produk->harga_produk, // simpan harga saat ini
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke cart.');
    }
    public function simpanAlamat(Request $request)
{
    $request->validate([
        'nama' => 'required|string',
        'alamat' => 'required|string',
        'no_hp' => 'required|string'
    ]);

    // Simpan alamat baru
    DB::table('alamats')->insert([
        'user_id' => auth()->user()->id,
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp,
    ]);

    // Set session alamat_terpilih
    session(['alamat_terpilih' => $request->alamat]);

    return redirect()->route('checkout.index'); // Redirect ke halaman checkout
}

    public function tambahkeranjang(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|exists:produks,kode_produk',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $produk = DB::table('produks')->where('kode_produk', $request->kode_produk)->first();

            if (!$produk) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Produk tidak ditemukan.',
                    ],
                    404,
                );
            }

            $existing = DB::table('carts')->where('user_id', Auth::id())->where('kode_produk', $request->kode_produk)->whereNull('deleted_at')->first();

            $totalQuantity = $request->quantity;
            if ($existing) {
                $totalQuantity += $existing->quantity;
            }

            if ($totalQuantity > $produk->stok_produk) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Jumlah melebihi stok produk. Stok tersedia: ' . $produk->stok_produk,
                    ],
                    422,
                );
            }

            if ($existing) {
                DB::table('carts')
                    ->where('id', $existing->id)
                    ->update([
                        'quantity' => $totalQuantity,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('carts')->insert([
                    'user_id' => Auth::id(),
                    'kode_produk' => $request->kode_produk,
                    'quantity' => $request->quantity,
                    'harga_produk' => $produk->harga_produk,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Produk berhasil ditambahkan ke keranjang.',
                    'data' => [
                        'kode_produk' => $request->kode_produk,
                        'quantity' => $totalQuantity,
                    ],
                ],
                200,
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat menambahkan ke keranjang.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function checkoutStore(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array',
            'cart_ids.*' => 'exists:carts,id',
        ]);

        DB::beginTransaction();

        try {
            $cartIds = $request->input('cart_ids');
            $voucherId = $request->input('voucher_id');
            $kodeTransaksi = 'TRX-' . strtoupper(Str::random(10));

            // Ambil semua cart yang dipilih
            $carts = Cart::with(['produk', 'user'])
                ->whereIn('id', $cartIds)
                ->get();

            foreach ($carts as $cart) {
                Transaksi::create([
                    'kode_transaksi' => $kodeTransaksi,
                    'user_id' => $cart->user_id,
                    'kode_produk' => $cart->produk->kode_produk,
                    'quantity' => $cart->quantity,
                    'harga_produk' => $cart->produk->harga_produk,
                    'total_harga_produk' => $cart->produk->harga_produk * $cart->quantity,
                    'status' => 'proses',

                    // Ambil data dari relasi user
                    'nama' => $cart->user->name,
                    'alamat' => $cart->user->alamat ?? '',
                    'no_hp' => $cart->user->no_hp ?? '',
                    'catatan' => '', // Diisi jika ada form tambahan
                ]);
            }

            // Hapus cart yang sudah di-checkout
            Cart::whereIn('id', $cartIds)->delete();

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }
    public function cartupdate(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|integer|exists:carts,id', // Asumsikan tabel keranjang bernama carts
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $cartId = $request->input('id');
            $jumlah = $request->input('jumlah');

            // Ambil data keranjang sesuai ID
            $cart = DB::table('carts')->where('id', $cartId)->first();

            if (!$cart) {
                return response()->json(['error' => 'Item keranjang tidak ditemukan'], 404);
            }

            // Update quantity keranjang
            DB::table('carts')
                ->where('id', $cartId)
                ->where('user_id', Auth::user()->id)
                ->update([
                    'quantity' => $jumlah,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Quantity berhasil diperbarui']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Gagal mengupdate quantity: ' . $e->getMessage()], 500);
        }
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
    public function destroy(Request $request, $id)
    {
        // Cari data cart berdasarkan ID
        $cart = DB::table('carts')
            ->where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();

        // Jika data tidak ditemukan
        if (!$cart) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Data cart tidak ditemukan.'], 404);
            } else {
                return redirect()->back()->with('error', 'Data cart tidak ditemukan.');
            }
        }

        // Hapus data
        DB::table('carts')->where('id', $id)->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus dari keranjang.']);
        } else {
            return redirect()->route('frontend.keranjang')->with('success', 'Produk berhasil dihapus dari keranjang.');
        }
    }
}
