@extends('frontend.component.main')
@section('contentfrontend')
<style>
    /* Custom Success Button */
.btn-custom-success {
    background-color: #2d5727;
    border-color: #2d5727;
    color: #fff;
}

.btn-custom-success:hover {
    background-color: #2d5727;
    border-color: #2d5727;
}

.btn-outline-custom-success {
    border-color: #2d5727;
    color: #2d5727;
}

.btn-outline-custom-success:hover {
    background-color: #2d5727;
    color: #fff;
}

</style>
<!-- Detail Produk Section -->
<section class="py-5 overflow-hidden" style="background-color: #f9f9f9;">
    <div class="container-fluid">
        <form method="POST">
    @csrf
    <div class="row g-4 justify-content-center">
        <!-- Gambar Produk -->
        <div class="col-lg-3">
            <div id="produkCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner border rounded shadow-sm">
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="d-block w-100" alt="Gambar Produk">
                    </div>
                </div>
                <div class="mt-2 d-flex gap-2 overflow-auto">
                    <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="img-thumbnail" style="width: 60px; height: 60px;">
                </div>
            </div>
        </div>

        <!-- Informasi Produk -->
        <div class="col-lg-6 offset-lg-1 px-lg-4">
            <h6 class="text-muted">{{ $produk->kategori->nama_kategori ?? 'Kategori' }}</h6>
            <h2 class="fw-bold">{{ $produk->nama_produk }}</h2>
            <div class="d-flex align-items-center gap-3 my-2 small text-muted">
                <span class="text-warning fw-bold">4.8 ★</span>
                <span>{{ $produk->total_ulasan ?? 110 }} Penilaian</span>
                <span>|</span>
                <span>{{ $produk->total_terjual ?? 266 }} Terjual</span>
            </div>

            <h3 class="fw-bold mb-0" style="font-size: 1.5rem;  color:#2d5727;">Rp{{ number_format($produk->harga_produk, 0, ',', '.') }}</h3>
            <small class="text-decoration-line-through text-muted" style="font-size: 1rem;">
                Rp{{ number_format($produk->harga_asli ?? $produk->harga_produk + 60000, 0, ',', '.') }}
            </small>
            <span class="badge ms-2" style="font-size: 1rem; background: #2d5727;">
                -{{ number_format((($produk->harga_asli ?? 250000) - $produk->harga_produk) / ($produk->harga_asli ?? 250000) * 100, 0) }}%
            </span>

            <!-- Ukuran -->
            <div class="mb-3 mt-2">
                <label class="form-label fw-semibold" style="color: #2d5727;">Ukuran:</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach (['M', 'L', 'XL', 'XXL'] as $size)
                        <button type="button" class="btn btn-outline-custom-success btn-sm">{{ $size }}</button>
                    @endforeach
                </div>
            </div>

            <!-- Kuantitas -->
            <div class="mb-3">
                <label class="form-label fw-semibold" style="color: #2d5727;">Kuantitas:</label>
                <div class="input-group" style="max-width: 160px;">
                    <button id="btnMinus" type="button" class="btn btn-outline-custom-success">−</button>
                    <input id="quantityInput" type="number" class="form-control text-center" value="1" min="1" max="{{ $produk->stok_produk }}">
                    <button id="btnPlus" type="button" class="btn btn-outline-custom-success">+</button>
                </div>
                <small class="text-muted">Tersisa {{ $produk->stok_produk }} buah</small>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex flex-column flex-md-row gap-2 mt-3">
                <button id="addToCart" type="button" class="btn w-100" style="color: #2d5727; border: 1px solid #2d5727; background-color: #f0f5f1;">
                    <i class="bi bi-cart-plus me-1"></i> Masukkan Keranjang
                </button>
                <button class="btn btn-custom-success no-hover w-100" type="submit" style="color: #fff">
                    <i class="bi bi-lightning-fill me-1"></i> Beli Sekarang
                </button>
            </div>
        </div>
    </div>
</form>

       <!-- Info Toko -->
        <div class="card-info-toko">
            <div class="p-4 border rounded shadow-sm bg-white mt-4">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">

                    <!-- Kiri: Foto & Nama Toko -->
                    <div class="d-flex align-items-center gap-3 w-100 w-md-auto">
                        <img src="{{ asset('logo/logo2.png') }}"
                            class="rounded-circle border img-fluid"
                            style="max-width: 64px; height: auto;"
                            alt="Toko">
                        <div>
                            <h6 class="mb-1 fw-bold">{{ $produk->store ?? 'silhouette.ltd' }}</h6>
                            <small class="text-muted">Aktif {{ $produk->last_active ?? '2 Jam Lalu' }}</small>
                        </div>
                    </div>

                    <!-- Tengah: Statistik -->
                    <div class="d-flex justify-content-around text-center flex-wrap flex-grow-1 w-100">
                        <div class="p-2">
                            <div class="fw-bold" style="color: #2d5727">{{ $produk->rating ?? '7,7RB' }}</div>
                            <div class="text-muted small">Penilaian</div>
                        </div>
                        <div class="p-2">
                            <div class="fw-bold" style="color: #2d5727">{{ $produk->joined_since ?? '23 bulan lalu' }}</div>
                            <div class="text-muted small">Bergabung</div>
                        </div>
                        <div class="p-2">
                            <div class="fw-bold" style="color: #2d5727">{{ $produk->product_count ?? '598' }}</div>
                            <div class="text-muted small">Produk</div>
                        </div>
                        <div class="p-2">
                            <div class="fw-bold" style="color: #2d5727">{{ $produk->followers ?? '8,1RB' }}</div>
                            <div class="text-muted small">Pengikut</div>
                        </div>
                    </div>

                    <!-- Kanan: Tombol Aksi -->
                    <div class="d-flex gap-2 justify-content-md-end justify-content-center w-100 w-md-auto">
                        <!-- Chat Sekarang -->
                        <a href="#" class="btn btn-sm w-100 w-md-auto"
                            style="color: #2d5727; border: 1px solid #2d5727; background-color: #f0f5f1;">
                            <i class="bi bi-chat-dots me-1"></i> Chat Sekarang
                        </a>

                        <!-- Kunjungi Toko -->
                        <a href="#" class="btn btn-sm w-100 w-md-auto"
                            style="color: #2d5727; border: 1px solid #2d5727; background-color: transparent;">
                            Kunjungi Toko
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-info-spesifikasi-produk">
            <div class="p-4 border rounded shadow-sm bg-white mt-4">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                    <h4 class="fw-bold" style="color: #2d5727;">Spesifikasi Produk</h4>
                </div>

                <!-- Tabel Spesifikasi Produk -->
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <td class="fw-semibold" style="color: #2d5727;">Kategori</td>
                                <td>Sepatu Pria > Sneakers</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold" style="color: #2d5727;">Stok</td>
                                <td>{{ $produk->stok_produk ?? '0' }} buah</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold" style="color: #2d5727;">Merek</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold" style="color: #2d5727;">Tipe Pengikat</td>
                                <td>Tali</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold" style="color: #2d5727;">Negara Asal</td>
                                <td>Vietnam</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold" style="color: #2d5727;">Dikirim Dari</td>
                                <td>KOTA BANDUNG</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold" style="color: #2d5727;">Deskripsi Produk</td>
                                <td>
                                    The Original Picture Posted By Silhouette LTD. <br>
                                    <strong>Note:</strong> Untuk Size Chart silahkan Klik (Tabel Ukuran) di Ikon Beli Sekarang <br><br>
                                    <strong>Product Details :</strong><br>
                                    Model: Samba OG<br>
                                    Colorway: WHITE/BLACK/MULTICOLOR<br>
                                    SKU: B75806<br>
                                    Gender: Unisex (men's & womens)<br>
                                    Original Material Guarantee
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-info-penilaian-produk">
            <div class="p-4 border rounded shadow-sm bg-white mt-4">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                    <h4 class="fw-bold" style="color: #2d5727;">Penilaian Produk</h4>
                </div>

                <!-- Ringkasan Rating -->
                <div style="display: flex; align-items: center; margin-top: 16px;">
                    <div style="font-size: 24px; color: #2d5727; font-weight: bold; margin-right: 8px;">4.9</div>
                    <div style="font-size: 14px; color: #888;">dari 5</div>
                    <div style="margin-left: 8px; color: #2d5727; font-size: 18px;">★★★★★</div>
                </div>

                <!-- Filter Tabs -->
                <div id="reviewTabs" style="display: flex; flex-wrap: wrap; gap: 8px; margin: 20px 0;">
                    <button type="button" class="btn-review-tab"
                        data-tab="all"
                        style="padding: 6px 12px; border-radius: 2px; border: 1px solid #ccc; background-color: white; cursor: pointer;">
                        Semua
                    </button>
                    <button type="button" class="btn-review-tab"
                        data-tab="5"
                        style="padding: 6px 12px; border-radius: 2px; border: 1px solid #ccc; background-color: white; cursor: pointer;">
                        5 Bintang (467)
                    </button>
                    <button type="button" class="btn-review-tab"
                        data-tab="4"
                        style="padding: 6px 12px; border-radius: 2px; border: 1px solid #ccc; background-color: white; cursor: pointer;">
                        4 Bintang (16)
                    </button>
                    <button type="button" class="btn-review-tab"
                        data-tab="3"
                        style="padding: 6px 12px; border-radius: 2px; border: 1px solid #ccc; background-color: white; cursor: pointer;">
                        3 Bintang (2)
                    </button>
                    <button type="button" class="btn-review-tab"
                        data-tab="2"
                        style="padding: 6px 12px; border-radius: 2px; border: 1px solid #ccc; background-color: white; cursor: pointer;">
                        2 Bintang (1)
                    </button>
                    <button type="button" class="btn-review-tab"
                        data-tab="1"
                        style="padding: 6px 12px; border-radius: 2px; border: 1px solid #ccc; background-color: white; cursor: pointer;">
                        1 Bintang (1)
                    </button>
                    <button type="button" class="btn-review-tab"
                        data-tab="comment"
                        style="padding: 6px 12px; border-radius: 2px; border: 1px solid #ccc; background-color: white; cursor: pointer;">
                        Dengan Komentar (398)
                    </button>
                    <button type="button" class="btn-review-tab"
                        data-tab="media"
                        style="padding: 6px 12px; border-radius: 2px; border: 1px solid #ccc; background-color: white; cursor: pointer;">
                        Dengan Media (81)
                    </button>
                </div>

                <!-- Ulasan -->
                <div id="reviewTabContent">
                    <!-- Semua -->
                    <div class="review-tab-pane" data-content="all" style="display: block;">
                        <!-- Ulasan 1 -->
                        <div style="border-top: 1px solid #eee; padding-top: 16px; margin-top: 16px;">
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                <img src="https://via.placeholder.com/30" style="border-radius: 50%; margin-right: 10px;">
                                <strong>maya_kirana56</strong>
                            </div>
                            <div style="color: #faca51; font-size: 16px; margin-bottom: 4px;">★★★★★</div>
                            <div style="font-size: 12px; color: #999; margin-bottom: 8px;">2023-12-27 14:03 | Variasi: 43</div>
                            <div style="font-size: 14px; margin-bottom: 10px;">
                                sepatunya bagus bangettt sumpahh sesuai sama digambar sii ini asli sukak bangettt bahannya juga bagusss, tebel gitu dan warnanya juga ga terlalu norak banget thanks seller
                            </div>
                            <div style="display: flex; gap: 4px;">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            </div>
                            <div style="font-size: 12px; color: #888; margin-top: 4px;">👍 94</div>
                        </div>
                        <!-- Ulasan 2 -->
                        <div style="border-top: 1px solid #eee; padding-top: 16px; margin-top: 16px;">
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                <img src="https://via.placeholder.com/30" style="border-radius: 50%; margin-right: 10px;">
                                <strong>susantisusan11</strong>
                            </div>
                            <div style="color: #faca51; font-size: 16px; margin-bottom: 4px;">★★★★★</div>
                            <div style="font-size: 12px; color: #999; margin-bottom: 8px;">2024-01-09 13:15 | Variasi: 38</div>
                            <div style="font-size: 14px; margin-bottom: 10px;">
                                Sepatunya nyaman dipake, designnya juga kece, materialnya oke, sepatu bagian bawahnya dari karet jadi nggk licin kena keramik. Dijamin nggk nyesel beli ini sepatu kak
                            </div>
                            <div style="display: flex; gap: 4px;">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            </div>
                            <div style="font-size: 12px; color: #888; margin-top: 4px;">👍 41</div>
                        </div>
                    </div>
                    <!-- 5 Bintang -->
                    <div class="review-tab-pane" data-content="5" style="display: none;">
                        <!-- Ulasan 1 -->
                        <div style="border-top: 1px solid #eee; padding-top: 16px; margin-top: 16px;">
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                <img src="https://via.placeholder.com/30" style="border-radius: 50%; margin-right: 10px;">
                                <strong>maya_kirana56</strong>
                            </div>
                            <div style="color: #faca51; font-size: 16px; margin-bottom: 4px;">★★★★★</div>
                            <div style="font-size: 12px; color: #999; margin-bottom: 8px;">2023-12-27 14:03 | Variasi: 43</div>
                            <div style="font-size: 14px; margin-bottom: 10px;">
                                sepatunya bagus bangettt sumpahh sesuai sama digambar sii ini asli sukak bangettt bahannya juga bagusss, tebel gitu dan warnanya juga ga terlalu norak banget thanks seller
                            </div>
                            <div style="display: flex; gap: 4px;">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            </div>
                            <div style="font-size: 12px; color: #888; margin-top: 4px;">👍 94</div>
                        </div>
                        <!-- Ulasan 2 -->
                        <div style="border-top: 1px solid #eee; padding-top: 16px; margin-top: 16px;">
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                <img src="https://via.placeholder.com/30" style="border-radius: 50%; margin-right: 10px;">
                                <strong>susantisusan11</strong>
                            </div>
                            <div style="color: #faca51; font-size: 16px; margin-bottom: 4px;">★★★★★</div>
                            <div style="font-size: 12px; color: #999; margin-bottom: 8px;">2024-01-09 13:15 | Variasi: 38</div>
                            <div style="font-size: 14px; margin-bottom: 10px;">
                                Sepatunya nyaman dipake, designnya juga kece, materialnya oke, sepatu bagian bawahnya dari karet jadi nggk licin kena keramik. Dijamin nggk nyesel beli ini sepatu kak
                            </div>
                            <div style="display: flex; gap: 4px;">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            </div>
                            <div style="font-size: 12px; color: #888; margin-top: 4px;">👍 41</div>
                        </div>
                    </div>
                    <!-- 4 Bintang -->
                    <div class="review-tab-pane" data-content="4" style="display: none;">
                        <div style="padding: 16px; color: #888;">Belum ada ulasan 4 bintang.</div>
                    </div>
                    <!-- 3 Bintang -->
                    <div class="review-tab-pane" data-content="3" style="display: none;">
                        <div style="padding: 16px; color: #888;">Belum ada ulasan 3 bintang.</div>
                    </div>
                    <!-- 2 Bintang -->
                    <div class="review-tab-pane" data-content="2" style="display: none;">
                        <div style="padding: 16px; color: #888;">Belum ada ulasan 2 bintang.</div>
                    </div>
                    <!-- 1 Bintang -->
                    <div class="review-tab-pane" data-content="1" style="display: none;">
                        <div style="padding: 16px; color: #888;">Belum ada ulasan 1 bintang.</div>
                    </div>
                    <!-- Dengan Komentar -->
                    <div class="review-tab-pane" data-content="comment" style="display: none;">
                        <!-- Ulasan 1 -->
                        <div style="border-top: 1px solid #eee; padding-top: 16px; margin-top: 16px;">
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                <img src="https://via.placeholder.com/30" style="border-radius: 50%; margin-right: 10px;">
                                <strong>maya_kirana56</strong>
                            </div>
                            <div style="color: #faca51; font-size: 16px; margin-bottom: 4px;">★★★★★</div>
                            <div style="font-size: 12px; color: #999; margin-bottom: 8px;">2023-12-27 14:03 | Variasi: 43</div>
                            <div style="font-size: 14px; margin-bottom: 10px;">
                                sepatunya bagus bangettt sumpahh sesuai sama digambar sii ini asli sukak bangettt bahannya juga bagusss, tebel gitu dan warnanya juga ga terlalu norak banget thanks seller
                            </div>
                            <div style="display: flex; gap: 4px;">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            </div>
                            <div style="font-size: 12px; color: #888; margin-top: 4px;">👍 94</div>
                        </div>
                    </div>
                    <!-- Dengan Media -->
                    <div class="review-tab-pane" data-content="media" style="display: none;">
                        <!-- Ulasan 2 -->
                        <div style="border-top: 1px solid #eee; padding-top: 16px; margin-top: 16px;">
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                <img src="https://via.placeholder.com/30" style="border-radius: 50%; margin-right: 10px;">
                                <strong>susantisusan11</strong>
                            </div>
                            <div style="color: #faca51; font-size: 16px; margin-bottom: 4px;">★★★★★</div>
                            <div style="font-size: 12px; color: #999; margin-bottom: 8px;">2024-01-09 13:15 | Variasi: 38</div>
                            <div style="font-size: 14px; margin-bottom: 10px;">
                                Sepatunya nyaman dipake, designnya juga kece, materialnya oke, sepatu bagian bawahnya dari karet jadi nggk licin kena keramik. Dijamin nggk nyesel beli ini sepatu kak
                            </div>
                            <div style="display: flex; gap: 4px;">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <img src="https://via.placeholder.com/60x60" style="border-radius: 2px; cursor: pointer;"
                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            </div>
                            <div style="font-size: 12px; color: #888; margin-top: 4px;">👍 41</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tab review
            const tabButtons = document.querySelectorAll('.btn-review-tab');
            const tabPanes = document.querySelectorAll('.review-tab-pane');

            // Set default active tab (Semua)
            tabButtons.forEach(b => {
                if (b.dataset.tab === 'all') {
                    b.classList.add('active');
                    b.style.backgroundColor = '#e1ede3';
                    b.style.color = '#2d5727';
                    b.style.border = '1px solid #2d5727';
                } else {
                    b.classList.remove('active');
                    b.style.backgroundColor = 'white';
                    b.style.color = '';
                    b.style.border = '1px solid #ccc';
                }
            });
            tabPanes.forEach(pane => {
                if (pane.dataset.content === 'all') {
                    pane.style.display = 'block';
                } else {
                    pane.style.display = 'none';
                }
            });

            tabButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    // Remove active from all
                    tabButtons.forEach(b => {
                        b.classList.remove('active');
                        if (b.dataset.tab === 'all') {
                            b.style.backgroundColor = '#f0f5f1';
                            b.style.color = '#2d5727';
                            b.style.border = '1px solid #2d5727';
                        } else {
                            b.style.backgroundColor = 'white';
                            b.style.color = '';
                            b.style.border = '1px solid #ccc';
                        }
                    });
                    // Set active
                    this.classList.add('active');
                    if (this.dataset.tab === 'all') {
                        this.style.backgroundColor = '#e1ede3';
                        this.style.color = '#2d5727';
                        this.style.border = '1px solid #2d5727';
                    } else {
                        this.style.backgroundColor = '#f7f7f7';
                        this.style.color = '#2d5727';
                        this.style.border = '1px solid #2d5727';
                    }
                    // Show/hide panes
                    tabPanes.forEach(pane => {
                        if (pane.dataset.content === this.dataset.tab) {
                            pane.style.display = 'block';
                        } else {
                            pane.style.display = 'none';
                        }
                    });
                });
            });
        });
        </script>




    </div>
</section>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quantityInput = document.getElementById('quantityInput');
    const btnPlus = document.getElementById('btnPlus');
    const btnMinus = document.getElementById('btnMinus');
    const addToCartBtn = document.getElementById('addToCart');
    const maxStok = parseInt(quantityInput.max);

    btnPlus.addEventListener('click', () => {
        let value = parseInt(quantityInput.value);
        if (value < maxStok) quantityInput.value = value + 1;
    });

    btnMinus.addEventListener('click', () => {
        let value = parseInt(quantityInput.value);
        if (value > 1) quantityInput.value = value - 1;
    });

    addToCartBtn.addEventListener('click', function () {
        const quantity = parseInt(quantityInput.value);
        const productCode = "{{ $produk->kode_produk }}";

        if (quantity < 1) {
            alert("Jumlah produk harus lebih dari 0.");
            return;
        }
        $.ajax({
            url: "{{ route('frontend.tambahkeranjang') }}",
            type: "POST",
            data: {
                kode_produk: productCode,
                quantity: quantity
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 'success') {
                    window.location.href = "{{ route('frontend.keranjang') }}";
                } else {
                    alert(response.message || 'Gagal menambahkan produk ke keranjang.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    alert(xhr.responseJSON.message); // validasi quantity/stok
                } else {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
                // console.error(xhr.responseJSON || xhr.responseText);
            }
        });

    });
});
</script>

@endsection
