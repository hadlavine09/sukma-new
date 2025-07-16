<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TampilanTokoController extends Controller
{
    public function index()
    {
        $todo = [
            'Pengiriman Perlu Diproses' => 0,
            'Pengiriman Telah Diproses' => 0,
            'Pengembalian/Pembatalan' => 0,
            'Produk Diblokir/Diturunkan' => 0,
            'Nominasi Program Garansi Harga Terbaik' => 6,
        ];

        $storeStats = [
            'Penjualan' => 'Rp0',
            'Total Pengunjung' => 1,
            'Jumlah Produk Diklik' => 1,
            'Pesanan' => 0,
            'Tingkat Konversi Pesanan' => '0.00%',
        ];

        $productProgram = [
            'nama' => 'Basreng Paket Bundling 1Kg Banyak Varian Rasa Snack Cemilan Instan',
            'harga_net' => 'Rp37.500',
            'harga_program' => 'Rp32.399',
            'stok' => 'Tidak ada batas',
            'gambar' => 'https://via.placeholder.com/80',
        ];

        $ads = [
            'judul' => 'Promosikan Produk untuk Meningkatkan Kunjungan',
            'produk' => 'Basreng pedas aroma daun jeruk kemasan 1Kg Camilan Food Cemilan Food',
        ];

        $affiliate = [
            'penjualan' => 'Rp67RB',
            'pembeli_baru' => '--',
            'roi' => '--',
        ];

        $misi = [
            'status' => true,
            'deskripsi' => 'Mulai Shopee Live pertamamu (>30 menit)',
        ];

        $berita = [
            [
                'judul' => 'Banyak Jalan Menuju Roma...',
                'isi' => 'Namun hanya 1 jalan untuk menjadi produk terbaik! Nominasi lagi sekarang.',
            ],
            [
                'judul' => 'Biar Nggak Salah Pilih Affiliate!',
                'isi' => 'Gunakan Leaderboard Affiliate untuk lihat performa penjualan & konten teratas.',
            ],
        ];

        return view('frontend.halamantoko.index', compact('todo', 'storeStats', 'productProgram', 'ads', 'affiliate', 'misi', 'berita'));
    }
}
