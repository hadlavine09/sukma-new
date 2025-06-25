<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data tag
            $tag = Tag::getSemuaTag();

            return DataTables::of($tag)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i'); // Format waktu
                })
                ->addColumn('action', function ($data) {
                    // Tombol untuk Show, Edit dan Hapus
                    return '
                        <a href="' . route('tag.show', $data->kode_tag) . '" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Show
                        </a>
                        <a href="' . route('tag.edit', $data->kode_tag) . '" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="' . $data->kode_tag . '" data-nm="' . $data->nama_tag . '">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    ';
                })
                ->rawColumns(['action']) // Menandai kolom 'action' sebagai raw HTML untuk menghindari escaping
                ->make(true);  // DataTables JSON response
        }
        return view('backend.manajementproduk.tag.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.manajementproduk.tag.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            // Validasi jika nama tag sudah ada di database
            $existingnama_tag = DB::connection('pgsql')->table('tags')
                ->where('nama_tag', $request->nama_tag)
                ->exists();

            if ($existingnama_tag) {
                // Rollback transaksi jika tag sudah ada
                DB::rollBack();
                return redirect()->back()->with('error', 'Nama tag "' . $request->nama_tag . '" sudah ada di database.')->withInput();
            }

            // Validasi: Cek jika deskripsi tag tidak kosong dan memiliki panjang minimal
            if (empty($request->deskripsi_tag) || strlen($request->deskripsi_tag) < 10) {
                // Rollback transaksi jika deskripsi tidak valid
                DB::rollBack();
                return redirect()->back()->with('error', 'Deskripsi harus diisi dan lebih dari 10 karakter.')->withInput();
            }

            // Validasi gambar
            if (!$request->hasFile('gambar_tag')) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Gambar produk wajib diunggah.')
                    ->withInput();
            } else {
                $ext = $request->file('gambar_tag')->extension();
                $allowed = ['jpg', 'jpeg', 'png'];
                if (!in_array($ext, $allowed)) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'File gambar harus berupa JPG, JPEG, atau PNG.')
                        ->withInput();
                }
            }

            // Cek & buat folder jika belum ada
            if (!Storage::disk('public')->exists('tag')) {
                Storage::disk('public')->makeDirectory('tag');
            }

            // Upload gambar
            $gambar = $request->file('gambar_tag')->store('tag', 'public');

            // Menentukan kode tag otomatis
            $lasttag = Tag::orderBy('kode_tag', 'desc')->first(); // Ambil tag terakhir
            $lastKode = $lasttag ? $lasttag->kode_tag : 'KT000'; // Jika tidak ada, mulai dari KT000

            // Ambil angka terakhir dari kode (setelah 'TG')
            $lastNumber = (int) substr($lastKode, 2); // Mengambil angka setelah 'TG' dan mengkonversinya ke integer
            $newNumber = $lastNumber + 1; // Menambahkan 1 ke angka terakhir

            // Membuat kode baru dengan format 'TG' diikuti angka 3 digit
            $newKode = 'TG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

            // Menyimpan tag baru
            Tag::create([
                'kode_tag' => $newKode,
                'nama_tag' => $request->nama_tag,
                'deskripsi_tag' => $request->deskripsi_tag,
                'gambar_tag' => $gambar,  // Simpan nama file gambar
                'created_at' => \Carbon\Carbon::now(), // Menetapkan created_at dengan waktu saat ini
            ]);

            // Commit transaksi jika semua operasi sukses
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('tag.index')->with('success', 'tag berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            // Tangani error dan tampilkan pesan
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }


    public function show($kode_tag)
    {
        // Ambil data tag berdasarkan kode_tag
        $tag = Tag::where('kode_tag', $kode_tag)->first();

        // Validasi: jika data tidak ditemukan
        if (!$tag) {
            return redirect()->back()->with('error', 'Data tag tidak ditemukan.');
        }

        // Tampilkan ke view
        return view('backend.manajementproduk.tag.show', compact('tag'));
    }
    public function edit($kode_tag)
    {
        // Mengambil data tag berdasarkan kode_tag
        $tag = Tag::where('kode_tag', $kode_tag)->first();

        // Validasi jika tag tidak ditemukan
        if (!$tag) {
            return redirect()->route('tag.index')->with('error', 'tag tidak ditemukan.');
        }

        // Menampilkan form edit dengan membawa data tag yang ingin diedit
        return view('backend.manajementproduk.tag.edit', compact('tag'));
    }

    public function update(Request $request, $kode_tag)
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            // Validasi jika nama tag sudah ada di database dan bukan tag yang sedang diedit
            $existingnama_tag = DB::connection('pgsql')->table('tags')
                ->where('nama_tag', $request->nama_tag)
                ->where('kode_tag', '!=', $kode_tag) // Menghindari tag yang sama
                ->exists();

            if ($existingnama_tag) {
                // Rollback transaksi jika tag sudah ada
                DB::rollBack();
                return redirect()->back()->with('error', 'Nama tag "' . $request->nama_tag . '" sudah ada di database.')->withInput();
            }

            // Validasi: Cek jika deskripsi tag tidak kosong dan memiliki panjang minimal
            if (empty($request->deskripsi_tag) || strlen($request->deskripsi_tag) < 10) {
                // Rollback transaksi jika deskripsi tidak valid
                DB::rollBack();
                return redirect()->back()->with('error', 'Deskripsi harus diisi dan lebih dari 10 karakter.')->withInput();
            }

            // Mencari tag berdasarkan kode_tag
            $tag = Tag::where('kode_tag', $kode_tag)->first();

            // Validasi jika tag tidak ditemukan
            if (!$tag) {
                DB::rollBack();
                return redirect()->route('tag.index')->with('error', 'Tag tidak ditemukan.');
            }

            // Jika ada gambar baru yang diunggah
            if ($request->hasFile('gambar_tag')) {
                // Validasi gambar
                $ext = $request->file('gambar_tag')->extension();
                $allowed = ['jpg', 'jpeg', 'png'];
                if (!in_array($ext, $allowed)) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'File gambar harus berupa JPG, JPEG, atau PNG.')
                        ->withInput();
                }

                // Cek & buat folder jika belum ada
                if (!Storage::disk('public')->exists('tag')) {
                    Storage::disk('public')->makeDirectory('tag');
                }

                // Hapus gambar lama jika ada
                if ($tag->gambar_tag && Storage::disk('public')->exists($tag->gambar_tag)) {
                    Storage::disk('public')->delete($tag->gambar_tag);
                }

                // Upload gambar baru
                $gambar = $request->file('gambar_tag')->store('tag', 'public');

                // Update gambar di database
                $tag->gambar_tag = $gambar;
            }

            // Update tag
            $tag->update([
                'nama_tag' => $request->nama_tag,
                'deskripsi_tag' => $request->deskripsi_tag,
                'updated_at' => \Carbon\Carbon::now(), // Menetapkan updated_at dengan waktu saat ini
            ]);

            // Commit transaksi jika semua operasi sukses
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('tag.index')->with('success', 'Tag berhasil diperbarui!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            // Tangani error dan tampilkan pesan
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $kode_tag = $request->kode_tag; // Mendapatkan kode_tag dari request

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Cari tag berdasarkan kode_tag
            $cek_tag = DB::connection('pgsql')->table('tags')->where('kode_tag', $kode_tag)->first();

            // Validasi: jika tag tidak ditemukan, return error
            if (!$cek_tag) {
                return redirect()->route('tag.index')->with('error', 'tag tidak ditemukan.');
            }

            // Hapus tag dari database
            DB::connection('pgsql')->table('tags')->where('kode_tag', $kode_tag)->delete();

            // Commit transaksi jika tidak ada error
            DB::commit();

            // Return success response
            return redirect()->route('tag.index')->with('success', 'tag berhasil dihapus.');

        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            // Return error response
            return redirect()->route('tag.index')->with('error', 'Terjadi kesalahan dalam menghapus tag.');
        }
    }
}
