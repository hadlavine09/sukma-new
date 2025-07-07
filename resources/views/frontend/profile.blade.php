@extends('frontend.component.main')
@section('contentfrontend')
    <section class="py-5" style="background-color: #f9f9f9;">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Menu -->
                <div class="col-12 col-md-4 col-lg-3 mb-4">
                    <div class="bg-white p-3 shadow-sm border rounded h-100">
                        <div class="d-flex align-items-center mb-3 flex-wrap">
                            <img src="{{ asset('images/default-profile.png') }}" class="rounded-circle me-2 mb-2 mb-md-0" width="40"
                                height="40" alt="Profile">
                            <div>
                                <strong>{{ $user->username ?? 'Username' }}</strong><br>
                                <a href="#" class="text-primary text-decoration-none small">✎ Ubah Profil</a>
                            </div>
                        </div>
                        <hr>
                        <ul class="nav flex-column small" id="sidebarNav">
                            <li class="nav-item mb-2"><strong class="text-muted">Akun Saya</strong></li>
                            <li class="nav-item">
                                <a href="#" id="profilLink" class="nav-link px-0 text-danger active">Profil</a>
                            </li>
                            <li class="nav-item"><a href="#" id="bankKartuLink" class="nav-link px-0 text-dark">Bank &
                                    Kartu</a></li>
                            <li class="nav-item"><a href="#" id="alamatLink"
                                    class="nav-link px-0 text-dark">Alamat</a></li>
                            <li class="nav-item"><a href="#" id="ubahPasswordLink"
                                    class="nav-link px-0 text-dark">Ubah Password</a></li>
                            <li class="nav-item"><a href="#" id="notifikasiSettingLink"
                                    class="nav-link px-0 text-dark">Pengaturan Notifikasi</a></li>
                            <li class="nav-item"><a href="#" id="privasiSettingLink"
                                    class="nav-link px-0 text-dark">Pengaturan Privasi</a></li>
                            <li class="nav-item mt-3"><strong class="text-muted">Pesanan Saya</strong></li>
                            <li class="nav-item">
                                <a href="#" id="pesananSayaLink" class="nav-link px-0 text-dark">Pesanan Saya</a>
                            </li>
                            <li class="nav-item mt-3"><strong class="text-muted">Lainnya</strong></li>
                            <li class="nav-item"><a href="#" id="notifikasiLink"
                                    class="nav-link px-0 text-dark">Notifikasi</a></li>
                            <li class="nav-item"><a href="#" id="voucherLink" class="nav-link px-0 text-dark">Voucher
                                    Saya</a></li>
                            <li class="nav-item"><a href="#" id="koinLink" class="nav-link px-0 text-dark">Koin
                                    Shopee Saya</a></li>
                        </ul>
                        <style>
                            .overflow-auto {
                                overflow: unset !important;
                            }
                        </style>
                    </div>
                </div>

                <!-- Konten Kanan -->
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="row gy-4">
                        <!-- Konten Profil -->
                        <div class="col-12 col-lg-8 order-2 order-lg-1" id="profilContent">
                            <div class="p-4 border rounded shadow-sm bg-white h-100">
                                <h5 class="fw-bold mb-3">Profil Saya</h5>
                                <p class="text-muted small mb-4">Kelola informasi profil Anda untuk mengontrol, melindungi
                                    dan mengamankan akun</p>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <th class="text-muted" style="width: 180px;">Username</th>
                                            <td>{{ $user->username ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Nama</th>
                                            <td>{{ $user->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Email</th>
                                            <td>{{ $user->email ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Nomor Telepon</th>
                                            <td>{{ $user->phone ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Nama Toko</th>
                                            <td>{{ $user->store_name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Jenis Kelamin</th>
                                            <td>{{ $user->gender ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Tanggal Lahir</th>
                                            <td>
                                                @php
                                                    $tgl = $user->birth_day ?? null;
                                                    $bln = $user->birth_month ?? null;
                                                    $thn = $user->birth_year ?? null;
                                                    $bulanList = [
                                                        1 => 'Januari',
                                                        2 => 'Februari',
                                                        3 => 'Maret',
                                                        4 => 'April',
                                                        5 => 'Mei',
                                                        6 => 'Juni',
                                                        7 => 'Juli',
                                                        8 => 'Agustus',
                                                        9 => 'September',
                                                        10 => 'Oktober',
                                                        11 => 'November',
                                                        12 => 'Desember',
                                                    ];
                                                @endphp
                                                @if ($tgl && $bln && $thn)
                                                    {{ $tgl }} {{ $bulanList[$bln] ?? $bln }} {{ $thn }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Konten Pesanan Saya -->
                        <div class="col-12 col-lg-8 order-2 order-lg-1" id="pesananContent" style="display: none;">
                            <div class="p-4 border rounded shadow-sm bg-white h-100">
                                <h5 class="fw-bold mb-3">Pesanan Saya</h5>
                                <ul class="nav nav-tabs mb-3 flex-nowrap overflow-auto" id="pesananTabs" role="tablist" style="white-space:nowrap;">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#semua"
                                            type="button">Semua</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#belumBayar"
                                            type="button">Belum Bayar</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#diproses"
                                            type="button">Diproses</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dikirim"
                                            type="button">Dikirim</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#selesai"
                                            type="button">Selesai</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pesananTabContent">
                                    <div class="tab-pane fade show active" id="semua">
                                        <!-- Card Semua -->
                                        <div class="card mb-3">
                                            <div class="card-header d-flex flex-wrap justify-content-between">
                                                <span class="text-muted small">Order ID: INV/00123</span>
                                                <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                            </div>
                                            <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                <img src="{{ asset('images/product-sample.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                    width="80" height="80" alt="Product">
                                                <div>
                                                    <h6 class="mb-1">Nama Produk Sample</h6>
                                                    <p class="mb-0 text-muted small">1 x Rp100.000</p>
                                                </div>
                                                <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                    <p class="mb-1">Total Belanja</p>
                                                    <strong>Rp100.000</strong><br>
                                                    <button class="btn btn-danger btn-sm mt-2">Bayar Sekarang</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="belumBayar">
                                        <!-- Card Belum Bayar -->
                                        <div class="card mb-3">
                                            <div class="card-header d-flex flex-wrap justify-content-between">
                                                <span class="text-muted small">Order ID: INV/00124</span>
                                                <span class="badge bg-warning text-dark">Belum Bayar</span>
                                            </div>
                                            <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                <img src="{{ asset('images/product-sample2.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                    width="80" height="80" alt="Product">
                                                <div>
                                                    <h6 class="mb-1">Produk Belum Bayar</h6>
                                                    <p class="mb-0 text-muted small">2 x Rp50.000</p>
                                                </div>
                                                <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                    <p class="mb-1">Total Belanja</p>
                                                    <strong>Rp100.000</strong><br>
                                                    <button class="btn btn-danger btn-sm mt-2">Bayar Sekarang</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="diproses">
                                        <!-- Card Diproses -->
                                        <div class="card mb-3">
                                            <div class="card-header d-flex flex-wrap justify-content-between">
                                                <span class="text-muted small">Order ID: INV/00125</span>
                                                <span class="badge bg-info text-dark">Diproses</span>
                                            </div>
                                            <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                <img src="{{ asset('images/product-sample3.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                    width="80" height="80" alt="Product">
                                                <div>
                                                    <h6 class="mb-1">Produk Diproses</h6>
                                                    <p class="mb-0 text-muted small">1 x Rp200.000</p>
                                                </div>
                                                <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                    <p class="mb-1">Total Belanja</p>
                                                    <strong>Rp200.000</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="dikirim">
                                        <!-- Card Dikirim -->
                                        <div class="card mb-3">
                                            <div class="card-header d-flex flex-wrap justify-content-between">
                                                <span class="text-muted small">Order ID: INV/00126</span>
                                                <span class="badge bg-primary">Dikirim</span>
                                            </div>
                                            <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                <img src="{{ asset('images/product-sample4.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                    width="80" height="80" alt="Product">
                                                <div>
                                                    <h6 class="mb-1">Produk Dikirim</h6>
                                                    <p class="mb-0 text-muted small">3 x Rp75.000</p>
                                                </div>
                                                <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                    <p class="mb-1">Total Belanja</p>
                                                    <strong>Rp225.000</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="selesai">
                                        <!-- Card Selesai -->
                                        <div class="card mb-3">
                                            <div class="card-header d-flex flex-wrap justify-content-between">
                                                <span class="text-muted small">Order ID: INV/00127</span>
                                                <span class="badge bg-success">Selesai</span>
                                            </div>
                                            <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                <img src="{{ asset('images/product-sample5.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                    width="80" height="80" alt="Product">
                                                <div>
                                                    <h6 class="mb-1">Produk Selesai</h6>
                                                    <p class="mb-0 text-muted small">1 x Rp300.000</p>
                                                </div>
                                                <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                    <p class="mb-1">Total Belanja</p>
                                                    <strong>Rp300.000</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Konten Dinamis Lainnya -->
                        <div class="col-12 col-lg-8 order-2 order-lg-1" id="bankKartuContent" style="display: none;">
                            <div class="p-4 border rounded shadow-sm bg-white h-100">
                                <h5 class="fw-bold mb-3">Bank & Kartu</h5>
                                <p class="text-muted">Daftar rekening bank dan kartu yang terhubung ke akun Anda.</p>
                                <div class="alert alert-info mb-0">Belum ada data bank atau kartu yang ditambahkan.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 order-2 order-lg-1" id="alamatContent" style="display: none;">
                            <div class="p-4 border rounded shadow-sm bg-white h-100">
                                <h5 class="fw-bold mb-3">Alamat</h5>
                                <p class="text-muted">Daftar alamat pengiriman Anda.</p>
                                <div class="alert alert-info mb-0">Belum ada alamat yang ditambahkan.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 order-2 order-lg-1" id="ubahPasswordContent" style="display: none;">
                            <div class="p-4 border rounded shadow-sm bg-white h-100">
                                <h5 class="fw-bold mb-3">Ubah Password</h5>
                                <p class="text-muted">Ganti password akun Anda secara berkala untuk keamanan.</p>
                                <div class="alert alert-info mb-0">Fitur ubah password belum tersedia.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 order-2 order-lg-1" id="notifikasiSettingContent" style="display: none;">
                            <div class="p-4 border rounded shadow-sm bg-white h-100">
                                <h5 class="fw-bold mb-3">Pengaturan Notifikasi</h5>
                                <p class="text-muted">Atur preferensi notifikasi Anda.</p>
                                <div class="alert alert-info mb-0">Fitur pengaturan notifikasi belum tersedia.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 order-2 order-lg-1" id="privasiSettingContent" style="display: none;">
                            <div class="p-4 border rounded shadow-sm bg-white h-100">
                                <h5 class="fw-bold mb-3">Pengaturan Privasi</h5>
                                <p class="text-muted">Atur privasi akun Anda.</p>
                                <div class="alert alert-info mb-0">Fitur pengaturan privasi belum tersedia.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 order-2 order-lg-1" id="notifikasiContent" style="display: none;">
                            <div class="p-4 border rounded shadow-sm bg-white h-100">
                                <h5 class="fw-bold mb-3">Notifikasi</h5>
                                <p class="text-muted">Semua notifikasi terkait akun Anda akan muncul di sini.</p>
                                <div class="alert alert-info mb-0">Belum ada notifikasi.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 order-2 order-lg-1" id="voucherContent" style="display: none;">
                            <div class="p-4 border rounded shadow-sm bg-white h-100">
                                <h5 class="fw-bold mb-3">Voucher Saya</h5>
                                <p class="text-muted">Daftar voucher yang Anda miliki.</p>
                                <div class="alert alert-info mb-0">Belum ada voucher yang tersedia.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 order-2 order-lg-1" id="koinContent" style="display: none;">
                            <div class="p-4 border rounded shadow-sm bg-white h-100">
                                <h5 class="fw-bold mb-3">Koin Shopee Saya</h5>
                                <p class="text-muted">Total koin yang Anda miliki.</p>
                                <div class="alert alert-info mb-0">Anda belum memiliki koin.</div>
                            </div>
                        </div>

                        <!-- Profil Gambar -->
                        <div class="col-12 col-lg-4 order-1 order-lg-2 mb-4 mb-lg-0">
                            <div
                                class="p-3 border rounded shadow-sm bg-white text-center h-100 d-flex flex-column justify-content-center align-items-center">
                                <div class="d-flex flex-column align-items-center w-100" style="margin-bottom: 20px; margin-top: -10px;">
                                    <img src="{{ asset('assets_frontend/images/reviewer-2.jpg') }}"
                                        class="rounded-circle border img-fluid mb-4"
                                        style="max-width: 200px; height: auto; cursor: pointer;" alt="Profile"
                                        data-bs-toggle="modal" data-bs-target="#profileModal">
                                    <button type="button" class="btn btn-outline-secondary btn-sm">Pilih Gambar</button>
                                    <div class="text-muted small mt-2 text-center">
                                        Ukuran gambar maks. 1 MB<br>Format: JPEG, PNG
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('logo/logo2.png') }}" class="img-fluid rounded"
                                            alt="Profile Besar">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- row -->
                </div> <!-- col-lg-9 -->
            </div> <!-- row -->

            <!-- Script untuk toggle konten dan navlink aktif -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const navLinks = {
                        profilLink: 'profilContent',
                        pesananSayaLink: 'pesananContent',
                        bankKartuLink: 'bankKartuContent',
                        alamatLink: 'alamatContent',
                        ubahPasswordLink: 'ubahPasswordContent',
                        notifikasiSettingLink: 'notifikasiSettingContent',
                        privasiSettingLink: 'privasiSettingContent',
                        notifikasiLink: 'notifikasiContent',
                        voucherLink: 'voucherContent',
                        koinLink: 'koinContent'
                    };

                    // Fungsi untuk mengatur nav-link aktif dan konten
                    function setActiveNav(linkId) {
                        document.querySelectorAll('#sidebarNav .nav-link').forEach(function(nav) {
                            nav.classList.remove('active', 'text-danger');
                            nav.classList.add('text-dark');
                        });
                        const link = document.getElementById(linkId);
                        if (link) {
                            link.classList.add('active', 'text-danger');
                            link.classList.remove('text-dark');
                        }
                    }

                    function showContent(contentId) {
                        // Sembunyikan semua konten
                        Object.values(navLinks).forEach(function(id) {
                            const el = document.getElementById(id);
                            if (el) el.style.display = 'none';
                        });
                        // Tampilkan konten yang dipilih
                        const showEl = document.getElementById(contentId);
                        if (showEl) showEl.style.display = 'block';
                    }

                    Object.keys(navLinks).forEach(function(linkId) {
                        const link = document.getElementById(linkId);
                        if (link) {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                setActiveNav(linkId);
                                showContent(navLinks[linkId]);
                            });
                        }
                    });

                    // Set default aktif pada profil
                    setActiveNav('profilLink');
                    showContent('profilContent');
                });
            </script>
            <style>
                @media (max-width: 991.98px) {
                    .order-1 {
                        order: 1 !important;
                    }
                    .order-2 {
                        order: 2 !important;
                    }
                }
                @media (max-width: 767.98px) {
                    .table th,
                    .table td {
                        display: block;
                        width: 100%;
                    }
                    .table th {
                        border-top: none;
                    }
                    .table tr {
                        margin-bottom: 1rem;
                        display: block;
                    }
                    .nav-tabs {
                        flex-wrap: nowrap;
                    }
                    .nav-tabs .nav-item {
                        flex: 0 0 auto;
                    }
                }
            </style>
        </div> <!-- container -->
    </section>
@endsection
