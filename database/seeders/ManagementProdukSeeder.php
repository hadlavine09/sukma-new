<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManagementProdukSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed kategori_tokos
        $kategoriTokos = [
            ['kode_kategori_toko' => 'KTK001', 'nama_kategori_toko' => 'Makanan & Minuman'],
            ['kode_kategori_toko' => 'KTK002', 'nama_kategori_toko' => 'Elektronik'],
            ['kode_kategori_toko' => 'KTK003', 'nama_kategori_toko' => 'Fashion'],
            ['kode_kategori_toko' => 'KTK004', 'nama_kategori_toko' => 'Kecantikan & Perawatan Diri'],
            ['kode_kategori_toko' => 'KTK005', 'nama_kategori_toko' => 'Kesehatan'],
            ['kode_kategori_toko' => 'KTK006', 'nama_kategori_toko' => 'Ibu & Bayi'],
            ['kode_kategori_toko' => 'KTK007', 'nama_kategori_toko' => 'Rumah Tangga'],
            ['kode_kategori_toko' => 'KTK008', 'nama_kategori_toko' => 'Otomotif'],
            ['kode_kategori_toko' => 'KTK009', 'nama_kategori_toko' => 'Hobi & Koleksi'],
            ['kode_kategori_toko' => 'KTK010', 'nama_kategori_toko' => 'Mainan & Anak-anak'],
            ['kode_kategori_toko' => 'KTK011', 'nama_kategori_toko' => 'Olahraga & Outdoor'],
            ['kode_kategori_toko' => 'KTK012', 'nama_kategori_toko' => 'Buku & Alat Tulis'],
            ['kode_kategori_toko' => 'KTK013', 'nama_kategori_toko' => 'Komputer & Aksesoris'],
            ['kode_kategori_toko' => 'KTK014', 'nama_kategori_toko' => 'Gaming'],
            ['kode_kategori_toko' => 'KTK015', 'nama_kategori_toko' => 'Properti & Kontrakan'],
            ['kode_kategori_toko' => 'KTK016', 'nama_kategori_toko' => 'Jasa & Layanan'],
            ['kode_kategori_toko' => 'KTK017', 'nama_kategori_toko' => 'Pertanian & Peternakan'],
            ['kode_kategori_toko' => 'KTK018', 'nama_kategori_toko' => 'Hewan Peliharaan'],
            ['kode_kategori_toko' => 'KTK019', 'nama_kategori_toko' => 'Produk Digital'],
            ['kode_kategori_toko' => 'KTK020', 'nama_kategori_toko' => 'Lain-lain'],
        ];
        foreach ($kategoriTokos as &$item) {
            $item['created_at'] = $item['updated_at'] = Carbon::now();
        }
        DB::table('kategori_tokos')->insert($kategoriTokos);
        $kategoriToko = DB::table('kategori_tokos')->pluck('id', 'kode_kategori_toko');

        // 2. kategori_produks
        // 2. kategori_produks
        $kategoriProduksRaw = [
            ['KTK001', 'Makanan Siap Saji'],
            ['KTK001', 'Minuman Segar'],
            ['KTK002', 'Peralatan Elektronik'],
            ['KTK002', 'Aksesoris Elektronik'],
            ['KTK003', 'Fashion Pria'],
            ['KTK003', 'Fashion Wanita'],
            ['KTK004', 'Perawatan Kulit'],
            ['KTK004', 'Kosmetik'],
            ['KTK005', 'Obat-obatan'],
            ['KTK005', 'Alat Kesehatan'],
            ['KTK006', 'Perlengkapan Bayi'],
            ['KTK006', 'Makanan Bayi'],
            ['KTK007', 'Peralatan Rumah Tangga'],
            ['KTK007', 'Dekorasi'],
            ['KTK008', 'Suku Cadang'],
            ['KTK008', 'Aksesoris Kendaraan'],
            ['KTK009', 'Barang Koleksi'],
            ['KTK009', 'Kerajinan'],
            ['KTK010', 'Mainan Edukasi'],
            ['KTK010', 'Boneka'],
            ['KTK011', 'Peralatan Olahraga'],
            ['KTK011', 'Pakaian Olahraga'],
            ['KTK012', 'Buku Sekolah'],
            ['KTK012', 'Alat Tulis'],
            ['KTK013', 'Komputer'],
            ['KTK013', 'Aksesoris Komputer'],
            ['KTK014', 'Konsol Game'],
            ['KTK014', 'Aksesoris Gaming'],
            ['KTK015', 'Rumah Disewakan'],
            ['KTK015', 'Ruko Dijual'],
            ['KTK016', 'Jasa Kebersihan'],
            ['KTK016', 'Jasa Teknologi'],
            ['KTK017', 'Bibit Tanaman'],
            ['KTK017', 'Pakan Ternak'],
            ['KTK018', 'Makanan Hewan'],
            ['KTK018', 'Aksesoris Hewan'],
            ['KTK019', 'Voucher Game'],
            ['KTK019', 'Produk Digital Lainnya'],
            ['KTK020', 'Produk Tidak Berkategori Spesifik'],
        ];

        $kategoriProduks = [];
        foreach ($kategoriProduksRaw as $i => $item) {
            $kategoriProduks[] = [
                'kode_kategori_produk' => 'KTP' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama_kategori_produk' => $item[1],
                'kategori_toko_id' => $kategoriToko[$item[0]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('kategori_produks')->insert($kategoriProduks);
        $kategoriProduk = DB::table('kategori_produks')->pluck('id', 'nama_kategori_produk');
// 3. Atribut Produk & Opsi Lengkap berdasarkan kategori toko
$atributByKategoriToko = [
    'Makanan & Minuman' => [
        'Rasa' => ['Pedas', 'Manis', 'Asin', 'Gurih'],
        'Kemasan' => ['Plastik', 'Box', 'Kaleng'],
    ],
    'Elektronik' => [
        'Garansi' => ['1 Tahun', '2 Tahun', 'Tanpa Garansi'],
        'Daya' => ['100W', '250W', '500W'],
    ],
    'Fashion' => [
        'Size' => ['S', 'M', 'L', 'XL', 'XXL'],
        'Warna' => ['Merah', 'Biru', 'Hitam', 'Putih', 'Abu-abu'],
    ],
    'Kecantikan & Perawatan Diri' => [
        'Jenis Kulit' => ['Normal', 'Berminyak', 'Kering', 'Sensitif'],
        'Fungsi' => ['Whitening', 'Anti Aging', 'Moisturizer'],
    ],
    'Kesehatan' => [
        'Jenis Produk' => ['Obat', 'Suplemen', 'Vitamin'],
        'Dosis' => ['100mg', '250mg', '500mg'],
    ],
    'Ibu & Bayi' => [
        'Ukuran' => ['0-3 bulan', '3-6 bulan', '6-12 bulan'],
        'Bahan' => ['Katun', 'Bamboo', 'Fleece'],
    ],
    'Rumah Tangga' => [
        'Bahan' => ['Kayu', 'Plastik', 'Stainless'],
        'Ukuran' => ['Kecil', 'Sedang', 'Besar'],
    ],
    'Otomotif' => [
        'Jenis' => ['Suku Cadang', 'Aksesoris'],
        'Kendaraan' => ['Mobil', 'Motor'],
    ],
    'Hobi & Koleksi' => [
        'Tipe' => ['Langka', 'Umum'],
        'Bahan' => ['Kayu', 'Kaca', 'Kain'],
    ],
    'Mainan & Anak-anak' => [
        'Usia' => ['1-3 tahun', '3-5 tahun', '5-10 tahun'],
        'Jenis Mainan' => ['Edukatif', 'Boneka', 'Puzzle'],
    ],
    'Olahraga & Outdoor' => [
        'Ukuran' => ['S', 'M', 'L'],
        'Jenis' => ['Indoor', 'Outdoor'],
    ],
    'Buku & Alat Tulis' => [
        'Jenis' => ['Buku Tulis', 'Alat Gambar', 'Pensil'],
        'Level' => ['TK', 'SD', 'SMP', 'SMA'],
    ],
    'Komputer & Aksesoris' => [
        'Tipe Port' => ['USB', 'HDMI', 'Type-C'],
        'Garansi' => ['1 Tahun', '2 Tahun'],
    ],
    'Gaming' => [
        'Platform' => ['PC', 'Playstation', 'Xbox', 'Nintendo'],
        'Jenis Game' => ['RPG', 'Shooter', 'Sport'],
    ],
    'Properti & Kontrakan' => [
        'Status' => ['Disewakan', 'Dijual'],
        'Tipe' => ['Rumah', 'Ruko', 'Apartemen'],
    ],
    'Jasa & Layanan' => [
        'Jenis Layanan' => ['Kebersihan', 'Teknologi', 'Desain'],
        'Waktu' => ['Harian', 'Mingguan', 'Bulanan'],
    ],
    'Pertanian & Peternakan' => [
        'Jenis' => ['Bibit', 'Pakan', 'Alat'],
        'Kualitas' => ['Unggul', 'Reguler'],
    ],
    'Hewan Peliharaan' => [
        'Jenis Hewan' => ['Kucing', 'Anjing', 'Ikan'],
        'Tipe Produk' => ['Makanan', 'Aksesoris', 'Kesehatan'],
    ],
    'Produk Digital' => [
        'Tipe' => ['Top Up', 'Voucher', 'Aplikasi'],
        'Platform' => ['Android', 'iOS', 'Web'],
    ],
    'Lain-lain' => [
        'Kategori' => ['Umum', 'Langka'],
        'Keterangan' => ['Custom', 'Pre-order'],
    ],
];

foreach ($kategoriProduk as $namaKategoriProduk => $kategoriProdukId) {
    // Cari kategori toko terkait
    $kategoriProdukRow = DB::table('kategori_produks')->where('id', $kategoriProdukId)->first();
    if (!$kategoriProdukRow) continue;

    $kategoriTokoRow = DB::table('kategori_tokos')->where('id', $kategoriProdukRow->kategori_toko_id)->first();
    if (!$kategoriTokoRow) continue;

    $namaKategoriToko = $kategoriTokoRow->nama_kategori_toko;

    // Jika kategori toko memiliki atribut mapping
    if (!isset($atributByKategoriToko[$namaKategoriToko])) continue;

    foreach ($atributByKategoriToko[$namaKategoriToko] as $namaAtribut => $opsiList) {
        $atributId = DB::table('atribut_produks')->insertGetId([
            'kategori_produk_id' => $kategoriProdukId,
            'nama_atribut' => $namaAtribut,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($opsiList as $opsi) {
            DB::table('opsi_atributs')->insert([
                'atribut_produk_id' => $atributId,
                'opsi' => $opsi,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}


        // 3. tags
        $tags = [
            ['kode' => 'TG001', 'nama' => 'Pedas', 'kategori' => 'Makanan Siap Saji'],
            ['kode' => 'TG002', 'nama' => 'Gurih', 'kategori' => 'Makanan Siap Saji'],
            ['kode' => 'TG003', 'nama' => 'Dingin', 'kategori' => 'Minuman Segar'],
            ['kode' => 'TG004', 'nama' => 'Segar Alami', 'kategori' => 'Minuman Segar'],

            ['kode' => 'TG005', 'nama' => 'Terlaris', 'kategori' => 'Peralatan Elektronik'],
            ['kode' => 'TG006', 'nama' => 'Garansi Resmi', 'kategori' => 'Peralatan Elektronik'],
            ['kode' => 'TG007', 'nama' => 'Stylish', 'kategori' => 'Aksesoris Elektronik'],
            ['kode' => 'TG008', 'nama' => 'Kabel Panjang', 'kategori' => 'Aksesoris Elektronik'],

            ['kode' => 'TG009', 'nama' => 'Kekinian', 'kategori' => 'Fashion Pria'],
            ['kode' => 'TG010', 'nama' => 'Diskon Besar', 'kategori' => 'Fashion Pria'],
            ['kode' => 'TG011', 'nama' => 'Modis', 'kategori' => 'Fashion Wanita'],
            ['kode' => 'TG012', 'nama' => 'Hijab Friendly', 'kategori' => 'Fashion Wanita'],

            ['kode' => 'TG013', 'nama' => 'Viral', 'kategori' => 'Perawatan Kulit'],
            ['kode' => 'TG014', 'nama' => 'Halal', 'kategori' => 'Perawatan Kulit'],
            ['kode' => 'TG015', 'nama' => 'Tahan Lama', 'kategori' => 'Kosmetik'],
            ['kode' => 'TG016', 'nama' => 'No Alkohol', 'kategori' => 'Kosmetik'],

            ['kode' => 'TG017', 'nama' => 'BPOM Terdaftar', 'kategori' => 'Obat-obatan'],
            ['kode' => 'TG018', 'nama' => 'Aman Digunakan', 'kategori' => 'Alat Kesehatan'],

            ['kode' => 'TG019', 'nama' => 'Lembut', 'kategori' => 'Perlengkapan Bayi'],
            ['kode' => 'TG020', 'nama' => 'Sehat & Bergizi', 'kategori' => 'Makanan Bayi'],

            ['kode' => 'TG021', 'nama' => 'Fungsi Lengkap', 'kategori' => 'Peralatan Rumah Tangga'],
            ['kode' => 'TG022', 'nama' => 'Estetik', 'kategori' => 'Dekorasi'],

            ['kode' => 'TG023', 'nama' => 'Original', 'kategori' => 'Suku Cadang'],
            ['kode' => 'TG024', 'nama' => 'Keren', 'kategori' => 'Aksesoris Kendaraan'],

            ['kode' => 'TG025', 'nama' => 'Langka', 'kategori' => 'Barang Koleksi'],
            ['kode' => 'TG026', 'nama' => 'Unik', 'kategori' => 'Kerajinan'],

            ['kode' => 'TG027', 'nama' => 'Edukasi Anak', 'kategori' => 'Mainan Edukasi'],
            ['kode' => 'TG028', 'nama' => 'Lucu', 'kategori' => 'Boneka'],

            ['kode' => 'TG029', 'nama' => 'Anti Slip', 'kategori' => 'Peralatan Olahraga'],
            ['kode' => 'TG030', 'nama' => 'Ringan & Nyaman', 'kategori' => 'Pakaian Olahraga'],

            ['kode' => 'TG031', 'nama' => 'Populer', 'kategori' => 'Buku Sekolah'],
            ['kode' => 'TG032', 'nama' => 'Komplit', 'kategori' => 'Alat Tulis'],

            ['kode' => 'TG033', 'nama' => 'High Performance', 'kategori' => 'Komputer'],
            ['kode' => 'TG034', 'nama' => 'Terjangkau', 'kategori' => 'Aksesoris Komputer'],

            ['kode' => 'TG035', 'nama' => 'Baru Rilis', 'kategori' => 'Konsol Game'],
            ['kode' => 'TG036', 'nama' => 'Limited Edition', 'kategori' => 'Aksesoris Gaming'],

            ['kode' => 'TG037', 'nama' => 'Disewakan Cepat', 'kategori' => 'Rumah Disewakan'],
            ['kode' => 'TG038', 'nama' => 'Lokasi Strategis', 'kategori' => 'Ruko Dijual'],

            ['kode' => 'TG039', 'nama' => 'Bersih & Wangi', 'kategori' => 'Jasa Kebersihan'],
            ['kode' => 'TG040', 'nama' => 'Professional', 'kategori' => 'Jasa Teknologi'],

            ['kode' => 'TG041', 'nama' => 'Bibit Unggul', 'kategori' => 'Bibit Tanaman'],
            ['kode' => 'TG042', 'nama' => 'Hemat', 'kategori' => 'Pakan Ternak'],

            ['kode' => 'TG043', 'nama' => 'Disukai Kucing', 'kategori' => 'Makanan Hewan'],
            ['kode' => 'TG044', 'nama' => 'Lucu & Aman', 'kategori' => 'Aksesoris Hewan'],

            ['kode' => 'TG045', 'nama' => 'Top Up Cepat', 'kategori' => 'Voucher Game'],
            ['kode' => 'TG046', 'nama' => 'Instant Access', 'kategori' => 'Produk Digital Lainnya'],

            ['kode' => 'TG047', 'nama' => 'Murah Meriah', 'kategori' => 'Produk Tidak Berkategori Spesifik'],
        ];

        $tagsFinal = [];
        foreach ($tags as $tag) {
            $tagsFinal[] = [
                'kode_tag' => $tag['kode'],
                'nama_tag' => $tag['nama'],
                'kategori_produk_id' => $kategoriProduk[$tag['kategori']],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('tags')->insert($tagsFinal);

        // 4. toko
        $toko = [
            'kode_toko' => 'TOKO001',
            'pemilik_toko_id' => 2,
            'kategori_toko_id' => $kategoriToko['KTK001'],
            'nama_toko' => 'Toko Makanan Enak',
            'logo_toko' => 'default_logo.png',
            'no_hp_toko' => '081234567890',
            'alamat_toko' => 'Jl. Contoh No. 123, Jakarta',
            'deskripsi_toko' => 'Menjual berbagai makanan siap saji dan minuman segar.',
            'status_toko' => 'izinkan',
            'status_aktif_toko' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $tokoId = DB::table('tokos')->insertGetId($toko);

        // 5. detail toko
        $detail = [
            'toko_id' => $tokoId,
            'nama_ktp' => 'Admin Toko',
            'nomor_ktp' => '2345678901234567',
            'nomor_kk' => '1122334455667788',
            'foto_ktp' => 'ktp_admin.jpg',
            'foto_kk' => 'kk_admin.jpg',
            'nama_bank' => 'Bank Contoh',
            'nomor_rekening' => '1234567890',
            'nama_pemilik_rekening' => 'Admin Toko',
            'email_cs' => 'cs@tokomakanan.com',
            'whatsapp_cs' => '081234567890',
            'link_instagram' => 'https://instagram.com/tokomakanan',
            'link_facebook' => 'https://facebook.com/tokomakanan',
            'link_tiktok' => 'https://tiktok.com/@tokomakanan',
            'link_google_maps' => 'https://goo.gl/maps/example',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('detail_tokos')->insert($detail);

        // 6. izin toko
        $izin = [
            'toko_id' => $tokoId,
            'nomor_izin' => 'IZIN-001-2025',
            'nama_dokumen' => 'Surat Izin Usaha Toko',
            'file_dokumen' => 'izin_toko001.pdf',
            'tanggal_terbit' => now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('izin_tokos')->insert($izin);

    }
}
