<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Toko;
use App\Models\kategori_toko;
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
            // Ambil data
                    $login = Auth::user()->id;
        $toko = DB::table('tokos')->where('pemilik_toko_id', $login)->first();
            $produk = Produk::where('toko_id',$toko->id); // Bisa diganti dengan query yang lebih kompleks, misalnya dengan filter atau pagination

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
        $login = Auth::user()->id;
        $toko = DB::table('tokos')->where('pemilik_toko_id', $login)->first();
        $kategori = DB::table('kategori_produks')->where('kategori_toko_id',$toko->kategori_toko_id)->get();
        return view('backend.manajementproduk.produk.create',compact('kategori'));
    }
   public function tagkategori(Request $request)
    {
        $kategori_id = $request->input('kategori_id');

        // Validasi apakah kategori ada
        $cek_kategori = KategoriProduk::where('id',$kategori_id);

        if (!$cek_kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }
        // Ambil data tag yang terkait dengan kategori
        $tags = DB::table('tags')
            ->where('tags.kategori_produk_id', $kategori_id)
            ->join('kategori_produks', 'tags.kategori_produk_id', '=', 'kategori_produks.id')
            ->select('tags.*', 'kategori_produks.nama_kategori_produk')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data tag berhasil diambil.',
            'data' => $tags
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    DB::beginTransaction();

    try {
        $redirectWithError = function ($message) {
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

        $gambarFile = $request->file('gambar_produk');
        $mime = $gambarFile->getMimeType();

        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/jpg'])) {
            return $redirectWithError('File gambar harus berupa JPG, JPEG, atau PNG.');
        }
        // Validasi kategori (kategori_id dari form)
        $kategoriAda = DB::connection('pgsql')->table('kategori_produks')
            ->where('id', $request->kategori_id)
            ->exists();
        if (!$kategoriAda) {
            return $redirectWithError('Kategori tidak ditemukan.');
        }

        // Validasi tags (kode_tag dari form, array)
        if (!is_array($request->kode_tag)) {
            return $redirectWithError('Tag harus berupa array.');
        }

        foreach ($request->kode_tag as $tag) {
            $cekTag = DB::connection('pgsql')->table('tags')
                ->where('id', $tag)
                ->exists();
            if (!$cekTag) {
                return $redirectWithError('Tag "' . $tag . '" tidak ditemukan.');
            }
        }

        // Generate kode produk
        // Ambil produk terakhir berdasarkan kode
        $lastProduk = Produk::orderBy('kode_produk', 'desc')->first();

        // Jika belum ada produk, mulai dari PRD000
        $lastKode = $lastProduk ? $lastProduk->kode_produk : 'PRD000';

        // Ambil angka dari kode terakhir, contoh PRD007 → 7
        $lastNumber = (int) substr($lastKode, 3);

        // Tambahkan 1 untuk kode baru
        $newNumber = $lastNumber + 1;

        // Buat kode baru dengan format PRD diikuti angka 3 digit
        $kode_produk = 'PRD' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Upload gambar
        if (!Storage::disk('public')->exists('produk')) {
            Storage::disk('public')->makeDirectory('produk');
        }

        $gambarPath = $gambarFile->store('produk', 'public');

        // Ambil ID user yang login
        $user_login = Auth::id();

        // Ambil data toko berdasarkan pemilik
        $toko = Toko::where('pemilik_toko_id', $user_login)->first();

        if (!$toko) {
            return redirect()->back()->with('error', 'Toko milik pengguna tidak ditemukan.');
        }
        // Simpan produk
        $save_produk = Produk::create([
            'kode_produk'      => $kode_produk,
            'nama_produk'      => $request->nama_produk,
            'toko_id'          => $toko->id,
            'deskripsi_produk' => $request->deskripsi_produk,
            'stok_produk'      => $request->stok_produk,
            'harga_produk'     => $request->harga_produk,
            'gambar_produk'    => $gambarPath,
            'kategori_produk_id'  => $request->kategori_id, // di sini ganti ke 'kategori_id'
        ]);

        // Simpan relasi tag
        foreach ($request->kode_tag as $tag) {
            DB::table('tag_produks')->insert([
                'tag_id'    => $tag,
                'produk_id' => $save_produk->id,
            ]);
        }

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
 public function show($id)
{
    // Ambil detail produk berdasarkan kode_produk
    $produk = DB::table('produks')
        ->join('kategori_produks', 'produks.kategori_produk_id', '=', 'kategori_produks.id')
        ->leftJoin('tag_produks', 'produks.id', '=', 'tag_produks.produk_id')
        ->leftJoin('tags', 'tag_produks.tag_id', '=', 'tags.id')
        ->where('produks.kode_produk', $id)
        ->select(
            'produks.*',
            'kategori_produks.nama_kategori_produk as nama_kategori',
            'tags.nama_tag'
        )
        ->get();

    // Cek apakah produk ditemukan
    if ($produk->isEmpty()) {
        return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
    }

    // Ambil data produk utama
    $produkDetail = $produk->first();

    // Ambil semua nama tag
    $tags = $produk->pluck('nama_tag')->filter()->unique()->values()->toArray();

    // Kirim ke view
    return view('backend.manajementproduk.produk.show', compact('produkDetail', 'tags'));
}

public function edit($kode_produk)
{
    // Ambil data produk berdasarkan kode_produk
    $produk = Produk::where('kode_produk', $kode_produk)->first();

    if (!$produk) {
        return redirect()->back()->with('error', 'Produk dengan kode ini tidak ditemukan.');
    }

    // Ambil semua kategori
    $kategori = DB::table('kategori_produks')->get();

    // Ambil tag ID yang sudah terkait
    $tags = DB::table('tag_produks')
        ->where('produk_id', $produk->id)
        ->pluck('tag_id')
        ->toArray();

    // Ambil semua tag
    $allTags = DB::table('tags')->get();

    return view('backend.manajementproduk.produk.edit', compact('produk', 'kategori', 'tags', 'allTags'));
}




public function update(Request $request, $kode_produk)
{
    DB::beginTransaction();

    try {
        $produk = Produk::where('kode_produk', $kode_produk)->first();

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Validasi input manual
        if (empty($request->deskripsi_produk) || strlen($request->deskripsi_produk) < 10) {
            return redirect()->back()->with('error', 'Deskripsi harus diisi dan minimal 10 karakter.')->withInput();
        }
        if (!is_numeric($request->stok_produk) || $request->stok_produk < 1) {
            return redirect()->back()->with('error', 'Stok produk tidak boleh kosong atau kurang dari 1.')->withInput();
        }
        if (!is_numeric($request->harga_produk) || $request->harga_produk < 1) {
            return redirect()->back()->with('error', 'Harga produk tidak boleh kosong atau kurang dari 1.')->withInput();
        }

        // Validasi kategori
        $kategoriAda = DB::table('kategori_produks')->where('id', $request->kategori_id)->exists();
        if (!$kategoriAda) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.')->withInput();
        }

        // Validasi tags
        if (!is_array($request->kode_tag)) {
            return redirect()->back()->with('error', 'Tag harus berupa array.')->withInput();
        }

        foreach ($request->kode_tag as $tag) {
            $cekTag = Tag::where('id', $tag)->exists();
            if (!$cekTag) {
                return redirect()->back()->with('error', 'Tag dengan ID "' . $tag . '" tidak ditemukan.')->withInput();
            }
        }

        // Jika user upload gambar baru
        if ($request->hasFile('gambar_produk')) {
            $gambarFile = $request->file('gambar_produk');
            $mime = $gambarFile->getMimeType();

            if (!in_array($mime, ['image/jpeg', 'image/png', 'image/jpg'])) {
                return redirect()->back()->with('error', 'File gambar harus berupa JPG, JPEG, atau PNG.')->withInput();
            }

            // Hapus gambar lama
            if ($produk->gambar_produk && Storage::disk('public')->exists($produk->gambar_produk)) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }

            // Upload gambar baru
            $gambarPath = $gambarFile->store('produk', 'public');
            $produk->gambar_produk = $gambarPath;
        }

        // Update data produk
        $produk->nama_produk = $request->nama_produk;
        $produk->deskripsi_produk = $request->deskripsi_produk;
        $produk->stok_produk = $request->stok_produk;
        $produk->harga_produk = $request->harga_produk;
        $produk->kategori_produk_id = $request->kategori_id;
        $produk->save();

        // Update relasi tag
        DB::table('tag_produks')->where('produk_id', $produk->id)->delete();
        foreach ($request->kode_tag as $tagId) {
            DB::table('tag_produks')->insert([
                'produk_id' => $produk->id,
                'tag_id' => $tagId,
            ]);
        }

        DB::commit();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())->withInput();
    }
}


public function destroy(Request $request)
{
    $kode_produk = $request->kode_produk;

    DB::beginTransaction();

    try {
        // Ambil data produk
        $produk = DB::table('produks')->where('kode_produk', $kode_produk)->first();

        if (!$produk) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
        }

        // Hapus gambar dari storage jika ada
        if ($produk->gambar_produk && Storage::disk('public')->exists($produk->gambar_produk)) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }

        // Hapus semua relasi dari tabel tag_produks
        DB::table('tag_produks')->where('produk_id', $produk->id)->delete();

        // Hapus data produk
        DB::table('produks')->where('kode_produk', $kode_produk)->delete();

        DB::commit();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('produk.index')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
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



public function GetKategoriTokoFrontEnd(Request $request)
{
    $lastSentData = null;

    $response = new StreamedResponse(function () use (&$lastSentData) {
        while (true) {
            try {
                // Ambil semua data kategori terbaru
                $kategoriData  = kategori_toko::orderBy('id', 'asc')
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


// public function GetKategoriProdukFrontEnd(Request $request)
// {
//     $lastSentData = null;

//     $response = new StreamedResponse(function () use (&$lastSentData) {
//         while (true) {
//             try {
//                 // Ambil semua data kategori terbaru
//                 $kategoriData  = KategoriProduk::orderBy('id', 'asc')
//                     ->get();

//                 $kategoriResult = $kategoriData->toArray(); // convert ke array biasa

//                 // Bandingkan data sekarang dengan data terakhir
//                 if ($lastSentData && json_encode($lastSentData) === json_encode($kategoriResult)) {
//                     sleep(1);
//                     continue;
//                 }

//                 // Kirim data baru jika berbeda
//                 echo "data: " . json_encode([
//                     'status' => 'success',
//                     'kategori' => $kategoriResult,
//                 ]) . "\n\n";

//                 $lastSentData = $kategoriResult;

//                 ob_flush();
//                 flush();

//             } catch (\Exception $e) {
//                 echo "data: " . json_encode([
//                     'status' => 'error',
//                     'message' => $e->getMessage(),
//                 ]) . "\n\n";

//                 ob_flush();
//                 flush();
//             }

//             sleep(1); // polling setiap 1 detik
//         }
//     });

//     // Header SSE
//     $response->headers->set('Content-Type', 'text/event-stream');
//     $response->headers->set('Cache-Control', 'no-cache');
//     $response->headers->set('Connection', 'keep-alive');

//     return $response;
// }
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
    try {
        // Ambil data produk beserta tag (left join)
        $produkWithTagsRaw = DB::table('produks')
            ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
            ->join('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
            ->leftJoin('kategori_produks', 'produks.kategori_produk_id', '=', 'kategori_produks.id')
            ->leftJoin('tag_produks', 'produks.id', '=', 'tag_produks.produk_id')
            ->leftJoin('tags', 'tag_produks.tag_id', '=', 'tags.id')
            ->select(
                'produks.id',
                'produks.kode_produk',
                'produks.nama_produk',
                'produks.deskripsi_produk',
                'produks.stok_produk',
                'produks.harga_produk',
                'produks.gambar_produk',
                'produks.kategori_produk_id',
                'produks.toko_id',
                'produks.status_produk',
                'produks.status_draf_produk',
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
            ->orderBy('produks.id', 'desc')
            ->get();

        // Grouping produk dan tags
        $produkGrouped = [];

        foreach ($produkWithTagsRaw as $item) {
            $kode = $item->kode_produk;

            if (!isset($produkGrouped[$kode])) {
                $produkGrouped[$kode] = [
                    'id' => $item->id,
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
                        'id' => $item->kategori_produk_id,
                        'nama_kategori_toko' => $item->nama_kategori_toko,
                        'deskripsi_kategori_toko' => $item->deskripsi_kategori_toko,
                    ],
                    'kategori_produk' => [
                        'nama_kategori_produk' => $item->nama_kategori_produk,
                        'deskripsi_kategori_produk' => $item->deskripsi_kategori_produk,
                    ],
                    'tags' => []
                ];
            }

            if (!is_null($item->tag_id)) {
                $produkGrouped[$kode]['tags'][] = [
                    'id' => $item->tag_id,
                    'nama_tag' => $item->nama_tag,
                    'deskripsi_tag' => $item->deskripsi_tag,
                ];
            }
        }

        $produkResult = array_values($produkGrouped);

        // Kirim respons biasa (bukan SSE)
        return response()->json([
            'status' => 'success',
            'produk' => $produkResult,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}

// public function GetProdukFrontEnd(Request $request)
// {
//     $lastSentData = null;

//     $response = new StreamedResponse(function () use (&$lastSentData) {
//         // Loop terus menerus untuk SSE
//         while (true) {
//             try {
//                 // Ambil data produk beserta tag (left join)
//                 $produkWithTagsRaw = DB::table('produks')
//                     ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
//                     ->join('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
//                     ->leftJoin('kategori_produks', 'produks.kategori_produk_id', '=', 'kategori_produks.id') // pastikan relasi benar
//                     ->leftJoin('tag_produks', 'produks.id', '=', 'tag_produks.produk_id')
//                     ->leftJoin('tags', 'tag_produks.tag_id', '=', 'tags.id')
//                     ->select(
//                         'produks.id',
//                         'produks.kode_produk',
//                         'produks.nama_produk',
//                         'produks.deskripsi_produk',
//                         'produks.stok_produk',
//                         'produks.harga_produk',
//                         'produks.gambar_produk',
//                         'produks.kategori_produk_id',
//                         'produks.toko_id',
//                         'produks.status_produk',
//                         'produks.status_draf_produk',
//                         'tokos.nama_toko',
//                         'tokos.deskripsi_toko',
//                         'kategori_tokos.nama_kategori_toko',
//                         'kategori_tokos.deskripsi_kategori_toko',
//                         'kategori_produks.nama_kategori_produk',
//                         'kategori_produks.deskripsi_kategori_produk',
//                         'tags.id as tag_id',
//                         'tags.nama_tag',
//                         'tags.deskripsi_tag'
//                     )
//                     ->orderBy('produks.id', 'desc')
//                     ->get();

//                 // Grouping produk dan tags
//                 $produkGrouped = [];

//                 foreach ($produkWithTagsRaw as $item) {
//                     $kode = $item->kode_produk;

//                     if (!isset($produkGrouped[$kode])) {
//                         $produkGrouped[$kode] = [
//                             'id' => $item->id,
//                             'kode_produk' => $item->kode_produk,
//                             'nama_produk' => $item->nama_produk,
//                             'deskripsi_produk' => $item->deskripsi_produk,
//                             'stok_produk' => $item->stok_produk,
//                             'harga_produk' => $item->harga_produk,
//                             'gambar_produk' => $item->gambar_produk,
//                             'status_produk' => $item->status_produk,
//                             'status_draf_produk' => $item->status_draf_produk,
//                             'kategori_produk_id' => $item->kategori_produk_id,
//                             'toko' => [
//                                 'id' => $item->toko_id,
//                                 'nama_toko' => $item->nama_toko,
//                                 'deskripsi_toko' => $item->deskripsi_toko,
//                             ],
//                             'kategori_toko' => [
//                                 'id' => $item->kategori_produk_id,
//                                 'nama_kategori_toko' => $item->nama_kategori_toko,
//                                 'deskripsi_kategori_toko' => $item->deskripsi_kategori_toko,
//                             ],
//                             'kategori_produk' => [
//                                 'nama_kategori_produk' => $item->nama_kategori_produk,
//                                 'deskripsi_kategori_produk' => $item->deskripsi_kategori_produk,
//                             ],
//                             'tags' => []
//                         ];
//                     }

//                     if (!is_null($item->tag_id)) {
//                         $produkGrouped[$kode]['tags'][] = [
//                             'id' => $item->tag_id,
//                             'nama_tag' => $item->nama_tag,
//                             'deskripsi_tag' => $item->deskripsi_tag,
//                         ];
//                     }
//                 }

//                 $produkResult = array_values($produkGrouped);

//                 // Bandingkan data sebelumnya dengan data sekarang
//                 // Gunakan hash untuk performa lebih baik
//                 $currentHash = md5(json_encode($produkResult));
//                 $lastHash = $lastSentData ? md5(json_encode($lastSentData)) : null;

//                 if ($currentHash === $lastHash) {
//                     // Tidak ada perubahan, tunggu dan lanjutkan
//                     sleep(1);
//                     continue;
//                 }

//                 // Kirim data terbaru dengan format SSE
//                 echo "data: " . json_encode([
//                     'status' => 'success',
//                     'produk' => $produkResult,
//                 ]) . "\n\n";

//                 // Simpan data terakhir
//                 $lastSentData = $produkResult;

//                 ob_flush();
//                 flush();

//             } catch (\Exception $e) {
//                 // Kirim error message
//                 echo "data: " . json_encode([
//                     'status' => 'error',
//                     'message' => $e->getMessage(),
//                 ]) . "\n\n";

//                 ob_flush();
//                 flush();
//             }

//             sleep(1);
//         }
//     });

//     // Header SSE
//     $response->headers->set('Content-Type', 'text/event-stream');
//     $response->headers->set('Cache-Control', 'no-cache');
//     $response->headers->set('Connection', 'keep-alive');

//     return $response;

// }

public function GetSreachProdukFrontEnd(Request $request)
{
    // $produkWithTagsRaw = DB::table('produks')
    //     ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
    //     ->join('kategori_tokos', 'produks.kategori_produk_id', '=', 'kategori_tokos.id')
    //     ->leftJoin('kategori_produks', 'produks.kategori_produk_id', '=', 'kategori_produks.id') // diasumsikan relasi
    //     ->leftJoin('tag_produks', 'produks.id', '=', 'tag_produks.produk_id')
    //     ->leftJoin('tags', 'tag_produks.tag_id', '=', 'tags.id')
    //     ->select(
    //         'produks.id',
    //         'produks.kode_produk',
    //         'produks.nama_produk',
    //         'produks.deskripsi_produk',
    //         'produks.stok_produk',
    //         'produks.harga_produk',
    //         'produks.gambar_produk',
    //         'produks.kategori_produk_id',
    //         'produks.toko_id',
    //         'produks.status_produk',
    //         'produks.status_draf_produk',
    //         'tokos.nama_toko',
    //         'tokos.deskripsi_toko',
    //         'kategori_tokos.nama_kategori_toko',
    //         'kategori_tokos.deskripsi_kategori_toko',
    //         'kategori_produks.nama_kategori_produk',
    //         'kategori_produks.deskripsi_kategori_produk',
    //         'tags.id as tag_id',
    //         'tags.nama_tag',
    //         'tags.deskripsi_tag'
    //     )
    //     ->orderBy('produks.id', 'desc')
    //     ->get();

    // $produkGrouped = [];

    // foreach ($produkWithTagsRaw as $item) {
    //     $kode = $item->kode_produk;

    //     if (!isset($produkGrouped[$kode])) {
    //         $produkGrouped[$kode] = [
    //             'id' => $item->id,
    //             'kode_produk' => $item->kode_produk,
    //             'nama_produk' => $item->nama_produk,
    //             'deskripsi_produk' => $item->deskripsi_produk,
    //             'stok_produk' => $item->stok_produk,
    //             'harga_produk' => $item->harga_produk,
    //             'gambar_produk' => $item->gambar_produk,
    //             'status_produk' => $item->status_produk,
    //             'status_draf_produk' => $item->status_draf_produk,
    //             'toko' => [
    //                 'id' => $item->toko_id,
    //                 'nama_toko' => $item->nama_toko,
    //                 'deskripsi_toko' => $item->deskripsi_toko,
    //             ],
    //             'kategori_toko' => [
    //                 'id' => $item->kategori_produk_id,
    //                 'nama_kategori_toko' => $item->nama_kategori_toko,
    //                 'deskripsi_kategori_toko' => $item->deskripsi_kategori_toko,
    //             ],
    //             'kategori_produk' => [
    //                 'nama_kategori_produk' => $item->nama_kategori_produk,
    //                 'deskripsi_kategori_produk' => $item->deskripsi_kategori_produk,
    //             ],
    //             'tags' => []
    //         ];
    //     }

    //     if (!is_null($item->tag_id)) {
    //         $produkGrouped[$kode]['tags'][] = [
    //             'id' => $item->tag_id,
    //             'nama_tag' => $item->nama_tag,
    //             'deskripsi_tag' => $item->deskripsi_tag,
    //         ];
    //     }
    // }

    // return response()->json([
    //     'status' => 'success',
    //     'data' => array_values($produkGrouped)
    // ]);
 $produkWithTagsRaw = DB::table('produks')
                    ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
                    ->join('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
                    ->leftJoin('kategori_produks', 'produks.kategori_produk_id', '=', 'kategori_produks.id') // pastikan relasi benar
                    ->leftJoin('tag_produks', 'produks.id', '=', 'tag_produks.produk_id')
                    ->leftJoin('tags', 'tag_produks.tag_id', '=', 'tags.id')
                    ->select(
                        'produks.id',
                        'produks.kode_produk',
                        'produks.nama_produk',
                        'produks.deskripsi_produk',
                        'produks.stok_produk',
                        'produks.harga_produk',
                        'produks.gambar_produk',
                        'produks.kategori_produk_id',
                        'produks.toko_id',
                        'produks.status_produk',
                        'produks.status_draf_produk',
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
                    ->orderBy('produks.id', 'desc')
                    ->get();

                // Grouping produk dan tags
                $produkGrouped = [];

                foreach ($produkWithTagsRaw as $item) {
                    $kode = $item->kode_produk;

                    if (!isset($produkGrouped[$kode])) {
                        $produkGrouped[$kode] = [
                            'id' => $item->id,
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
                                'id' => $item->kategori_produk_id,
                                'nama_kategori_toko' => $item->nama_kategori_toko,
                                'deskripsi_kategori_toko' => $item->deskripsi_kategori_toko,
                            ],
                            'kategori_produk' => [
                                'nama_kategori_produk' => $item->nama_kategori_produk,
                                'deskripsi_kategori_produk' => $item->deskripsi_kategori_produk,
                            ],
                            'tags' => []
                        ];
                    }

                    if (!is_null($item->tag_id)) {
                        $produkGrouped[$kode]['tags'][] = [
                            'id' => $item->tag_id,
                            'nama_tag' => $item->nama_tag,
                            'deskripsi_tag' => $item->deskripsi_tag,
                        ];
                    }
                }

                $produkResult = array_values($produkGrouped);
                return $produkResult;
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
