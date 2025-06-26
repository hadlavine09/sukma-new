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
        $kategoriProduksRaw = [
            ['KTK001', 'Makanan Siap Saji'],
            ['KTK001', 'Minuman (Kopi, Jus, Teh)'],
            ['KTK001', 'Kue & Roti'],
            ['KTK003', 'Fashion Pria'],
            ['KTK004', 'Skincare'],
            ['KTK014', 'Konsol Game'],
            ['KTK009', 'Barang Koleksi'],
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

        // 3. tags
        $tags = [
            ['kode' => 'TG001', 'nama' => 'Pedas', 'kategori' => 'Makanan Siap Saji'],
            ['kode' => 'TG002', 'nama' => 'Dingin', 'kategori' => 'Minuman (Kopi, Jus, Teh)'],
            ['kode' => 'TG003', 'nama' => 'Best Seller', 'kategori' => 'Kue & Roti'],
            ['kode' => 'TG004', 'nama' => 'Diskon', 'kategori' => 'Fashion Pria'],
            ['kode' => 'TG005', 'nama' => 'Viral', 'kategori' => 'Skincare'],
            ['kode' => 'TG006', 'nama' => 'Baru Rilis', 'kategori' => 'Konsol Game'],
            ['kode' => 'TG007', 'nama' => 'Limited Edition', 'kategori' => 'Barang Koleksi'],
            ['kode' => 'TG008', 'nama' => 'Murah', 'kategori' => 'Produk Tidak Berkategori Spesifik'],
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
