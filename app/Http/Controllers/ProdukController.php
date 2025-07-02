<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data produk
            $produk = Produk::all(); // Bisa diganti dengan query yang lebih kompleks, misalnya dengan filter atau pagination

            return DataTables::of($produk)
                ->addIndexColumn()
                ->editColumn('harga_produk', function ($data) {
                    return 'Rp ' . number_format($data->harga_produk, 2, ',', '.'); // Format harga
                })
                ->editColumn('created_at', function ($data) {
                    return \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i'); // Format waktu
                })
                ->addColumn('action', function ($data) {
                    // Tombol untuk Show, Edit dan Hapus
                    return '
                        <a href="' . route('produk.show', $data->kode_produk) . '" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Show
                        </a>
                        <a href="' . route('produk.edit', $data->kode_produk) . '" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="' . $data->kode_produk . '" data-nm="' . $data->nama_produk . '">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    ';
                })
                ->rawColumns(['action']) // Menandai kolom 'action' sebagai raw HTML untuk menghindari escaping
                ->make(true);  // DataTables JSON response
        }
        // $produk = Produk::all(); // Bisa diganti dengan query yang lebih kompleks, misalnya dengan filter atau pagination
        // dd($produk);

        // Mengirim data produk untuk tampilan normal jika tidak menggunakan AJAX
        return view('backend.manajementproduk.produk.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = KategoriProduk::getSemuaKategori();
        return view('backend.manajementproduk.produk.create',compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Start a database transaction
    DB::beginTransaction();

    try {
        // Helper: Redirect with rollback and error
        $redirectWithError = function ($message) use ($request) {
            DB::rollBack();
            return redirect()->back()->with('error', $message)->withInput();
        };

        // Cek duplikasi nama produk
        $existingNama = DB::connection('pgsql')->table('produks')
            ->where('nama_produk', $request->nama_produk)
            ->exists();
        if ($existingNama) {
            return $redirectWithError('Nama Produk "' . $request->nama_produk . '" sudah ada di database.');
        }

        // Validasi deskripsi
        if (empty($request->deskripsi_produk) || strlen($request->deskripsi_produk) < 10) {
            return $redirectWithError('Deskripsi harus diisi dan minimal 10 karakter.');
        }

        // Validasi stok dan harga
        if (!is_numeric($request->stok_produk) || $request->stok_produk < 1) {
            return $redirectWithError('Stok produk tidak boleh kosong atau kurang dari 1.');
        }

        if (!is_numeric($request->harga_produk) || $request->harga_produk < 1) {
            return $redirectWithError('Harga produk tidak boleh kosong atau kurang dari 1.');
        }

        // Validasi gambar
        if (!$request->hasFile('gambar_produk')) {
            return $redirectWithError('Gambar produk wajib diunggah.');
        }

        $ext = $request->file('gambar_produk')->extension();
        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            return $redirectWithError('File gambar harus berupa JPG, JPEG, atau PNG.');
        }

        // Validasi kategori
        $kategoriAda = DB::connection('pgsql')->table('kategoris')
            ->where('kode_kategori', $request->kode_kategori)
            ->exists();
        if (!$kategoriAda) {
            return $redirectWithError('Kategori tidak ditemukan.');
        }

        // Validasi tags
        foreach ($request->tags as $tag) {
            $cekTag = DB::connection('pgsql')->table('tags')
                ->where('kode_tag', $tag)
                ->exists();
            if (!$cekTag) {
                return $redirectWithError('Tag "' . $tag . '" tidak ditemukan.');
            }
        }

        // // Validasi status produk
        // $status = $request->status_produk;
        // if (!in_array($status, ['Aktif', 'Tidak Aktif'])) {
        //     return $redirectWithError('Status produk wajib dipilih dan hanya boleh "Aktif" atau "Tidak Aktif".');
        // }

        // Generate kode produk
        $kode_produk = 'PRD-' . strtoupper(uniqid());

        // Upload gambar
        if (!Storage::disk('public')->exists('produk')) {
            Storage::disk('public')->makeDirectory('produk');
        }

        $gambar = $request->file('gambar_produk')->store('produk', 'public');

        // Simpan produk
        $save_produk = Produk::create([
            'kode_produk'      => $kode_produk,
            'nama_produk'      => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'stok_produk'      => $request->stok_produk,
            'harga_produk'     => $request->harga_produk,
            'gambar_produk'    => $gambar,
            'kode_kategori'    => $request->kode_kategori,
            // 'status_produk'    => $status,
        ]);

        // Simpan tag produk
        foreach ($request->tags as $tag) {
            DB::table('tag_produks')->insert([
                'kode_tag'    => $tag,
                'kode_produk' => $save_produk->kode_produk,
            ]);
        }

        // Commit transaksi
        DB::commit();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage())
            ->withInput();
    }
}




    /**
     * Display the specified resource.
     */
    public function show($kode_produk)
    {
        // Get the product and related category
        $produk = DB::table('produks')
            ->join('kategoris', 'produks.kode_kategori', '=', 'kategoris.kode_kategori')
            ->leftJoin('tag_produks', 'produks.kode_produk', '=', 'tag_produks.kode_produk')
            ->leftJoin('tags', 'tag_produks.kode_tag', '=', 'tags.kode_tag')
            ->where('produks.kode_produk', $kode_produk)
            ->select('produks.*', 'kategoris.nama_kategori', 'tags.nama_tag') // Select product, category, and tag name
            ->get();

        // Check if the product exists
        if ($produk->isEmpty()) {
            return redirect()->back()->with('error', 'Data produk tidak ditemukan.');
        }

        // Get the first product's details (there will only be one product since we are filtering by 'kode_produk')
        $produkDetail = $produk->first(); // Get the first product

        // Group the tags associated with the product
        $tags = $produk->pluck('nama_tag')->toArray(); // Pluck all the tags' names

        // Pass the product and tags to the view
        return view('backend.manajementproduk.produk.show', compact('produkDetail', 'tags'));
    }






    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_produk)
    {
        // Ambil data produk berdasarkan kode_produk
        $produk = DB::table('produks')->where('kode_produk', $kode_produk)->first();

        // Validasi: jika data produk tidak ditemukan
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk dengan kode ini tidak ditemukan.');
        }

        // Ambil semua kategori
        $kategori = Kategori::all();

        // Ambil tags yang terkait dengan produk ini
        $tags = DB::table('tag_produks')
                    ->join('tags', 'tag_produks.kode_tag', '=', 'tags.kode_tag')
                    ->where('tag_produks.kode_produk', $kode_produk)
                    ->pluck('tags.kode_tag')->toArray(); // Fetch associated tags

        // Ambil semua tags yang tersedia
        $allTags = Tag::all();

        // Tampilkan view edit dengan membawa data produk, kategori, tags yang ada, dan semua tags
        return view('backend.manajementproduk.produk.edit', compact('produk', 'kategori', 'tags', 'allTags'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_produk)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Cek apakah produk dengan kode_produk ada
            $produk = Produk::where('kode_produk', $kode_produk)->first();

            if (!$produk) {
                throw new \Exception('Produk tidak ditemukan.');
            }

            // Cek duplikasi nama produk (kecuali produk itu sendiri)
            $existingNama = DB::connection('pgsql')->table('produks')
                ->where('nama_produk', $request->nama_produk)
                ->where('kode_produk', '!=', $kode_produk)  // pastikan tidak memeriksa produk itu sendiri
                ->exists();

            if ($existingNama) {
                throw new \Exception('Nama Produk "' . $request->nama_produk . '" sudah ada di database.');
            }

            // Validasi deskripsi
            if (empty($request->deskripsi_produk) || strlen($request->deskripsi_produk) < 10) {
                throw new \Exception('Deskripsi harus diisi dan minimal 10 karakter.');
            }

            // Validasi stok (minimal 1)
            if (!is_numeric($request->stok_produk) || $request->stok_produk < 1) {
                throw new \Exception('Stok produk tidak boleh kosong atau kurang dari 1.');
            }

            // Validasi harga (minimal 1)
            if (!is_numeric($request->harga_produk) || $request->harga_produk < 1) {
                throw new \Exception('Harga produk tidak boleh kosong atau kurang dari 1.');
            }

            // Validasi kategori
            $kategoriAda = DB::connection('pgsql')->table('kategoris')
                ->where('kode_kategori', $request->kode_kategori)
                ->exists();

            if (!$kategoriAda) {
                throw new \Exception('Kategori tidak ditemukan.');
            }

            // Validasi status produk
            $status = $request->status_produk;
            if (empty($status) || !in_array($status, ['Aktif', 'Tidak Aktif'])) {
                throw new \Exception('Status produk wajib dipilih dan hanya boleh "Aktif" atau "Tidak Aktif".');
            }

            // Cek dan buat folder jika belum ada
            if ($request->hasFile('gambar_produk')) {
                // Validasi gambar
                $ext = $request->file('gambar_produk')->extension();
                $allowed = ['jpg', 'jpeg', 'png'];
                if (!in_array($ext, $allowed)) {
                    throw new \Exception('File gambar harus berupa JPG, JPEG, atau PNG.');
                }

                // Jika gambar diunggah, simpan gambar ke folder produk
                if (!Storage::disk('public')->exists('produk')) {
                    Storage::disk('public')->makeDirectory('produk');
                }

                $gambar = $request->file('gambar_produk')->store('produk', 'public');
                $produk->gambar_produk = $gambar; // Update gambar produk
            }

            // Validasi dan update tags
            if ($request->has('tags') && is_array($request->tags)) {
                foreach ($request->tags as $tag) {
                    // Validasi apakah tag ada di database
                    $cekTag = DB::connection('pgsql')->table('tags')
                        ->where('kode_tag', $tag)
                        ->exists();

                    if (!$cekTag) {
                        throw new \Exception('Tag "' . $tag . '" tidak ditemukan.');
                    }
                }

                // Menghapus hubungan lama dan menambahkan tag baru
                DB::connection('pgsql')->table('tag_produks')
                    ->where('kode_produk', $kode_produk)  // Hapus hubungan lama
                    ->delete();

                // Menambahkan tag baru ke tag_produks
                foreach ($request->tags as $tag) {
                    DB::connection('pgsql')->table('tag_produks')->insert([
                        'kode_produk' => $kode_produk,
                        'kode_tag'    => $tag,
                    ]);
                }
            }

            // Update produk
            $produk->update([
                'nama_produk'       => $request->nama_produk,
                'deskripsi_produk'  => $request->deskripsi_produk,
                'stok_produk'       => $request->stok_produk,
                'harga_produk'      => $request->harga_produk,
                'kode_kategori'     => $request->kode_kategori,
                'status_produk'     => $status,
            ]);

            DB::commit();  // Commit the transaction if everything was successful
            return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();  // Rollback the transaction if any exception occurs
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function destroy(Request $request)
    {
        $kode_produk = $request->kode_produk; // Mendapatkan kode_produk dari request

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Cari produk berdasarkan kode_produk
            $cek_produk = DB::connection('pgsql')->table('produks')->where('kode_produk', $kode_produk)->first();

            // Validasi: jika produk tidak ditemukan, return error
            if (!$cek_produk) {
                return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
            }

            // Hapus gambar produk dari penyimpanan jika ada
            if ($cek_produk->gambar_produk) {
                $gambarPath = storage_path('app/public/' . $cek_produk->gambar_produk);
                if (file_exists($gambarPath)) {
                    unlink($gambarPath); // Hapus gambar dari penyimpanan
                }
            }

            // Hapus produk dari database
            DB::connection('pgsql')->table('produks')->where('kode_produk', $kode_produk)->delete();

            // Commit transaksi jika tidak ada error
            DB::commit();

            // Return success response
            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');

        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            // Return error response
            return redirect()->route('produk.index')->with('error', 'Terjadi kesalahan dalam menghapus produk.');
        }
    }

public function GetKeranjangFrontEnd(Request $request)
{
    $lastSentData = null;

    $response = new StreamedResponse(function () use (&$lastSentData) {
        while (true) {
            try {
                // Ambil data keranjang user yang sedang login
                $keranjangData = DB::table('carts')
                    ->join('produks', 'carts.kode_produk', '=', 'produks.kode_produk')
                    ->leftJoin('kategoris', 'produks.kode_kategori', '=', 'kategoris.kode_kategori')
                    ->where('carts.user_id', Auth::id())
                    ->whereNull('carts.deleted_at')
                    ->select(
                        'carts.id',
                        'carts.kode_produk',
                        'carts.quantity',
                        'carts.harga_produk',
                        'produks.nama_produk',
                        'produks.gambar_produk',
                        'produks.stok_produk',
                        'produks.kode_kategori',
                        'kategoris.nama_kategori'
                    )
                    ->get();

                $cartResult = $keranjangData->toArray();

                // Cek apakah data berubah dari sebelumnya
                if ($lastSentData && json_encode($lastSentData) === json_encode($cartResult)) {
                    sleep(2); // Tidak ada perubahan, tunggu
                    continue;
                }

                // Jika berubah, kirim ke client
                echo "data: " . json_encode([
                    'status' => 'success',
                    'cart' => $cartResult
                ]) . "\n\n";

                $lastSentData = $cartResult;

                ob_flush();
                flush();

            } catch (\Exception $e) {
                echo "data: " . json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]) . "\n\n";

                ob_flush();
                flush();
            }

            sleep(2); // Polling setiap 2 detik
        }
    });

    // Header SSE
    $response->headers->set('Content-Type', 'text/event-stream');
    $response->headers->set('Cache-Control', 'no-cache');
    $response->headers->set('Connection', 'keep-alive');

    return $response;
}

public function GetTagFrontEnd(Request $request)
{
    $lastSentData = null;

    $response = new StreamedResponse(function () use (&$lastSentData) {
        while (true) {
            try {
                // Ambil semua data tag yang belum dihapus (soft delete)
                $tagData = DB::table('tags')
                    ->whereNull('deleted_at')
                    ->select('kode_tag', 'nama_tag', 'gambar_tag', 'deskripsi_tag')
                    ->orderBy('id', 'desc')
                    ->get();

                $tagResult = $tagData->toArray();

                // Bandingkan data sekarang dengan data terakhir
                if ($lastSentData && json_encode($lastSentData) === json_encode($tagResult)) {
                    sleep(1);
                    continue;
                }

                // Kirim data baru jika berbeda
                echo "data: " . json_encode([
                    'status' => 'success',
                    'tag' => $tagResult,
                ]) . "\n\n";

                $lastSentData = $tagResult;

                ob_flush();
                flush();

            } catch (\Exception $e) {
                echo "data: " . json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]) . "\n\n";

                ob_flush();
                flush();
            }

            sleep(1); // polling setiap 1 detik
        }
    });

    // Header SSE
    $response->headers->set('Content-Type', 'text/event-stream');
    $response->headers->set('Cache-Control', 'no-cache');
    $response->headers->set('Connection', 'keep-alive');

    return $response;
}



public function GetKategoriFrontEnd(Request $request)
{
    $lastSentData = null;

    $response = new StreamedResponse(function () use (&$lastSentData) {
        while (true) {
            try {
                // Ambil semua data kategori terbaru
                $kategoriData = DB::table('kategoris')
                    ->orderBy('id', 'desc')
                    ->get();

                $kategoriResult = $kategoriData->toArray(); // convert ke array biasa

                // Bandingkan data sekarang dengan data terakhir
                if ($lastSentData && json_encode($lastSentData) === json_encode($kategoriResult)) {
                    sleep(1);
                    continue;
                }

                // Kirim data baru jika berbeda
                echo "data: " . json_encode([
                    'status' => 'success',
                    'kategori' => $kategoriResult,
                ]) . "\n\n";

                $lastSentData = $kategoriResult;

                ob_flush();
                flush();

            } catch (\Exception $e) {
                echo "data: " . json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]) . "\n\n";

                ob_flush();
                flush();
            }

            sleep(1); // polling setiap 1 detik
        }
    });

    // Header SSE
    $response->headers->set('Content-Type', 'text/event-stream');
    $response->headers->set('Cache-Control', 'no-cache');
    $response->headers->set('Connection', 'keep-alive');

    return $response;
}
public function GetProdukDetailKategoriFrontEnd(Request $request)
{
    $kodeKategori = $request->query('kode_kategori', null);
    $lastSentData = null;

    // Validasi kode_kategori wajib diisi
    if (!$kodeKategori) {
        return response()->json([
            'status' => 'error',
            'message' => 'Parameter kode_kategori wajib diisi.'
        ]);
    }

    $response = new StreamedResponse(function () use (&$lastSentData, $kodeKategori) {
        while (true) {
            try {
                // Ambil data produk + tags
                $produkWithTagsRaw = DB::table('produks')
                    ->leftJoin('tag_produks', 'produks.kode_produk', '=', 'tag_produks.kode_produk')
                    ->leftJoin('tags', 'tag_produks.kode_tag', '=', 'tags.kode_tag')
                    ->select('produks.*', 'tags.nama_tag')
                    ->where('produks.kode_kategori', $kodeKategori)
                    // ->where('produks.status_produk', 'publik')
                    ->orderBy('produks.id', 'desc')
                    ->get();

                // Gabungkan tag dalam array per produk
                $produkGrouped = [];
                foreach ($produkWithTagsRaw as $item) {
                    $kode = $item->kode_produk;

                    if (!isset($produkGrouped[$kode])) {
                        $produkGrouped[$kode] = (array) $item;
                        $produkGrouped[$kode]['tags'] = [];
                    }

                    if (!is_null($item->nama_tag)) {
                        $produkGrouped[$kode]['tags'][] = $item->nama_tag;
                    }
                }

                $produkResult = array_values($produkGrouped); // reset indeks array

                // Bandingkan dengan data terakhir
                if ($lastSentData && json_encode($lastSentData) === json_encode($produkResult)) {
                    sleep(1);
                    continue;
                }

                // Kirim data baru jika berubah
                echo "data: " . json_encode([
                    'status' => 'success',
                    'produk' => $produkResult,
                ]) . "\n\n";

                $lastSentData = $produkResult;

                ob_flush();
                flush();
            } catch (\Exception $e) {
                echo "data: " . json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]) . "\n\n";

                ob_flush();
                flush();
            }

            sleep(1); // jeda 1 detik
        }
    });

    // Header SSE
    $response->headers->set('Content-Type', 'text/event-stream');
    $response->headers->set('Cache-Control', 'no-cache');
    $response->headers->set('Connection', 'keep-alive');

    return $response;
}

public function GetProdukFrontEnd(Request $request)
{
    $lastSentData = null;

    $response = new StreamedResponse(function () use (&$lastSentData) {
        while (true) {
            try {
                // Ambil data produk beserta tag (left join)
                $produkWithTagsRaw = DB::table('produks')
                    ->leftJoin('tag_produks', 'produks.kode_produk', '=', 'tag_produks.kode_produk')
                    ->leftJoin('tags', 'tag_produks.kode_tag', '=', 'tags.kode_tag')
                    ->select('produks.*', 'tags.nama_tag')
                    ->orderBy('produks.id', 'desc')
                    ->get();

                // Gabungkan tag dalam array per produk
                $produkGrouped = [];
                foreach ($produkWithTagsRaw as $item) {
                    $kode = $item->kode_produk;

                    if (!isset($produkGrouped[$kode])) {
                        $produkGrouped[$kode] = (array) $item;
                        $produkGrouped[$kode]['tags'] = [];
                    }

                    if (!is_null($item->nama_tag)) {
                        $produkGrouped[$kode]['tags'][] = $item->nama_tag;
                    }
                }

                $produkResult = array_values($produkGrouped); // pastikan array indeks

                // Bandingkan data sekarang dengan yang terakhir dikirim
                if ($lastSentData && json_encode($lastSentData) === json_encode($produkResult)) {
                    sleep(1);
                    continue;
                }

                // Kirim data baru jika ada perubahan
                echo "data: " . json_encode([
                    'status' => 'success',
                    'produk' => $produkResult,
                ]) . "\n\n";

                // Simpan data terakhir untuk perbandingan
                $lastSentData = $produkResult;

                ob_flush();
                flush();

            } catch (\Exception $e) {
                // Kirim pesan error jika terjadi kesalahan
                echo "data: " . json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]) . "\n\n";

                ob_flush();
                flush();
            }

            sleep(1); // jeda polling 1 detik
        }
    });

    // Set header SSE
    $response->headers->set('Content-Type', 'text/event-stream');
    $response->headers->set('Cache-Control', 'no-cache');
    $response->headers->set('Connection', 'keep-alive');

    return $response;
}

public function GetDetailProdukFrontEnd($kode_produk = "PRD002")
{
    // Ambil data produk utama
    $produk = DB::table('produks')
        ->leftJoin('kategoris', 'produks.kode_kategori', '=', 'kategoris.kode_kategori')
        ->where('produks.kode_produk', $kode_produk)
        ->select(
            'produks.*',
            'kategoris.nama_kategori'
        )
        ->first();

    if (!$produk) {
        return response()->json([
            'status' => 'error',
            'message' => 'Produk tidak ditemukan.',
        ], 404);
    }

    // Ambil tag produk
    $tags = DB::table('tag_produks')
        ->join('tags', 'tag_produks.kode_tag', '=', 'tags.kode_tag')
        ->where('tag_produks.kode_produk', $kode_produk)
        ->pluck('tags.nama_tag');

    // Gabungkan hasil
    $produkDetail = (array) $produk;
    $produkDetail['tags'] = $tags;

    return response()->json([
        'status' => 'success',
        'data' => $produkDetail,
    ]);
}
public function AddToCartFrontEnd(Request $request)
{
    $kode_produk = $request->kode_produk;
    $qty = $request->qty ?? 1;

    // Ambil produk dari database
    $produk = DB::table('produks')
        ->where('kode_produk', $kode_produk)
        ->select('kode_produk', 'nama_produk', 'harga_produk', 'gambar_produk', 'stok_produk')
        ->first();

    if (!$produk) {
        return response()->json([
            'status' => 'error',
            'message' => 'Produk tidak ditemukan.',
        ], 404);
    }

    // Ambil cart dari session, jika belum ada inisialisasi array kosong
    $cart = session()->get('cart', []);

    // Jika produk sudah ada di keranjang, tambah qty-nya
    if (isset($cart[$kode_produk])) {
        $cart[$kode_produk]['qty'] += $qty;
    } else {
        // Jika belum ada, tambahkan produk ke cart
        $cart[$kode_produk] = [
            'kode_produk' => $produk->kode_produk,
            'nama_produk' => $produk->nama_produk,
            'harga_produk' => $produk->harga_produk,
            'gambar_produk' => $produk->gambar_produk,
            'qty' => $qty,
        ];
    }

    // Simpan kembali ke session
    session()->put('cart', $cart);

    return response()->json([
        'status' => 'success',
        'message' => 'Produk berhasil ditambahkan ke keranjang.',
        'cart' => $cart,
    ]);
}



}
