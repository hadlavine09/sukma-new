<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\kategori_toko;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriTokoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategori_toko = kategori_toko::all();
            return DataTables::of($kategori_toko)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('kategori_toko.show', $data->kode_kategori_toko) . '" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Show
                        </a>
                        <a href="' . route('kategori_toko.edit', $data->kode_kategori_toko) . '" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="' . $data->id . '" data-nm="' . $data->nama_kategori_toko . '">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.manajementtoko.kategori_toko.index');
    }

    public function create()
    {
        return view('backend.manajementtoko.kategori_toko.create');
    }

   public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // Validasi input
        $request->validate([
            'nama_kategori_toko' => 'required|string',
            'deskripsi_kategori_toko' => 'required|string|min:10',
            'gambar_kategori_toko' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Pastikan folder 'kategori_toko' sudah ada di storage/app/public
        if (!Storage::disk('public')->exists('kategori_toko')) {
            Storage::disk('public')->makeDirectory('kategori_toko', 0755, true);
        }

        // Simpan gambar
        $gambarPath = $request->file('gambar_kategori_toko')->store('kategori_toko', 'public');

        // Buat kode otomatis
        $last = kategori_toko::withoutTrashed()->orderBy('kode_kategori_toko', 'desc')->first();
        $lastNumber = $last ? (int)substr($last->kode_kategori_toko, 4) : 0;
        $newKode = 'KTGT' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Simpan ke database
        kategori_toko::create([
            'kode_kategori_toko' => $newKode,
            'nama_kategori_toko' => $request->nama_kategori_toko,
            'deskripsi_kategori_toko' => $request->deskripsi_kategori_toko,
            'gambar_kategori_toko' => $gambarPath,
            'created_at' => Carbon::now(),
        ]);

        DB::commit();
        return redirect()->route('kategori_toko.index')->with('success', 'Kategori berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}



    public function show($kode_kategori_toko)
    {
        $kategori = kategori_toko::where('kode_kategori_toko', $kode_kategori_toko)->first();

        if (!$kategori) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        return view('backend.manajementtoko.kategori_toko.show', compact('kategori'));
    }

    public function edit($kode_kategori_toko)
    {
        $kategori = kategori_toko::where('kode_kategori_toko', $kode_kategori_toko)->first();

        if (!$kategori) {
            return redirect()->route('kategori_toko.index')->with('error', 'Kategori tidak ditemukan.');
        }

        return view('backend.manajementtoko.kategori_toko.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
          // Ambil kategori berdasarkan kode
            $kategori = DB::table('kategori_tokos')->where('id', $id)->first();
            if (!$kategori) {
                return redirect()->back()->with('error', 'Kategori dengan id "' . $id . '" tidak ditemukan.')->withInput();
            }


            // Validasi manual agar bisa menangani status 422 secara detail jika diperlukan
            $validator = Validator::make($request->all(), [
                'nama_kategori_toko' => 'required|string|max:100|unique:kategori_tokos,nama_kategori_toko,' . $kategori->id,
                'deskripsi_kategori_toko' => 'required|string|min:10',
                'gambar_kategori_toko' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                // Jika dari ajax, bisa return JSON 422:
                // return response()->json(['errors' => $validator->errors()], 422);

                // Jika dari form biasa, redirect back dengan pesan
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Simpan path gambar lama jika tidak ada upload baru
            $gambarBaru = $kategori->gambar_kategori_toko;

            if ($request->hasFile('gambar_kategori_toko')) {
                // Hapus file lama jika ada
                if ($kategori->gambar_kategori_toko && Storage::disk('public')->exists($kategori->gambar_kategori_toko)) {
                    Storage::disk('public')->delete($kategori->gambar_kategori_toko);
                }

                // Pastikan folder penyimpanan ada
                if (!Storage::disk('public')->exists('kategori_toko')) {
                    Storage::disk('public')->makeDirectory('kategori_toko');
                }

                // Simpan gambar baru
                $gambarBaru = $request->file('gambar_kategori_toko')->store('kategori_toko', 'public');
            }

            // Update ke database
            DB::table('kategori_tokos')
                ->where('id', $id)
                ->update([
                    'nama_kategori_toko' => $request->nama_kategori_toko,
                    'deskripsi_kategori_toko' => $request->deskripsi_kategori_toko,
                    'gambar_kategori_toko' => $gambarBaru,
                    'updated_at' => Carbon::now(),
                ]);

            DB::commit();
            return redirect()->route('kategori_toko.index')->with('success', 'Kategori berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request)
    {
        // dd($request->all());
        $id = $request->id;

        DB::beginTransaction();
        try {
            $kategori = kategori_toko::where('id', $id)->first();

            if (!$kategori) {
                return redirect()->route('kategori_toko.index')->with('error', 'Kategori tidak ditemukan.');
            }

            if ($kategori->gambar_kategori_toko && Storage::disk('public')->exists($kategori->gambar_kategori_toko)) {
                Storage::disk('public')->delete($kategori->gambar_kategori_toko);
            }

            $kategori->delete();

            DB::commit();
            return redirect()->route('kategori_toko.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kategori_toko.index')->with('error', 'Gagal menghapus kategori.');
        }
    }

    public function detail_kategori_toko($nama_kategori_toko)
    {
        $kode = request()->query('kode');

        $kategori = kategori_toko::where('kode_kategori_toko', $kode)->firstOrFail();

        return view('frontend.detail_kategori_toko', compact('kategori'));
    }
}
