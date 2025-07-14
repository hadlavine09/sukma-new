<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Toko;
use App\Models\IzinToko;
use App\Models\DetailToko;
use Illuminate\Http\Request;
use App\Models\kategori_toko;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class IzinTokoController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data toko
            $toko = DB::table('tokos')
                ->join('users', 'tokos.pemilik_toko_id', '=', 'users.id')
                ->join('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
                ->where('tokos.status_toko', 'proses')
                ->whereNull('tokos.deleted_at')
                ->whereNull('kategori_tokos.deleted_at')
                ->select('tokos.*', 'users.username as nama_pemilik', 'kategori_tokos.nama_kategori_toko')
                ->get();
            return DataTables::of($toko)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('izin_toko.show', $data->kode_toko) . '" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i> Show
                        </a>
                       <button onclick="verifikasiToko(\'' . $data->kode_toko . '\', true)" class="btn btn-sm btn-success me-1">
            <i class="bi bi-check-circle"></i> Izinkan
        </button>
        <button onclick="verifikasiToko(\'' . $data->kode_toko . '\', false)" class="btn btn-sm btn-danger">
            <i class="bi bi-x-circle"></i> Tolak
        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        // Mengirim data toko untuk tampilan normal jika tidak menggunakan AJAX
        return view('backend.manajementtoko.pendaftarantoko.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriTokos = kategori_toko::all();
        return view('backend.manajementtoko.pendaftarantoko.create', compact('kategoriTokos'));

    }
    public function izinkan(Request $request)
    {
        $kode_toko = $request->input('kode_toko');

        DB::beginTransaction();
        try {
            $toko = DB::table('tokos')
                ->where('status_toko', 'proses')
                ->where('kode_toko', $kode_toko)
                ->first();

            if (! $toko) {
                return response()->json(['status' => false, 'message' => 'Toko tidak ditemukan atau status tidak sesuai.']);
            }

            DB::table('tokos')
                ->where('id', $toko->id)
                ->update(['status_toko' => 'izinkan']);

            $last       = IzinToko::orderBy('nomor_izin', 'desc')->first();
            $lastNumber = 0;

            if ($last && preg_match('/IZT(\d+)/', $last->nomor_izin, $matches)) {
                $lastNumber = (int) $matches[1];
            }

            $nomor_izin = 'IZT' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            IzinToko::create([
                'toko_id'        => $toko->id,
                'nomor_izin'     => $nomor_izin,
                'nama_dokumen'   => 'Dokumen Izin Toko #' . $toko->id,
                'file_dokumen'   => 'default.pdf',
                'tanggal_terbit' => Carbon::now()->toDateString(),
                'created_at'     => Carbon::now(),
            ]);

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Toko berhasil diizinkan dan data izin disimpan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Gagal memproses izin: ' . $e->getMessage()]);
        }
    }
    public function tidak_izinkan(Request $request)
    {
        $kode_toko = $request->input('kode_toko');

        DB::beginTransaction();
        try {
            $toko = DB::table('tokos')
                ->where('status_toko', 'proses')
                ->where('kode_toko', $kode_toko)
                ->first();

            if (! $toko) {
                return response()->json(['status' => false, 'message' => 'Toko tidak ditemukan atau status tidak sesuai.']);
            }

            DB::table('tokos')
                ->where('id', $toko->id)
                ->update(['status_toko' => 'tidak_diizinkan']);

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Toko berhasil tidak diizinkan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Gagal memproses izin: ' . $e->getMessage()]);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            $request->validate([
                //form tahap1
                'nama_toko'             => 'required|string|max:255',
                'kategori_toko_id'      => 'required|exists:kategori_tokos,id',
                'no_hp_toko'            => 'required|string|max:20',
                'alamat_toko'           => 'required|string',
                'deskripsi_toko'        => 'nullable|string',
                'logo_toko'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

                //form tahap2
                'nama_ktp'              => 'required|string|max:255',
                'nomor_ktp'             => 'required|string|max:50',
                'nomor_kk'              => 'required|string|max:50',
                'foto_ktp'              => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'foto_kk'               => 'required|image|mimes:jpg,jpeg,png|max:2048',

                //form tahap3
                'nama_bank'             => 'nullable|string|max:255',
                'nomor_rekening'        => 'nullable|string|max:100',
                'nama_pemilik_rekening' => 'nullable|string|max:255',

                //form tahap4
                'email_cs'              => 'nullable|email|max:255',
                'whatsapp_cs'           => 'nullable|string|max:20',
                'link_instagram'        => 'nullable|string|max:255',
                'link_facebook'         => 'nullable|string|max:255',
                'link_tiktok'           => 'nullable|string|max:255',
                'link_google_maps'      => 'nullable|string|max:255',

                //form tahap5
                'jadwal'                => 'required|array',
            ]);

            // Upload logo toko
            $logoPath = $request->hasFile('logo_toko')
            ? $request->file('logo_toko')->store('logo_toko', 'public')
            : null;

            // Upload KTP dan KK
            $ktpPath = $request->file('foto_ktp')->store('dokumen_ktp', 'public');
            $kkPath  = $request->file('foto_kk')->store('dokumen_kk', 'public');

            $last       = Toko::withoutTrashed()->orderBy('kode_toko', 'desc')->first();
            $lastNumber = $last ? (int) substr($last->kode_toko, 4) : 0;
            $newKode    = 'TK' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            $toko = Toko::create([
                'kode_toko'         => $newKode,
                'pemilik_toko_id'   => auth()->id(),
                'kategori_toko_id'  => $request->kategori_toko_id,
                'nama_toko'         => $request->nama_toko,
                'logo_toko'         => $logoPath,
                'no_hp_toko'        => $request->no_hp_toko,
                'alamat_toko'       => $request->alamat_toko,
                'deskripsi_toko'    => $request->deskripsi_toko,
                'status_aktif_toko' => 1,
            ]);

            DetailToko::create([
                'toko_id'               => $toko->id,
                'nama_bank'             => $request->nama_bank,
                'nomor_rekening'        => $request->nomor_rekening,
                'nama_pemilik_rekening' => $request->nama_pemilik_rekening,
                'email_cs'              => $request->email_cs,
                'whatsapp_cs'           => $request->whatsapp_cs,
                'link_instagram'        => $request->link_instagram,
                'link_facebook'         => $request->link_facebook,
                'link_tiktok'           => $request->link_tiktok,
                'link_google_maps'      => $request->link_google_maps,
                'catatan_tambahan'      => null,
                'nomor_ktp'             => $request->nomor_ktp,
                'nomor_kk'              => $request->nomor_kk,
                'nama_ktp'              => $request->nama_ktp,
                'foto_ktp'              => $ktpPath,
                'foto_kk'               => $kkPath,
            ]);

            foreach ($request->jadwal as $hari => $data) {
                DB::table('jam_operasionals')->insert([
                    'toko_id'    => $toko->id,
                    'hari'       => $hari,
                    'buka'       => isset($data['buka']) && $data['buka'] == '1',
                    'jam_buka'   => $data['jam_buka'] ?? null,
                    'jam_tutup'  => $data['jam_tutup'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('izin_toko.index')->with('success', 'Toko berhasil didaftarkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */

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

        return view('backend.manajementtoko.pendaftarantoko.show', compact('tokoshow', 'jadwalOperasional'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IzinToko $izinToko)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IzinToko $izinToko)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IzinToko $izinToko)
    {
        //
    }
public function verifikasi_toko(Request $request)
{
    $step = (int) $request->get('step', 1);

    // Ambil toko yang sedang diverifikasi milik user
    $toko = Toko::where('pemilik_toko_id', auth()->id())
                ->where('status_aktif_toko', 0)
                ->latest()
                ->with('detailToko')
                ->first();

    // Kalau step 1, abaikan pengecekan progress (karena pendaftaran baru)
    if ($step === 1) {
        $kategori_tokos = kategori_toko::all();
        return view('toko.wrapper', compact('step', 'kategori_tokos', 'toko'));
    }

    // Kalau tidak ada toko yang belum aktif, paksa ke step 1
    if (!$toko) {
        return redirect()->route('verifikasitoko', ['step' => 1]);
    }

    // Cek step sebelumnya apakah sudah diisi
    $validStep = 1;

    if ($toko) {
        $detail = $toko->detailToko;

        if ($toko->nama_toko) {
            $validStep = 2;
        }
        if ($detail && $detail->nama_ktp && $detail->nomor_ktp && $detail->nomor_kk && $detail->foto_ktp && $detail->foto_kk) {
            $validStep = 3;
        }
        if ($detail && ($detail->nama_bank || $detail->nomor_rekening || $detail->nama_pemilik_rekening)) {
            $validStep = 4;
        }
        if ($detail && ($detail->email_cs || $detail->whatsapp_cs || $detail->link_instagram || $detail->link_facebook || $detail->link_tiktok)) {
            $validStep = 5;
        }
    }

    // Kalau user lompat ke step yang tidak valid, redirect ke step valid
    if ($step > $validStep) {
        return redirect()->route('verifikasitoko', ['step' => $validStep]);
    }

    $kategori_tokos = kategori_toko::all();
    return view('toko.wrapper', compact('step', 'kategori_tokos', 'toko'));
}

public function verifikasi_toko_store(Request $request, $step)
{
    $step = (int) $step;

    switch ($step) {
        case 1:
            // Cari toko belum aktif milik user
            $toko = Toko::where('pemilik_toko_id', auth()->id())
                        ->where('status_aktif_toko', 0)
                        ->latest()
                        ->first();

            $validated = $request->validate([
                'nama_toko' => [
                    'required', 'string', 'max:255',
                    Rule::unique('tokos', 'nama_toko')->ignore($toko?->id),
                ],
                'kategori_toko_id' => 'required|exists:kategori_tokos,id',
                'no_hp_toko' => [
                    'required',
                    'regex:/^[1-9][0-9]{5,14}$/',
                    Rule::unique('tokos', 'no_hp_toko')->ignore($toko?->id),
                ],
                'alamat_toko'    => 'required|string',
                'deskripsi_toko' => 'nullable|string',
                'logo_toko'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:min_width=50,min_height=50',
            ]);

            if ((int)$request->kategori_toko_id === 20) {
                $request->validate([
                    'kategori_toko' => [
                        'required', 'string', 'max:255',
                        Rule::notIn(DB::table('kategori_tokos')->pluck('nama_kategori_toko')->toArray()),
                    ],
                ]);
            }

            if ($request->hasFile('logo_toko')) {
                $validated['logo_toko'] = $request->file('logo_toko')->store('logo_toko', 'public');
            }

            DB::beginTransaction();
            try {
                if ($toko) {
                    // Update jika sudah ada
                    $toko->update([
                        'kategori_toko_id'  => $validated['kategori_toko_id'],
                        'nama_toko'         => $validated['nama_toko'],
                        'logo_toko'         => $validated['logo_toko'] ?? $toko->logo_toko,
                        'no_hp_toko'        => $validated['no_hp_toko'],
                        'alamat_toko'       => $validated['alamat_toko'],
                        'deskripsi_toko'    => $validated['deskripsi_toko'],
                    ]);
                } else {
                    // Buat baru jika belum ada
                    $lastNumber = DB::table('tokos')
                    ->where('kode_toko', 'LIKE', 'TK%')
                    ->selectRaw("MAX(CAST(SUBSTRING(kode_toko, 3) AS INTEGER)) as max_kode")
                    ->value('max_kode');

                    $newNumber = $lastNumber ? $lastNumber + 1 : 1;
                    $kode_toko = 'TK' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

                    $toko = Toko::create([
                        'kode_toko'         => $kode_toko,
                        'pemilik_toko_id'   => auth()->id(),
                        'kategori_toko_id'  => $validated['kategori_toko_id'],
                        'nama_toko'         => $validated['nama_toko'],
                        'logo_toko'         => $validated['logo_toko'] ?? null,
                        'no_hp_toko'        => $validated['no_hp_toko'],
                        'alamat_toko'       => $validated['alamat_toko'],
                        'deskripsi_toko'    => $validated['deskripsi_toko'],
                        'status_aktif_toko' => 0,
                    ]);

                    DetailToko::create([
                        'toko_id' => $toko->id,
                    ]);
                }
                DB::commit();
                return redirect()->route('verifikasitoko', ['step' => 2]);
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withInput()->withErrors(['error' => $e->getMessage()]);
            }

        case 2:
            $validated = $request->validate([
                'nama_ktp'  => 'required|string|max:255',
                'nomor_ktp' => 'required|string|max:50',
                'nomor_kk'  => 'required|string|max:50',
                'foto_ktp'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'foto_kk'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $toko = Toko::where('pemilik_toko_id', auth()->id())
                        ->where('status_aktif_toko', 0)
                        ->latest()
                        ->firstOrFail();

            $detail = $toko->detailToko;

            if ($request->hasFile('foto_ktp')) {
                $validated['foto_ktp'] = $request->file('foto_ktp')->store('foto_ktp', 'public');
            }

            if ($request->hasFile('foto_kk')) {
                $validated['foto_kk'] = $request->file('foto_kk')->store('foto_kk', 'public');
            }

            $detail->update($validated);

            return redirect()->route('verifikasitoko', ['step' => 3]);

        case 3:
            $validated = $request->validate([
                'nama_bank'             => 'nullable|string|max:255',
                'nomor_rekening'        => 'nullable|string|max:100',
                'nama_pemilik_rekening' => 'nullable|string|max:255',
            ]);

            $toko = Toko::where('pemilik_toko_id', auth()->id())
                        ->where('status_aktif_toko', 0)
                        ->latest()
                        ->firstOrFail();

            $toko->detailToko->update($validated);

            return redirect()->route('verifikasitoko', ['step' => 4]);

        case 4:
            $validated = $request->validate([
                'email_cs'       => 'nullable|email|max:255',
                'whatsapp_cs'    => 'nullable|string|max:20',
                'link_instagram' => 'nullable|string|max:255',
                'link_facebook'  => 'nullable|string|max:255',
                'link_tiktok'    => 'nullable|string|max:255',
                'link_website'   => 'nullable|string|max:255',
            ]);

            $toko = Toko::where('pemilik_toko_id', auth()->id())
                        ->where('status_aktif_toko', 0)
                        ->latest()
                        ->firstOrFail();

            $toko->detailToko->update([
                'email_cs'        => $validated['email_cs'] ?? null,
                'whatsapp_cs'     => $validated['whatsapp_cs'] ?? null,
                'link_instagram'  => $validated['link_instagram'] ?? null,
                'link_facebook'   => $validated['link_facebook'] ?? null,
                'link_tiktok'     => $validated['link_tiktok'] ?? null,
                'link_google_maps'=> $validated['link_website'] ?? null,
            ]);

            return redirect()->route('verifikasitoko', ['step' => 5]);

        case 5:
            $validated = $request->validate([
                'jadwal' => 'required|array',
            ]);

            $validDays = array_filter($validated['jadwal'], function ($data) {
                return !empty($data['buka']) && !empty($data['tutup']);
            });

            if (count($validDays) === 0) {
                return redirect()->back()->withInput()->withErrors([
                    'jadwal' => 'Minimal satu hari harus memiliki jam operasional.',
                ]);
            }

            $toko = Toko::where('pemilik_toko_id', auth()->id())
                        ->where('status_aktif_toko', 0)
                        ->latest()
                        ->firstOrFail();

            // Hapus jadwal lama dulu
            DB::table('jam_operasionals')->where('toko_id', $toko->id)->delete();

            foreach ($validDays as $hari => $data) {
                DB::table('jam_operasionals')->insert([
                    'toko_id'    => $toko->id,
                    'hari'       => $hari,
                    'buka'       => true,
                    'jam_buka'   => $data['buka'],
                    'jam_tutup'  => $data['tutup'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $toko->update(['status_aktif_toko' => 1]);

            return redirect()->route('verifikasi_toko.wait')->with('success', 'Toko berhasil didaftarkan!');
    }

    return redirect()->route('verifikasitoko', ['step' => $step + 1]);
}



// public function verifikasi_toko_store(Request $request, $step)
// {
//     $step = (int) $step;

// switch ($step) {
//     case 1:
//         session()->forget(['toko_step1', 'toko_step2', 'toko_step3', 'toko_step4', 'toko_step5']);

//         $validated = $request->validate([
//             'nama_toko' => [
//                 'required',
//                 'string',
//                 'max:255',
//                 'unique:tokos,nama_toko'
//             ],
//             'kategori_toko_id' => 'required|exists:kategori_tokos,id',

//             'no_hp_toko' => [
//                 'required',
//                 'regex:/^[1-9][0-9]{5,14}$/',
//                 'unique:tokos,no_hp_toko'
//             ],

//             'alamat_toko'    => 'required|string',
//             'deskripsi_toko' => 'nullable|string',
//             'logo_toko'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:min_width=50,min_height=50',
//         ]);

//         if ((int) $request->kategori_toko_id === 20) {
//             $request->validate([
//                 'kategori_toko' => [
//                     'required',
//                     'string',
//                     'max:255',
//                     Rule::notIn(DB::table('kategori_tokos')->pluck('nama_kategori_toko')->toArray())
//                     ]
//                 ]);

//                 $validated['kategori_toko'] = $request->input('kategori_toko');
//             }

//             if ($request->hasFile('logo_toko')) {
//                 $validated['logo_toko'] = $request->file('logo_toko')->store('logo_toko_tmp', 'public');
//             }
//             // dd($request->all());

//         session(['toko_step1' => $validated]);
//         break;
//         case 2:
//             $validated = $request->validate([
//                 'nama_ktp'  => 'required|string|max:255',
//                 'nomor_ktp' => 'required|string|max:50',
//                 'nomor_kk'  => 'required|string|max:50',
//                 'foto_ktp'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
//                 'foto_kk'   => 'required|image|mimes:jpg,jpeg,png|max:2048',
//             ]);

//             $validated['foto_ktp'] = $request->file('foto_ktp')->store('foto_ktp_tmp', 'public');
//             $validated['foto_kk']  = $request->file('foto_kk')->store('foto_kk_tmp', 'public');

//             session(['toko_step2' => $validated]);
//             break;

//         case 3:
//             $validated = $request->validate([
//                 'nama_bank'             => 'nullable|string|max:255',
//                 'nomor_rekening'        => 'nullable|string|max:100',
//                 'nama_pemilik_rekening' => 'nullable|string|max:255',
//             ]);
//             session(['toko_step3' => $validated]);
//             break;

//         case 4:
//             $validated = $request->validate([
//                 'email_cs'       => 'nullable|email|max:255',
//                 'whatsapp_cs'    => 'nullable|string|max:20',
//                 'link_instagram' => 'nullable|string|max:255',
//                 'link_facebook'  => 'nullable|string|max:255',
//                 'link_tiktok'    => 'nullable|string|max:255',
//                 'link_website'   => 'nullable|string|max:255',
//             ]);
//             session(['toko_step4' => $validated]);
//             break;
// case 5:
//     $validated = $request->validate([
//         'jadwal' => 'required|array',
//     ]);

//     // Validasi: minimal 1 hari memiliki jam buka dan tutup
//     $validDays = array_filter($validated['jadwal'], function ($data) {
//         return !empty($data['buka']) && !empty($data['tutup']);
//     });

//     if (count($validDays) === 0) {
//         return redirect()->back()->withInput()->withErrors([
//             'jadwal' => 'Minimal satu hari harus memiliki jam operasional (buka & tutup).',
//         ]);
//     }

//     // Simpan ke session seluruh jadwal (baik kosong maupun yang terisi)
//     session(['toko_step5' => [
//         'jadwal' => $validated['jadwal'],
//     ]]);

//     return $this->saveToko();
//     }

//     return redirect()->route('verifikasitoko', ['step' => $step + 1]);
// }

// public function saveToko()
// {
//     DB::beginTransaction();
//     try {
//         $step1 = session('toko_step1');
//         $step2 = session('toko_step2');
//         $step3 = session('toko_step3');
//         $step4 = session('toko_step4');
//         $step5 = session('toko_step5');

//         $lastNumber = DB::table('tokos')
//             ->where('kode_toko', 'LIKE', 'TK%')
//             ->whereRaw("SUBSTRING(kode_toko, 3) ~ '^[0-9]+$'") // pastikan setelah TK adalah angka
//             ->select(DB::raw("MAX(CAST(SUBSTRING(kode_toko, 3) AS INTEGER)) AS max_kode"))
//             ->value('max_kode');

//         $newNumber = $lastNumber ? $lastNumber + 1 : 1;

//         $kode_toko = 'TK' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

// // dd($kode_toko);


//         $toko = Toko::create([
//             'kode_toko'         => $kode_toko,
//             'pemilik_toko_id'   => auth()->id(),
//             'kategori_toko_id'  => $step1['kategori_toko_id'],
//             'nama_toko'         => $step1['nama_toko'],
//             'logo_toko'         => $step1['logo_toko'] ?? null,
//             'no_hp_toko'        => $step1['no_hp_toko'],
//             'alamat_toko'       => $step1['alamat_toko'],
//             'deskripsi_toko'    => $step1['deskripsi_toko'],
//             'status_aktif_toko' => 1,
//         ]);

//         DetailToko::create([
//             'toko_id'               => $toko->id,
//             'nama_bank'             => $step3['nama_bank'] ?? null,
//             'nomor_rekening'        => $step3['nomor_rekening'] ?? null,
//             'nama_pemilik_rekening' => $step3['nama_pemilik_rekening'] ?? null,
//             'email_cs'              => $step4['email_cs'] ?? null,
//             'whatsapp_cs'           => $step4['whatsapp_cs'] ?? null,
//             'link_instagram'        => $step4['link_instagram'] ?? null,
//             'link_facebook'         => $step4['link_facebook'] ?? null,
//             'link_tiktok'           => $step4['link_tiktok'] ?? null,
//             'link_google_maps'      => $step4['link_website'] ?? null,
//             'catatan_tambahan'      => null,
//             'nomor_ktp'             => $step2['nomor_ktp'],
//             'nomor_kk'              => $step2['nomor_kk'],
//             'nama_ktp'              => $step2['nama_ktp'],
//             'foto_ktp'              => $step2['foto_ktp'],
//             'foto_kk'               => $step2['foto_kk'],
//         ]);

//         foreach ($step5['jadwal'] as $hari => $data) {
//             if (!empty($data['buka']) && !empty($data['tutup'])) {
//                 DB::table('jam_operasionals')->insert([
//                     'toko_id'    => $toko->id,
//                     'hari'       => $hari,
//                     'buka'       => true,
//                     'jam_buka'   => $data['buka'],
//                     'jam_tutup'  => $data['tutup'],
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//             }
//         }


//         DB::commit();
//         session()->forget(['toko_step1', 'toko_step2', 'toko_step3', 'toko_step4', 'toko_step5']);

//         return redirect()->route('verifikasi_toko.wait')->with('success', 'Toko berhasil didaftarkan.');
//     } catch (\Exception $e) {
//         DB::rollBack();
//         dd($e->getMessage());
//         return redirect()->route('verifikasitoko', ['step' => 5])
//             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
//     }
// }

    public function waitPage()
    {
        $user = auth()->user();
        $toko = Toko::where('pemilik_toko_id', $user->id)->latest()->first();

        if (!$toko) {
            // return view('toko.wrapper');
            return redirect()->route('verifikasitoko');

        }

        // dd($toko);
        switch ($toko->status_toko) {
            case 'izinkan':
                return redirect()->route('dashboard');
            case 'tidak_diizinkan':
                return view('toko.reject', compact('toko'));
            case 'proses':
            default:
                return view('toko.wait', compact('toko'));
        }
    }
    public function dashboard_toko()
    {
        return view('toko.dashboard');
    }

}
