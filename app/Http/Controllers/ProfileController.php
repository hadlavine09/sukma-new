<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    public function getUsers()
    {
        $users = DB::table('users')->get(['id', 'name', 'email', 'username', 'no_hp', 'no_ktp', 'profile', 'email_verified_at', 'password', 'google_id', 'avatar', 'remember_token', 'created_at', 'updated_at']);

        // Tambahkan field `foto_ktp` dummy secara manual ke tiap user
        $users->transform(function ($user) {
            $user->foto_ktp = asset('assets_profile/images/dummy-ktp.jpg'); // path ke dummy KTP
            return $user;
        });

        return response()->json($users);
    }

    public function bankKartu()
    {
        return view('frontend.profile.bank_kartu');
    }
    public function tambahBank(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required',
            'no_rekening' => 'required',
            'nama_pemilik' => 'required',
        ]);

        DB::table('bank_user')->insert([
            'user_id' => Auth::id(),
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'nama_pemilik' => $request->nama_pemilik,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Data bank berhasil ditambahkan.');
    }

    public function alamat()
    {
        $userId = Auth::id();

        // Dummy data dengan struktur flat (user_id bisa sama lebih dari satu)
        $dummyAlamat = [
            [
                'user_id' => 1,
                'nama_penerima' => 'Rina Kartika',
                'telepon' => '081234567890',
                'alamat_lengkap' => 'Jl. Mawar No. 10, RT 03 RW 05, Kel. Sukamukti, Kec. Sukamukti',
                'kecamatan' => 'Sukamukti',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40286',
                'label' => 'Rumah',
                'utama' => true,
            ],
            [
                'user_id' => 2,
                'nama_penerima' => 'Dedi Setiawan',
                'telepon' => '082345678912',
                'alamat_lengkap' => 'Perumahan Melati Blok B2 No.5, Kel. Sukasari',
                'kecamatan' => 'Sukasari',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40152',
                'label' => 'Kantor',
                'utama' => false,
            ],
            [
                'user_id' => 2,
                'nama_penerima' => 'Ibu Rini',
                'telepon' => '081999888777',
                'alamat_lengkap' => 'Jl. Cempaka No. 22, Kec. Cibiru',
                'kecamatan' => 'Cibiru',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40625',
                'label' => 'Rumah',
                'utama' => true,
            ],
            [
                'user_id' => 3,
                'nama_penerima' => 'Agus Suryana',
                'telepon' => '089612345678',
                'alamat_lengkap' => 'Desa Sukamulya RT 04 RW 02',
                'kecamatan' => 'Ciparay',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40381',
                'label' => 'Kampung',
                'utama' => true,
            ],
            [
                'user_id' => 4,
                'nama_penerima' => 'Nur Nurhaliza',
                'telepon' => '087811223344',
                'alamat_lengkap' => 'Jl. Anggrek No. 8, Kompleks Sakura',
                'kecamatan' => 'Antapani',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40291',
                'label' => 'Apartemen',
                'utama' => false,
            ],
            [
                'user_id' => 4,
                'nama_penerima' => 'Siti Nurhaliza',
                'telepon' => '087811223344',
                'alamat_lengkap' => 'Jl. Anggrek No. 8, Kompleks Sakura',
                'kecamatan' => 'Antapani',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40291',
                'label' => 'Apartemen',
                'utama' => true,
            ],
            [
                'user_id' => 4,
                'nama_penerima' => 'Nur Halimah',
                'telepon' => '085622334455',
                'alamat_lengkap' => 'Jl. Dahlia No. 12',
                'kecamatan' => 'Kiaracondong',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40285',
                'label' => 'Toko',
                'utama' => false,
            ],
        ];

        // Filter hanya alamat milik user yang sedang login
        $alamat_user = array_values(
            array_filter($dummyAlamat, function ($item) use ($userId) {
                return $item['user_id'] === $userId;
            }),
        );

        // Jika hanya satu alamat, tetapkan sebagai utama
        if (count($alamat_user) === 1) {
            $alamat_user[0]['utama'] = true;
        }

        return view('frontend.profile.alamat', compact('alamat_user'));
    }

    public function ubahPassword()
    {
        $user = Auth::user();
        $passwordCache = Cache::get('user_password_' . $user->id);
        $isVerified = Cache::has('user_password_' . $user->id);

        return view('frontend.profile.ubah_password', compact('passwordCache', 'isVerified'));
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        Cache::forget('user_password_' . $user->id); // bersihkan cache setelah ubah

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function verifikasiPassword(Request $request)
    {
        $request->validate([
            'verifikasi_password' => ['required'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->verifikasi_password, $user->password)) {
            return back()->withErrors(['verifikasi_password' => 'Password salah.']);
        }

        Cache::put('user_password_' . $user->id, $request->verifikasi_password, now()->addMinutes(5));

        return back()->with('success', 'Password berhasil diverifikasi.');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        Auth::logout();
        Cache::forget('user_password_' . $user->id);

        $user->delete();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
    public function notifikasiSetting()
    {
        return view('frontend.profile.notifikasi_setting');
    }
    public function privasiSetting()
    {
        return view('frontend.profile.privasi_setting');
    }

    public function pesanan()
    {
        $pesanan = [
            [
                'id' => 1,
                'kode' => 'INV20250701A',
                'produk' => 'Alat Pijat Leher Manual Relaxing Neck Massager Therapy - MCR35',
                'variasi' => '6 BOLA',
                'jumlah' => 1,
                'harga_asli' => 30000,
                'harga' => 20000,
                'proteksi' => 500,
                'ongkir' => 9000,
                'diskon_ongkir' => 9000,
                'biaya_layanan' => 2500,
                'total' => 23000,
                'metode_pembayaran' => 'Bank BRI',
                'nama_toko' => 'Akom Store12',
                'gambar' => 'images/product-sample.jpg',
                'status' => 'Selesai',
                'tanggal' => '2025-07-02',
            ],
            [
                'id' => 2,
                'kode' => 'INV20250701B',
                'produk' => 'Kaos Polos Cotton Combed 30s',
                'variasi' => 'Hitam / L',
                'jumlah' => 2,
                'harga_asli' => 50000,
                'harga' => 45000,
                'proteksi' => 0,
                'ongkir' => 10000,
                'diskon_ongkir' => 10000,
                'biaya_layanan' => 2000,
                'total' => 92000,
                'metode_pembayaran' => 'ShopeePay',
                'nama_toko' => 'Kaos Pria Store',
                'gambar' => 'images/product-sample.jpg',
                'status' => 'Belum Bayar',
                'tanggal' => '2025-07-01',
            ],
            [
                'id' => 3,
                'kode' => 'INV20250701C',
                'produk' => 'Sepatu Sneakers Pria',
                'variasi' => 'Putih / 42',
                'jumlah' => 1,
                'harga_asli' => 250000,
                'harga' => 225000,
                'proteksi' => 0,
                'ongkir' => 15000,
                'diskon_ongkir' => 15000,
                'biaya_layanan' => 2500,
                'total' => 227500,
                'metode_pembayaran' => 'COD',
                'nama_toko' => 'Sepatu Keren Official',
                'gambar' => 'images/product-sample.jpg',
                'status' => 'Diproses',
                'tanggal' => '2025-07-01',
            ],
            [
                'id' => 4,
                'kode' => 'INV20250701D',
                'produk' => 'Jam Tangan Digital LED Waterproof',
                'variasi' => 'Hitam',
                'jumlah' => 1,
                'harga_asli' => 75000,
                'harga' => 70000,
                'proteksi' => 0,
                'ongkir' => 10000,
                'diskon_ongkir' => 10000,
                'biaya_layanan' => 2500,
                'total' => 72500,
                'metode_pembayaran' => 'Bank BCA',
                'nama_toko' => 'JamTangan365',
                'gambar' => 'images/product-sample.jpg',
                'status' => 'Dikirim',
                'tanggal' => '2025-07-01',
            ],
            [
                'id' => 5,
                'kode' => 'INV20250701E',
                'produk' => 'Tas Ransel Laptop Anti Air',
                'variasi' => 'Abu-abu',
                'jumlah' => 1,
                'harga_asli' => 100000,
                'harga' => 90000,
                'proteksi' => 0,
                'ongkir' => 12000,
                'diskon_ongkir' => 10000,
                'biaya_layanan' => 2500,
                'total' => 94500,
                'metode_pembayaran' => 'ShopeePay',
                'nama_toko' => 'BagZone Official',
                'gambar' => 'images/product-sample.jpg',
                'status' => 'Dibatalkan',
                'tanggal' => '2025-06-30',
            ],
        ];

        return view('frontend.profile.pesanan', compact('pesanan'));
    }

    public function detailPesanan($id)
    {
        $pesananList = [
            [
                'id' => 1,
                'kode' => 'INV20250701A',
                'produk' => 'Alat Pijat Leher Manual Relaxing Neck Massager Therapy - MCR35',
                'variasi' => '6 BOLA',
                'jumlah' => 1,
                'harga_asli' => 30000,
                'harga' => 20000,
                'proteksi' => 500,
                'ongkir' => 9000,
                'diskon_ongkir' => 9000,
                'biaya_layanan' => 2500,
                'total' => 23000,
                'metode_pembayaran' => 'Bank BRI',
                'nama_toko' => 'Akom Store12',
                'gambar' => 'images/product-sample.jpg',
                'status' => 'Selesai',
                'tanggal' => '2025-07-02',
                'nama_penerima' => 'Suci Nur Fitri',
                'no_hp' => '083824068504',
                'alamat' => 'RT.4/RW.3, Kp Ciodeng 1, Baleendah, Bandung',
                'tracking' => [['waktu' => '2025-07-05 10:06', 'status' => 'Terkirim', 'detail' => 'Pesanan tiba di alamat tujuan. Diterima oleh anggota keluarga.'], ['waktu' => '2025-07-05 07:06', 'status' => 'Pesanan dalam Pengiriman', 'detail' => 'Pesanan sedang dikirim oleh kurir'], ['waktu' => '2025-07-04 21:10', 'status' => 'Pesanan Diproses', 'detail' => 'Pesanan dikemas dan siap dikirim']],
            ],
            [
                'id' => 2,
                'kode' => 'INV20250701B',
                'produk' => 'Kaos Polos Cotton Combed 30s',
                'variasi' => 'Hitam / L',
                'jumlah' => 2,
                'harga_asli' => 50000,
                'harga' => 45000,
                'proteksi' => 0,
                'ongkir' => 10000,
                'diskon_ongkir' => 10000,
                'biaya_layanan' => 2000,
                'total' => 92000,
                'metode_pembayaran' => 'ShopeePay',
                'nama_toko' => 'Kaos Pria Store',
                'gambar' => 'images/product-sample.jpg',
                'status' => 'Belum Bayar',
                'tanggal' => '2025-07-01',
                'nama_penerima' => 'Andi Saputra',
                'no_hp' => '085612345678',
                'alamat' => 'Jl. Melati No.12, Cijerah, Bandung',
                'tracking' => [],
            ],
            [
                'id' => 3,
                'kode' => 'INV20250701C',
                'produk' => 'Sepatu Sneakers Pria',
                'variasi' => 'Putih / 42',
                'jumlah' => 1,
                'harga_asli' => 250000,
                'harga' => 225000,
                'proteksi' => 0,
                'ongkir' => 15000,
                'diskon_ongkir' => 15000,
                'biaya_layanan' => 2500,
                'total' => 227500,
                'metode_pembayaran' => 'COD',
                'nama_toko' => 'Sepatu Keren Official',
                'gambar' => 'images/product-sample.jpg',
                'status' => 'Diproses',
                'tanggal' => '2025-07-01',
                'nama_penerima' => 'Rina Oktaviani',
                'no_hp' => '087812345678',
                'alamat' => 'Jl. Cibaduyut Raya No.45, Bandung',
                'tracking' => [['waktu' => '2025-07-02 10:00', 'status' => 'Pesanan Diproses', 'detail' => 'Pesanan dikemas oleh penjual']],
            ],
            [
                'id' => 4,
                'kode' => 'INV20250701D',
                'produk' => 'Jam Tangan Digital LED Waterproof',
                'variasi' => 'Hitam',
                'jumlah' => 1,
                'harga_asli' => 75000,
                'harga' => 70000,
                'proteksi' => 0,
                'ongkir' => 10000,
                'diskon_ongkir' => 10000,
                'biaya_layanan' => 2500,
                'total' => 72500,
                'metode_pembayaran' => 'Bank BCA',
                'nama_toko' => 'JamTangan365',
                'gambar' => 'images/product-sample.jpg',
                'status' => 'Dikirim',
                'tanggal' => '2025-07-01',
                'nama_penerima' => 'Fajar Ramadhan',
                'no_hp' => '089612345678',
                'alamat' => 'Komplek Bumi Asri Blok C2 No.8, Cimahi',
                'tracking' => [['waktu' => '2025-07-03 15:45', 'status' => 'Pesanan dalam Pengiriman', 'detail' => 'Sedang dalam perjalanan']],
            ],
            [
                'id' => 5,
                'kode' => 'INV20250701E',
                'produk' => 'Tas Ransel Laptop Anti Air',
                'variasi' => 'Abu-abu',
                'jumlah' => 1,
                'harga_asli' => 100000,
                'harga' => 90000,
                'proteksi' => 0,
                'ongkir' => 12000,
                'diskon_ongkir' => 10000,
                'biaya_layanan' => 2500,
                'total' => 94500,
                'metode_pembayaran' => 'ShopeePay',
                'nama_toko' => 'BagZone Official',
                'gambar' => 'images/product-sample.jpg',
                'status' => 'Dibatalkan',
                'tanggal' => '2025-06-30',
                'nama_penerima' => 'Linda Wahyuni',
                'no_hp' => '081234567890',
                'alamat' => 'Perumahan Griya Damai No.10, Soreang, Bandung',
                'tracking' => [['waktu' => '2025-07-01 09:00', 'status' => 'Pesanan Dibatalkan', 'detail' => 'Pesanan dibatalkan karena melebihi batas waktu pembayaran']],
            ],
        ];

        $pesanan = collect($pesananList)->firstWhere('id', (int) $id);

        if (!$pesanan) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        return view('frontend.profile.detail_pesanan', compact('pesanan'));
    }

    public function notifikasi()
    {
        return view('frontend.profile.notifikasi');
    }
    public function voucher()
    {
        return view('frontend.profile.voucher');
    }
    public function koin()
    {
        return view('frontend.profile.koin');
    }
}
