<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ManagementProdukSeeder extends Seeder
{
    public function run(): void
    {
        // Format waktu sesuai permintaan: TAHUNBULANHARI-JAMMENITDETIK
        $timestamp = Carbon::now()->format('Ymd-His');

         $gambars = [
            [
                'kode_gambar' => 'IMG001',
                'nama_gambar' => "{$timestamp}-IMG001-makanan.png",
                'path_gambar' => "uploads/gambar/{$timestamp}-IMG001-makanan.png",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_gambar' => 'IMG002',
                'nama_gambar' => "{$timestamp}-IMG002-minuman.png",
                'path_gambar' => "uploads/gambar/{$timestamp}-IMG002-minuman.png",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_gambar' => 'IMG003',
                'nama_gambar' => "{$timestamp}-IMG003-nasigoreng.jpg",
                'path_gambar' => "uploads/gambar/{$timestamp}-IMG003-nasigoreng.jpg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_gambar' => 'IMG004',
                'nama_gambar' => "{$timestamp}-IMG004-esteh.jpg",
                'path_gambar' => "uploads/gambar/{$timestamp}-IMG004-esteh.jpg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_gambar' => 'IMG005',
                'nama_gambar' => "{$timestamp}-IMG005-pedas.png",
                'path_gambar' => "uploads/gambar/{$timestamp}-IMG005-pedas.png",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_gambar' => 'IMG006',
                'nama_gambar' => "{$timestamp}-IMG006-dingin.png",
                'path_gambar' => "uploads/gambar/{$timestamp}-IMG006-dingin.png",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('gambars')->insert($gambars);

        // Data tags dengan gambar
        $tags = [
            [
                'kode_tag' => 'TG001',
                'nama_tag' => 'Pedas',
                'gambar_tag' => 'IMG005',
                'deskripsi_tag' => 'Tag untuk makanan pedas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_tag' => 'TG002',
                'nama_tag' => 'Dingin',
                'gambar_tag' => 'IMG006',
                'deskripsi_tag' => 'Tag untuk minuman dingin.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('tags')->insert($tags);

        // Data kategori
        $kategoris = [
            [
                'kode_kategori' => 'KT001',
                'nama_kategori' => 'Makanan',
                'gambar_kategori' => 'IMG001',
                'deskripsi_kategori' => 'Kategori untuk produk makanan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_kategori' => 'KT002',
                'nama_kategori' => 'Minuman',
                'gambar_kategori' => 'IMG002',
                'deskripsi_kategori' => 'Kategori untuk produk minuman',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('kategoris')->insert($kategoris);

        // Data produk
        $produks = [
            [
                'kode_produk' => 'PRD001',
                'nama_produk' => 'Nasi Goreng Spesial',
                'deskripsi_produk' => 'Nasi goreng dengan telur, ayam, dan sayuran segar.',
                'stok_produk' => 50,
                'harga_produk' => 25000.00,
                'gambar_produk' => 'IMG003',
                'kode_kategori' => 'KT001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_produk' => 'PRD002',
                'nama_produk' => 'Es Teh Manis',
                'deskripsi_produk' => 'Minuman teh manis segar dengan es batu.',
                'stok_produk' => 100,
                'harga_produk' => 8000.00,
                'gambar_produk' => 'IMG004',
                'kode_kategori' => 'KT002',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('produks')->insert($produks);

        // Relasi tag_produks (pivot)
        $tag_produks = [
            [
                'kode_tag' => 'TG001',
                'kode_produk' => 'PRD001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_tag' => 'TG002',
                'kode_produk' => 'PRD002',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('tag_produks')->insert($tag_produks);
    }
}
