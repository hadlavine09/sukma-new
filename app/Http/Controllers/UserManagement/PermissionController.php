<?php
namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //     public function permission_role(Request $request)
    // {

    //     $aksesAllowed = Auth::user()->hasRole('superadmin') && Auth::user()->isAbleTo('list_role') && Auth::user()->username == "superadmin";
    //     // dd($aksesAllowed);

    //     $results = DB::table('hakakses_permission')
    //         ->join('permissions', 'hakakses_permission.permission_id', '=', 'permissions.id')
    //         ->join('hakakses', 'hakakses_permission.hakakses_id', '=', 'hakakses.id')
    //         ->select('permissions.name as permission_name', 'hakakses.name as hakakses_name')
    //         ->where('permissions.name', $aksesAllowed ? 'list_role' : '')
    //         ->get();

    //     // dd($results);

    //     if ($aksesAllowed && $results && $results->contains('hakakses_name', 'read')) {

    //         if ($request->ajax()) {
    //             $data = DB::select("SELECT * from roles WHERE id <> 1");
    //             return Datatables::of($data)
    //                 ->addIndexColumn()
    //                 ->addColumn('permission', function ($row) {
    //                     $data = DB::select("SELECT b.name FROM permission_role a
    //                left join permissions b on a.permission_id = b.id WHERE role_id = ? ", [$row->id]);
    //                     $btn = '';
    //                     foreach ($data as $val) {
    //                         $btn = $btn . '<ul> <li>' . $val->name . '</li> </ul>';
    //                     }
    //                     return $btn;
    //                 })
    //                 ->addColumn('action', function ($row) {
    //                     $aksesAllowed = Auth::user()->hasRole('superadmin') && Auth::user()->isAbleTo('list_role');
    //                     $results = DB::table('hakakses_permission')
    //                         ->join('permissions', 'hakakses_permission.permission_id', '=', 'permissions.id')
    //                         ->join('hakakses', 'hakakses_permission.hakakses_id', '=', 'hakakses.id')
    //                         ->select('permissions.name as permission_name', 'hakakses.name as hakakses_name')
    //                         ->where('permissions.name', $aksesAllowed ? 'list_role' : '')
    //                         ->get();

    //                     $btn = '';

    //                     if ($aksesAllowed && $results->contains('hakakses_name', 'delete') && $results->contains('hakakses_name', 'update')) {
    //                         $btn .= '<a class="btn btn-success" href="' . url('/permission_role/edit_permission_role', [$row->id]) . '" > <i class="flaticon2-edit" aria-hidden="true"></i>Update</a>  <a type="submit" class="delPermission btn btn-danger" data-id="' . $row->id . '" data-nm="' . $row->name . '" ><i class="flaticon2-trash" aria-hidden="true"></i>Delete</a>';
    //                     } elseif ($aksesAllowed && $results->contains('hakakses_name', 'delete')) {
    //                         $btn = '<a type="submit" class="delPermission btn btn-danger" data-id="' . $row->id . '" data-nm="' . $row->name . '" ><i class="flaticon2-trash" aria-hidden="true"></i>Delete</a>';
    //                     } elseif ($aksesAllowed && $results->contains('hakakses_name', 'update')) {
    //                         $btn = '<a class="btn btn-success" href="' . url('/permission_role/edit_permission_role', [$row->id]) . '" > <i class="flaticon2-edit" aria-hidden="true"></i>Update</a>';
    //                     }
    //                     return $btn;
    //                 })
    //                 ->rawColumns(['permission', 'action'])
    //                 ->make(true);
    //         }
    //         $list_contact = DB::select("SELECT * from roles");
    //         // $list_contact = DB::select("SELECT * from roles WHERE name != 'superadmin'");

    //         return view('admin.permission_role.index', ['data' => $list_contact, 'aksesAllowed' => $aksesAllowed, 'results' => $results]);
    //     } else {
    //         // Kode jika user tidak memenuhi persyaratan akses
    //         Alert::error('Error', 'Anda tidak memiliki akses ke halaman ini.');
    //         return redirect()->back();
    //     }
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = DB::table('permissions')
                ->select(['id', 'name', 'subname', 'description', 'time_permissions']); // Don't include DT_RowIndex here

            return DataTables::of($permissions)
                ->addIndexColumn() // Automatically generates index in frontend (DT_RowIndex)
                ->editColumn('time_permissions', function ($data) {
                    return \Carbon\Carbon::parse($data->time_permissions)->format('d M Y, H:i');
                })
                ->addColumn('action', function ($data) {
                    return '
                    <a href="' . route('permissions.show', $data->id) . '" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> Show
                    </a>
                    <a href="' . route('permissions.edit', $data->id) . '" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="' . $data->id . '" data-nm="' . $data->permissions . '">
                        <i class="bi bi-trash"></i> Hapus
                    </a>
                ';
                })
                ->rawColumns(['action']) // Allow HTML in 'action' column
                ->make(true);
        }
        return view('backend.usermanagement.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions_selected = DB::connection('pgsql')->table('permissions')->select('permissions')->get();
        return view('backend.usermanagement.permissions.create', compact('permissions_selected'));
    }

    public function store(Request $request)
    {
        dd($request->all());

    }
    public function update(Request $request, $id)
    {
        // Data hak akses yang valid
        $validpermissions = ['Create', 'Read', 'Update', 'Delete'];

        // Validasi: Cek jika hak akses yang dimasukkan adalah salah satu dari yang valid
        if (! in_array($request->permissions, $validpermissions)) {
            return redirect()->back()->with('error', 'Hak Akses harus salah satu dari Create, Read, Update, atau Delete.')->withInput();
        }

        // Validasi: Cek jika hak akses dengan nama yang sama sudah ada di database, kecuali pada record yang sedang diupdate
        $existingpermissions = DB::connection('pgsql')->table('permissions')
            ->where('permissions', $request->permissions)
            ->where('id', '!=', $id) // Exclude the current record being updated
            ->exists();

        if ($existingpermissions) {
            return redirect()->back()->with('error', 'Hak Akses "' . $request->permissions . '" sudah ada di database.')->withInput();
        }

        // Validasi: Cek jika deskripsi tidak kosong dan memiliki panjang minimal
        if (empty($request->description) || strlen($request->description) < 10) {
            return redirect()->back()->with('error', 'Deskripsi harus diisi dan lebih dari 10 karakter.')->withInput();
        }

        // Mulai transaksi DB
        DB::connection('pgsql')->beginTransaction();

        try {
            // Update data pada tabel permissions
            DB::connection('pgsql')->table('permissions')
                ->where('id', $id)
                ->update([
                    'permissions'      => $request->permissions,
                    'description'      => $request->description,
                    'time_permissions' => now(),
                    'updated_at'       => now(),
                ]);

            // Commit transaksi jika berhasil
            DB::connection('pgsql')->commit();

            return redirect()->route('permissions.index')->with('success', 'Hak Akses berhasil diperbarui');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::connection('pgsql')->rollBack();

            // Log error dan kirimkan pesan error dengan status 500
            \Log::error('Error updating permissions: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui hak akses.');
        }
    }

    public function show(Request $request)
    {
        $id = $request->id;

        // Ambil data berdasarkan ID
        $permissions = DB::connection('pgsql')->table('permissions')->where('id', $id)->first();

        // Validasi: jika data tidak ditemukan, return error
        if (! $permissions) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        return view('backend.usermanagement.permissions.show', compact('permissions'));
    }
    public function edit(Request $request)
    {
        // dd($request->all());
        $id = $request->id;

        // Ambil data berdasarkan ID
        $permissions = DB::connection('pgsql')->table('permissions')->where('id', $id)->first();

        // Validasi: jika data tidak ditemukan, return error
        if (! $permissions) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        $permissions_selected = DB::connection('pgsql')->table('permissions')->select('permissions')->get();
        return view('backend.usermanagement.permissions.edit', compact('permissions', 'permissions_selected'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Cari data berdasarkan ID
            $cek_permissions = DB::connection('pgsql')->table('permissions')->where('id', $id)->first();

            // Validasi: jika data tidak ditemukan, return error
            if (! $cek_permissions) {
                return redirect()->route('permissions.index')->with('error', 'Data tidak ditemukan.');
            }

            $permissions = DB::connection('pgsql')->table('permissions')->where('id', $id)->delete();

            // Commit transaksi jika tidak ada error
            DB::commit();

            // Return success response
            return redirect()->route('permissions.index')->with('success', 'Data hak akses berhasil dihapus.');

        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollback();

            // Return error response
            return redirect()->route('permissions.index')->with('error', 'Terjadi kesalahan dalam menghapus data.');
        }
    }

}
