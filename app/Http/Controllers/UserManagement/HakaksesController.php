<?php

namespace App\Http\Controllers\UserManagement;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HakaksesController extends Controller
{
    public function index(Request $request)
{
    // $user = Auth::user();
    // dd($user->hasRole('asdas'));

    if ($request->ajax()) {
        // Ambil data hakakses dari database
        $hakakses = DB::table('hakakses')
            ->select(['id', 'hakakses', 'description', 'time_hakakses']); // Don't include DT_RowIndex here

        return DataTables::of($hakakses)
            ->addIndexColumn() // Automatically generates index in frontend (DT_RowIndex)
            ->editColumn('time_hakakses', function ($data) {
                return \Carbon\Carbon::parse($data->time_hakakses)->format('d M Y, H:i');
            })
            ->addColumn('action', function ($data) {
                return '
                    <a href="'.route('hakakses.show', $data->id).'" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> Show
                    </a>
                    <a href="'.route('hakakses.edit', $data->id).'" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="' . $data->id . '" data-nm="' . $data->hakakses . '">
                        <i class="bi bi-trash"></i> Hapus
                    </a>
                ';
            })
            ->rawColumns(['action']) // Allow HTML in 'action' column
            ->make(true);
    }
    $hakakses = DB::connection('pgsql')->table('hakakses')->get();
    return view('backend.usermanagement.hakakses.index',compact('hakakses'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hakakses_selected = DB::connection('pgsql')->table('hakakses')->select('hakakses')->get();
        return view('backend.usermanagement.hakakses.create',compact('hakakses_selected'));
    }

    public function store(Request $request)
    {
        // Data hak akses yang valid
        $validHakAkses = ['Create', 'Read', 'Update', 'Delete'];

        // Validasi: Cek jika hak akses yang dimasukkan adalah salah satu dari yang valid
        if (!in_array($request->hakakses, $validHakAkses)) {
            return redirect()->back()->with('error', 'Hak Akses harus salah satu dari Create, Read, Update, atau Delete.')->withInput();
        }


        // Validasi: Cek jika hak akses dengan nama yang sama sudah ada di database
        $existingHakAkses = DB::connection('pgsql')->table('hakakses')
        ->where('hakakses', $request->hakakses)
        ->exists();

        if ($existingHakAkses) {
            return redirect()->back()->with('error', 'Hak Akses "' . $request->hakakses . '" sudah ada di database.')->withInput();
        }
        // Validasi: Cek jika deskripsi tidak kosong dan memiliki panjang minimal
        if (empty($request->description) || strlen($request->description) < 10) {
            return redirect()->back()->with('error', 'Deskripsi harus diisi dan lebih dari 10 karakter.')->withInput();
        }

        // Mulai transaksi DB
        DB::connection('pgsql')->beginTransaction();

        try {
            // Insert data ke tabel hakakses
            DB::connection('pgsql')->table('hakakses')->insert([
                'hakakses' => $request->hakakses,
                'description' => $request->description,
                'time_hakakses' => now(),
                'created_at' => now(),
            ]);

            // Commit transaksi jika berhasil
            DB::connection('pgsql')->commit();

            return redirect()->route('hakakses.index')->with('success', 'Hak Akses berhasil disimpan');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::connection('pgsql')->rollBack();

            // Log error dan kirimkan pesan error dengan status 500
            \Log::error('Error inserting hakakses: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan hak akses.');
        }
    }
    public function update(Request $request, $id)
{
    // Data hak akses yang valid
    $validHakAkses = ['Create', 'Read', 'Update', 'Delete'];

    // Validasi: Cek jika hak akses yang dimasukkan adalah salah satu dari yang valid
    if (!in_array($request->hakakses, $validHakAkses)) {
        return redirect()->back()->with('error', 'Hak Akses harus salah satu dari Create, Read, Update, atau Delete.')->withInput();
    }

    // Validasi: Cek jika hak akses dengan nama yang sama sudah ada di database, kecuali pada record yang sedang diupdate
    $existingHakAkses = DB::connection('pgsql')->table('hakakses')
        ->where('hakakses', $request->hakakses)
        ->where('id', '!=', $id) // Exclude the current record being updated
        ->exists();

    if ($existingHakAkses) {
        return redirect()->back()->with('error', 'Hak Akses "' . $request->hakakses . '" sudah ada di database.')->withInput();
    }

    // Validasi: Cek jika deskripsi tidak kosong dan memiliki panjang minimal
    if (empty($request->description) || strlen($request->description) < 10) {
        return redirect()->back()->with('error', 'Deskripsi harus diisi dan lebih dari 10 karakter.')->withInput();
    }

    // Mulai transaksi DB
    DB::connection('pgsql')->beginTransaction();

    try {
        // Update data pada tabel hakakses
        DB::connection('pgsql')->table('hakakses')
            ->where('id', $id)
            ->update([
                'hakakses' => $request->hakakses,
                'description' => $request->description,
                'time_hakakses' => now(),
                'updated_at' => now(),
            ]);

        // Commit transaksi jika berhasil
        DB::connection('pgsql')->commit();

        return redirect()->route('hakakses.index')->with('success', 'Hak Akses berhasil diperbarui');
    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi error
        DB::connection('pgsql')->rollBack();

        // Log error dan kirimkan pesan error dengan status 500
        \Log::error('Error updating hakakses: ' . $e->getMessage());

        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui hak akses.');
    }
}


    public function show(Request $request)
    {
        $id = $request->id;

        // Ambil data berdasarkan ID
        $hakakses = DB::connection('pgsql')->table('hakakses')->where('id', $id)->first();

        // Validasi: jika data tidak ditemukan, return error
        if (!$hakakses) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        return view('backend.usermanagement.hakakses.show', compact('hakakses'));
    }
    public function edit(Request $request)
    {
        // dd($request->all());
        $id = $request->id;

        // Ambil data berdasarkan ID
        $hakakses = DB::connection('pgsql')->table('hakakses')->where('id', $id)->first();

        // Validasi: jika data tidak ditemukan, return error
        if (!$hakakses) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        $hakakses_selected = DB::connection('pgsql')->table('hakakses')->select('hakakses')->get();
        return view('backend.usermanagement.hakakses.edit', compact('hakakses','hakakses_selected'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Cari data berdasarkan ID
            $cek_hakAkses = DB::connection('pgsql')->table('hakakses')->where('id',$id)->first();

            // Validasi: jika data tidak ditemukan, return error
            if (!$cek_hakAkses) {
                return redirect()->route('hakakses.index')->with('error', 'Data tidak ditemukan.');
            }

            $hakAkses = DB::connection('pgsql')->table('hakakses')->where('id',$id)->delete();

            // Commit transaksi jika tidak ada error
            DB::commit();

            // Return success response
            return redirect()->route('hakakses.index')->with('success', 'Data hak akses berhasil dihapus.');

        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollback();

            // Return error response
            return redirect()->route('hakakses.index')->with('error', 'Terjadi kesalahan dalam menghapus data.');
        }
    }

}
