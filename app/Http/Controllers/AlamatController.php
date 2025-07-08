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

        // Ambil alamat yang mau dihapus (dan validasi milik user)
        $alamat = Alamat::where('id', $id)
                        ->where('user_id', $userId)
                        ->firstOrFail();

        // Cek jika alamat tersebut adalah alamat utama
        if ($alamat->is_utama) {
            return redirect()->back()->with('warning', 'Alamat utama tidak dapat dihapus. Silakan ubah alamat utama terlebih dahulu.');
        }

        // Cek jumlah total alamat milik user
        $jumlahAlamat = Alamat::where('user_id', $userId)->count();

        // Tidak boleh hapus jika cuma punya satu alamat
        if ($jumlahAlamat <= 1) {
            return redirect()->back()->with('warning', 'Minimal harus memiliki satu alamat. Alamat tidak dapat dihapus.');
        }

        // Hapus alamat
        $alamat->delete();

        DB::commit();
        return redirect()->back()->with('success', 'Alamat berhasil dihapus.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal menghapus alamat: ' . $e->getMessage());
    }
}
}
