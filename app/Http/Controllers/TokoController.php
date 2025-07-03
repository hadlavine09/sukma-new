<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Toko;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data toko
                $toko = DB::table('tokos')
                    ->join('users', 'tokos.pemilik_toko_id', '=', 'users.id')
                    ->leftJoin('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
                    ->join('izin_tokos', 'tokos.id', '=', 'izin_tokos.toko_id')
                    ->whereNull('tokos.deleted_at')
                    ->whereNull('kategori_tokos.deleted_at')
                    ->select('tokos.*', 'users.username as nama_pemilik', 'kategori_tokos.nama_kategori_toko')
                    ->get();
                return DataTables::of($toko)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    // Tombol untuk Show, Edit dan Hapus
                    return '
                        <a href="' . route('toko.show', $data->kode_toko) . '" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Show
                        </a>
                    ';
                })
                ->rawColumns(['action']) // Menandai kolom 'action' sebagai raw HTML untuk menghindari escaping
                ->make(true);            // DataTables JSON response
        }

        // Mengirim data toko untuk tampilan normal jika tidak menggunakan AJAX
        return view('backend.manajementtoko.toko.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.manajementtoko.toko.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            // Validasi jika nama kategori sudah ada di database
            $existingnama_kategori = DB::connection('pgsql')->table('kategoris')
                ->where('nama_kategori', $request->nama_kategori)
                ->exists();

            if ($existingnama_kategori) {
                // Rollback transaksi jika kategori sudah ada
                DB::rollBack();
                return redirect()->back()->with('error', 'Nama Kategori "' . $request->nama_kategori . '" sudah ada di database.')->withInput();
            }

            // Validasi: Cek jika deskripsi kategori tidak kosong dan memiliki panjang minimal
            if (empty($request->deskripsi_kategori) || strlen($request->deskripsi_kategori) < 10) {
                // Rollback transaksi jika deskripsi tidak valid
                DB::rollBack();
                return redirect()->back()->with('error', 'Deskripsi harus diisi dan lebih dari 10 karakter.')->withInput();
            }

            // Validasi gambar
            if (! $request->hasFile('gambar_kategori')) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Gambar produk wajib diunggah.')
                    ->withInput();
            } else {
                $ext     = $request->file('gambar_kategori')->extension();
                $allowed = ['jpg', 'jpeg', 'png'];
                if (! in_array($ext, $allowed)) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'File gambar harus berupa JPG, JPEG, atau PNG.')
                        ->withInput();
                }
            }

            // Cek & buat folder jika belum ada
            if (! Storage::disk('public')->exists('kategori')) {
                Storage::disk('public')->makeDirectory('kategori');
            }

            // Upload gambar
            $gambar = $request->file('gambar_kategori')->store('kategori', 'public');

                                                                                    // Menentukan kode kategori otomatis
            $lastKategori = KategoriProduk::orderBy('kode_kategori', 'desc')->first();    // Ambil kategori terakhir
            $lastKode     = $lastKategori ? $lastKategori->kode_kategori : 'KT000'; // Jika tidak ada, mulai dari KT000

                                                      // Ambil angka terakhir dari kode (setelah 'KT')
            $lastNumber = (int) substr($lastKode, 2); // Mengambil angka setelah 'KT' dan mengkonversinya ke integer
            $newNumber  = $lastNumber + 1;            // Menambahkan 1 ke angka terakhir

            // Membuat kode baru dengan format 'KT' diikuti angka 3 digit
            $newKode = 'KT' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

            // Menyimpan kategori baru
            KategoriProduk::create([
                'kode_kategori'      => $newKode,
                'nama_kategori'      => $request->nama_kategori,
                'deskripsi_kategori' => $request->deskripsi_kategori,
                'gambar_kategori'    => $gambar,               // Simpan nama file gambar
                'created_at'         => \Carbon\Carbon::now(), // Menetapkan created_at dengan waktu saat ini
            ]);

            // Commit transaksi jika semua operasi sukses
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('toko.index')->with('success', 'Kategori berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            // Tangani error dan tampilkan pesan
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

  public function show($kode_toko)
    {
        // Ambil detail utama toko (1 baris)
        $tokoshow = DB::table('tokos')
            ->join('users', 'tokos.pemilik_toko_id', '=', 'users.id')
            ->join('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
            ->join('detail_tokos', 'tokos.id', '=', 'detail_tokos.toko_id')
            ->where('tokos.kode_toko', $kode_toko)
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

        if (! $tokoshow) {
            return redirect()->back()->with('error', 'Toko tidak ditemukan.');
        }

        // Ambil jam operasional per hari (banyak baris)
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

        return view('backend.manajementtoko.toko.show', compact('tokoshow', 'jadwalOperasional'));
    }
    public function edit($kode_kategori)
    {
        // Mengambil data kategori berdasarkan kode_kategori
        $kategori = KategoriProduk::where('kode_kategori', $kode_kategori)->first();

        // Validasi jika kategori tidak ditemukan
        if (! $kategori) {
            return redirect()->route('toko.index')->with('error', 'Kategori tidak ditemukan.');
        }

        // Menampilkan form edit dengan membawa data kategori yang ingin diedit
        return view('backend.manajementtoko.toko.edit', compact('kategori'));
    }

    public function update(Request $request, $kode_kategori)
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            // Validasi jika nama kategori sudah ada di database dan bukan kategori yang sedang diedit
            $existingnama_kategori = DB::connection('pgsql')->table('kategoris')
                ->where('nama_kategori', $request->nama_kategori)
                ->where('kode_kategori', '!=', $kode_kategori) // Menghindari kategori yang sama
                ->exists();

            if ($existingnama_kategori) {
                // Rollback transaksi jika kategori sudah ada
                DB::rollBack();
                return redirect()->back()->with('error', 'Nama Kategori "' . $request->nama_kategori . '" sudah ada di database.')->withInput();
            }

            // Validasi: Cek jika deskripsi kategori tidak kosong dan memiliki panjang minimal
            if (empty($request->deskripsi_kategori) || strlen($request->deskripsi_kategori) < 10) {
                // Rollback transaksi jika deskripsi tidak valid
                DB::rollBack();
                return redirect()->back()->with('error', 'Deskripsi harus diisi dan lebih dari 10 karakter.')->withInput();
            }

            // Mencari kategori berdasarkan kode_kategori
            $kategori = KategoriProduk::where('kode_kategori', $kode_kategori)->first();

            // Validasi jika kategori tidak ditemukan
            if (! $kategori) {
                DB::rollBack();
                return redirect()->route('toko.index')->with('error', 'Kategori tidak ditemukan.');
            }

            // Jika ada gambar baru yang diunggah
            if ($request->hasFile('gambar_kategori')) {
                // Validasi gambar
                $ext     = $request->file('gambar_kategori')->extension();
                $allowed = ['jpg', 'jpeg', 'png'];
                if (! in_array($ext, $allowed)) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'File gambar harus berupa JPG, JPEG, atau PNG.')
                        ->withInput();
                }

                // Cek & buat folder jika belum ada
                if (! Storage::disk('public')->exists('kategori')) {
                    Storage::disk('public')->makeDirectory('kategori');
                }

                // Hapus gambar lama jika ada
                if ($kategori->gambar_kategori && Storage::disk('public')->exists($kategori->gambar_kategori)) {
                    Storage::disk('public')->delete($kategori->gambar_kategori);
                }

                // Upload gambar baru
                $gambar = $request->file('gambar_kategori')->store('kategori', 'public');

                // Update gambar di database
                $kategori->gambar_kategori = $gambar;
            }

            // Update kategori
            $kategori->update([
                'nama_kategori'      => $request->nama_kategori,
                'deskripsi_kategori' => $request->deskripsi_kategori,
                'updated_at'         => \Carbon\Carbon::now(), // Menetapkan updated_at dengan waktu saat ini
            ]);

            // Commit transaksi jika semua operasi sukses
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('toko.index')->with('success', 'Kategori berhasil diperbarui!');
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
        $kode_kategori = $request->kode_kategori; // Mendapatkan kode_kategori dari request

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Cari kategori berdasarkan kode_kategori
            $cek_kategori = DB::connection('pgsql')->table('kategoris')->where('kode_kategori', $kode_kategori)->first();

            // Validasi: jika kategori tidak ditemukan, return error
            if (! $cek_kategori) {
                return redirect()->route('toko.index')->with('error', 'Kategori tidak ditemukan.');
            }

            // Hapus kategori dari database
            DB::connection('pgsql')->table('kategoris')->where('kode_kategori', $kode_kategori)->delete();

            // Commit transaksi jika tidak ada error
            DB::commit();

            // Return success response
            return redirect()->route('toko.index')->with('success', 'Kategori berhasil dihapus.');

        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            // Return error response
            return redirect()->route('toko.index')->with('error', 'Terjadi kesalahan dalam menghapus toko.');
        }
    }
}
