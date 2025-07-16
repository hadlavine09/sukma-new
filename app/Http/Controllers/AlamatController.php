<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
public function show($id)
{
    $userId = auth()->id();

    $alamat = Alamat::where('id', $id)
                    ->where('user_id', $userId)
                    ->first();

    if (!$alamat) {
        return response()->json([
            'success' => false,
            'message' => 'Alamat tidak ditemukan.'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $alamat
    ]);
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
        'nama_alamat'   => 'required|string|max:100',
        'nama_penerima'   => 'required|string|max:100',
        'no_hp'           => 'required|string|max:20',
        'alamat_lengkap'  => 'required|string',
    ]);

    try {
        $userId = auth()->id();
        $jumlahAlamat = Alamat::where('user_id', $userId)->count();
        $isUtama = $jumlahAlamat === 0;

        if ($isUtama) {
            Alamat::where('user_id', $userId)->update(['is_utama' => false]);
        }

        $alamat = Alamat::create([
            'user_id'        => $userId,
            'nama_penerima'  => $request->nama_penerima,
            'nama_alamat'  => $request->nama_alamat,
            'no_hp'          => $request->no_hp,
            'alamat_lengkap' => $request->alamat_lengkap,
            'is_utama'       => $isUtama,
        ]);

        return response()->json(['success' => true, 'data' => $alamat]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan alamat: ' . $e->getMessage()
        ], 500);
    }
}
public function update(Request $request, $id)
{
+    $request->validate([
        'nama_alamat'   => 'required|string|max:100',
        'nama_penerima' => 'required|string|max:100',
        'no_hp'         => 'required|string|max:20',
        'alamat_lengkap'=> 'required|string',
    ]);

    try {
        $userId = auth()->id();

        $alamat = Alamat::where('id', $id)
                        ->where('user_id', $userId)
                        ->firstOrFail();

        $alamat->update([
            'nama_penerima'  => $request->nama_penerima,
            'nama_alamat'    => $request->nama_alamat,
            'no_hp'          => $request->no_hp,
            'alamat_lengkap' => $request->alamat_lengkap,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil diperbarui.',
            'data'    => $alamat
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbarui alamat: ' . $e->getMessage()
        ], 500);
    }
}

public function updateAlamat(Request $request, $id)
{
    $request->validate([
        'nama_alamat'     => 'required|string|max:100',
        'nama_penerima'   => 'required|string|max:100',
        'no_hp'           => 'required|string|max:20',
        'alamat_lengkap'  => 'required|string',
        'kode_pos'        => 'nullable|string|max:10',
        'provinsi'        => 'nullable|string|max:100',
        'kota'            => 'nullable|string|max:100',
        'kecamatan'       => 'nullable|string|max:100',
        'kelurahan'       => 'nullable|string|max:100'
        // is_utama tidak diproses di sini
    ]);

    DB::beginTransaction();

    try {
        // Cari alamat berdasarkan ID dan user (pastikan user hanya bisa update miliknya)
        $alamat = Alamat::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        // Update data
        $alamat->nama_alamat    = $request->nama_alamat;
        $alamat->nama_penerima  = $request->nama_penerima;
        $alamat->no_hp          = $request->no_hp;
        $alamat->alamat_lengkap = $request->alamat_lengkap;
        $alamat->kode_pos       = $request->kode_pos;
        $alamat->provinsi       = $request->provinsi;
        $alamat->kota           = $request->kota;
        $alamat->kecamatan      = $request->kecamatan;
        $alamat->kelurahan      = $request->kelurahan;

        $alamat->save();

        DB::commit();

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal memperbarui alamat: ' . $e->getMessage());
    }
}

    public function updateutama(Request $request, $id)
{
    try {
        $userId = auth()->id();

        // Set semua alamat milik user ke bukan utama
        Alamat::where('user_id', $userId)->update(['is_utama' => false]);

        // Set alamat yang dipilih menjadi utama
        Alamat::where('id', $id)->where('user_id', $userId)->update(['is_utama' => true]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Gagal update alamat utama']);
    }
}

public function destroy($id)
{
    DB::beginTransaction();

    try {
        $userId = auth()->id();

        $alamat = Alamat::where('id', $id)
                        ->where('user_id', $userId)
                        ->firstOrFail();

        if ($alamat->is_utama) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat utama tidak dapat dihapus. Silakan ubah alamat utama terlebih dahulu.'
            ], 400);
        }

        $jumlahAlamat = Alamat::where('user_id', $userId)->count();

        if ($jumlahAlamat <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal harus memiliki satu alamat. Alamat tidak dapat dihapus.'
            ], 400);
        }

        $alamat->delete();

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil dihapus.'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus alamat: ' . $e->getMessage()
        ], 500);
    }
}


}
