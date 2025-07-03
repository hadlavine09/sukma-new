<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\KategoriProduk;
use App\Models\kategori_toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $user = auth()->user(); // Ambil user yang sedang login

    // Ambil role user
    $role = DB::table('role_user')
        ->where('user_id', $user->id)
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->select('roles.*')
        ->first();

    if ($request->ajax()) {
        // Ambil data kategori produk
        $kategori = KategoriProduk::all();

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) {
                return \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i'); // Format waktu
            })
            ->addColumn('action', function ($data) use ($role) {
                $btn = '
                    <a href="' . route('kategori_produk.show', $data->kode_kategori_produk) . '" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> Show
                    </a>
                ';
                // Tampilkan tombol hapus jika bukan role toko (id != 2)
                if ($role->id != 2) {
                    $btn .= '
                     <a href="' . route('kategori_produk.edit', $data->kode_kategori_produk) . '" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn"
                            data-id="' . $data->kode_kategori_produk . '"
                            data-nm="' . $data->nama_kategori_produk . '">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    ';
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('backend.manajementproduk.kategori_produk.index',compact('role'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriTokos = kategori_toko::all();
        return view('backend.manajementproduk.kategori_produk.create',compact('kategoriTokos'));
    }

public function store(Request $request)
{
    // Validasi input dari form
    $request->validate([
        'nama_kategori_produk' => 'required|string|max:255|unique:kategori_produks,nama_kategori_produk',
        'deskripsi_kategori_produk' => 'required|string|min:10',
        'kategori_toko_id' => 'required|exists:kategori_tokos,id',
        'gambar_kategori_produk' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'nama_kategori_produk.required' => 'Nama kategori wajib diisi.',
        'nama_kategori_produk.unique' => 'Nama kategori sudah ada.',
        'deskripsi_kategori_produk.required' => 'Deskripsi wajib diisi.',
        'deskripsi_kategori_produk.min' => 'Deskripsi minimal 10 karakter.',
        'kategori_toko_id.required' => 'Kategori toko wajib dipilih.',
        'kategori_toko_id.exists' => 'Kategori toko tidak valid.',
        'gambar_kategori_produk.required' => 'Gambar kategori wajib diunggah.',
        'gambar_kategori_produk.image' => 'File harus berupa gambar.',
        'gambar_kategori_produk.mimes' => 'Gambar harus bertipe JPG, JPEG, atau PNG.',
        'gambar_kategori_produk.max' => 'Ukuran gambar maksimal 2MB.',
    ]);

    DB::beginTransaction(); // Mulai transaksi DB

    try {
        $folder = 'kategori_produk';

        // Cek apakah folder 'kategori_produk' ada di storage/public, kalau tidak buat
        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }

        // Upload file gambar ke folder kategori_produk
        $gambarPath = $request->file('gambar_kategori_produk')->store($folder, 'public');

        // Ambil kode terakhir dari kategori
        $lastKategori = KategoriProduk::orderBy('kode_kategori_produk', 'desc')->first();
        $lastKode = $lastKategori ? $lastKategori->kode_kategori_produk : 'KTP000';

        // Ambil angka dari kode terakhir
        $lastNumber = (int) substr($lastKode, 3);
        $newKode = 'KTP' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Simpan data ke database
        KategoriProduk::create([
            'kode_kategori_produk' => $newKode,
            'nama_kategori_produk' => $request->nama_kategori_produk,
            'deskripsi_kategori_produk' => $request->deskripsi_kategori_produk,
            'gambar_kategori_produk' => $gambarPath,
            'kategori_toko_id' => $request->kategori_toko_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::commit(); // Sukses simpan

        return redirect()->route('kategori_produk.index')->with('success', 'Kategori berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack(); // Gagal simpan, rollback

        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}



public function show($kode_kategori_produk)
{
    // Ambil data kategori berdasarkan kode_kategori_produk dan relasi kategori toko
    $kategori = KategoriProduk::with('kategoriToko')  // Pastikan relasi sudah ada di model
        ->where('kode_kategori_produk', $kode_kategori_produk)
        ->first();

    // Validasi: jika data tidak ditemukan
    if (!$kategori) {
        return redirect()->route('kategori_produk.index')->with('error', 'Kategori Produk tidak ditemukan.');
    }

    // Tampilkan halaman detail
    return view('backend.manajementproduk.kategori_produk.show', compact('kategori'));
}

    public function edit($kode_kategori_produk)
    {
        // Mengambil data kategori berdasarkan kode_kategori_produk
        $kategori = KategoriProduk::where('kode_kategori_produk', $kode_kategori_produk)->first();
        $kategoriTokos = kategori_toko::all();

        // Validasi jika kategori tidak ditemukan
        if (!$kategori) {
            return redirect()->route('kategori_produk.index')->with('error', 'Kategori tidak ditemukan.');
        }

        // Menampilkan form edit dengan membawa data kategori yang ingin diedit
        return view('backend.manajementproduk.kategori_produk.edit', compact('kategori','kategoriTokos'));
    }

    public function update(Request $request, $kode_kategori_produk)
{
    // Ambil data kategori berdasarkan kode
    $kategori = KategoriProduk::where('kode_kategori_produk', $kode_kategori_produk)->first();

    if (!$kategori) {
        return redirect()->route('kategori_produk.index')->with('error', 'Kategori tidak ditemukan.');
    }

    // Validasi input
    $request->validate([
        'nama_kategori_produk' => 'required|string|max:255|unique:kategori_produks,nama_kategori_produk,' . $kategori->id,
        'deskripsi_kategori_produk' => 'required|string|min:10',
        'gambar_kategori_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'nama_kategori_produk.required' => 'Nama kategori wajib diisi.',
        'nama_kategori_produk.unique' => 'Nama kategori sudah digunakan.',
        'deskripsi_kategori_produk.required' => 'Deskripsi wajib diisi.',
        'deskripsi_kategori_produk.min' => 'Deskripsi minimal 10 karakter.',
        'gambar_kategori_produk.image' => 'File harus berupa gambar.',
        'gambar_kategori_produk.mimes' => 'Gambar harus JPG, JPEG, atau PNG.',
        'gambar_kategori_produk.max' => 'Ukuran gambar maksimal 2MB.',
    ]);

    DB::beginTransaction();

    try {
        // Default: gunakan gambar lama
        $gambarPath = $kategori->gambar_kategori_produk;

        // Jika user upload gambar baru
        if ($request->hasFile('gambar_kategori_produk')) {
            $folder = 'kategori_produk';

            // Buat folder jika belum ada
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }

            // Hapus gambar lama jika ada
            if ($kategori->gambar_kategori_produk && Storage::disk('public')->exists($kategori->gambar_kategori_produk)) {
                Storage::disk('public')->delete($kategori->gambar_kategori_produk);
            }

            // Simpan gambar baru
            $gambarPath = $request->file('gambar_kategori_produk')->store($folder, 'public');
        }

        // Update data ke database
        $kategori->update([
            'nama_kategori_produk' => $request->nama_kategori_produk,
            'deskripsi_kategori_produk' => $request->deskripsi_kategori_produk,
            'gambar_kategori_produk' => $gambarPath,
            'updated_at' => now(),
        ]);

        DB::commit();
        return redirect()->route('kategori_produk.index')->with('success', 'Kategori berhasil diperbarui!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $kode_kategori_produk = $request->kode_kategori_produk; // Mendapatkan kode_kategori_produk dari request

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Cari kategori berdasarkan kode_kategori_produk
            $cek_kategori_produk = DB::connection('pgsql')->table('kategori_produks')->where('kode_kategori_produk', $kode_kategori_produk)->first();

            // Validasi: jika kategori tidak ditemukan, return error
            if (!$cek_kategori_produk) {
                return redirect()->route('kategori_produk.index')->with('error', 'Kategori tidak ditemukan.');
            }

            // Hapus kategori dari database
            DB::connection('pgsql')->table('kategori_produks')->where('kode_kategori_produk', $kode_kategori_produk)->delete();

            // Commit transaksi jika tidak ada error
            DB::commit();

            // Return success response
            return redirect()->route('kategori_produk.index')->with('success', 'Kategori berhasil dihapus.');

        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            // Return error response
            return redirect()->route('kategori_produk.index')->with('error', 'Terjadi kesalahan dalam menghapus kategori_produk.');
        }
    }
 public function detail_kategori_toko($nama_kategori_toko)
{
    // Mengambil kode kategori dari query string
    $kode_kategori_toko = request()->query('kategori');

    // Memastikan kode kategori ada
    if (!$kode_kategori_toko) {
        abort(404, 'Kode Kategori Toko tidak ditemukan');
    }

    // Mengambil data kategori toko berdasarkan kode
    $kategori_toko = kategori_toko::where('kode_kategori_toko', $kode_kategori_toko)->firstOrFail();

    // Mengambil produk yang terkait dengan kategori toko ini
    $sub_kategori = KategoriProduk::where('kategori_toko_id', $kategori_toko->id)->get();
    // dd($sub_kategori);
    // Mengirim data kategori_toko dan sub_kategori ke view
    return view('frontend.detail_kategori_toko', compact('kategori_toko', 'sub_kategori'));
}
public function detail_kategori_produk($nama_kategori_toko, $nama_kategori_produk)
{
    $kode_kategori_toko = request()->query('kode_toko');
    $kode_kategori_produk = request()->query('kode_produk');

    $kategori_toko = kategori_toko::where('kode_kategori_toko', $kode_kategori_toko)->firstOrFail();
    $kategori_produk = KategoriProduk::where('kode_kategori_produk', $kode_kategori_produk)->firstOrFail();

    // Ambil sub-kategori (jika ada struktur parent-child)
    $sub_kategori = KategoriProduk::where('id', $kategori_produk->id)->get();

    return view('frontend.detail_kategori_produk', compact('kategori_produk', 'kategori_toko', 'sub_kategori'));
}




}
