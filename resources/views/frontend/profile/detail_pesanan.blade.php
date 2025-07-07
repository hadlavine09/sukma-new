@extends('frontend.component.main')
@section('contentfrontend')
    <section class="py-5" style="background-color: #f9f9f9;">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Menu -->
                <div class="col-12 col-md-4 col-lg-3 mb-4">
                    <div class="bg-white p-3 shadow-sm border rounded h-100">
                        <div class="d-flex align-items-center mb-3 flex-wrap">
                            <img src="{{ asset('images/default-profile.png') }}" class="rounded-circle me-2 mb-2 mb-md-0"
                                width="40" height="40" alt="Profile">
                            <div>
                                <strong>{{ $user->username ?? 'Username' }}</strong><br>
                                <a href="#" class="text-primary text-decoration-none small">✎ Ubah Profil</a>
                            </div>
                        </div>
                        <hr>
                        <ul class="nav flex-column small" id="sidebarNav">
                            <li class="nav-item mb-2"><strong class="text-muted">Akun Saya</strong></li>
                            <li class="nav-item">
                                <a href="{{ route('profile.index') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.index') ? ' active text-danger' : ' text-dark' }}">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.bank-kartu') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.bank-kartu') ? ' active text-danger' : ' text-dark' }}">Bank
                                    & Kartu</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.alamat') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.alamat') ? ' active text-danger' : ' text-dark' }}">Alamat</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.ubah-password') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.ubah-password') ? ' active text-danger' : ' text-dark' }}">Ubah
                                    Password</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.notifikasi-setting') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.notifikasi-setting') ? ' active text-danger' : ' text-dark' }}">Pengaturan
                                    Notifikasi</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.privasi-setting') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.privasi-setting') ? ' active text-danger' : ' text-dark' }}">Pengaturan
                                    Privasi</a>
                            </li>
                            <li class="nav-item mt-3"><strong class="text-muted">Pesanan Saya</strong></li>
                            <li class="nav-item">
                                <a href="{{ route('profile.pesanan') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.pesanan') ? ' active text-danger' : ' text-dark' }}">Pesanan
                                    Saya</a>
                            </li>
                            <li class="nav-item mt-3"><strong class="text-muted">Lainnya</strong></li>
                            <li class="nav-item">
                                <a href="{{ route('profile.notifikasi') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.notifikasi') ? ' active text-danger' : ' text-dark' }}">Notifikasi</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.voucher') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.voucher') ? ' active text-danger' : ' text-dark' }}">Voucher
                                    Saya</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.koin') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.koin') ? ' active text-danger' : ' text-dark' }}">Koin
                                    Shopee Saya</a>
                            </li>
                            <style>
                                #sidebarNav .nav-link {
                                    color: #212529;
                                    background: none;
                                    border: none;
                                    border-radius: 4px;
                                    transition: color 0.2s;
                                }

                                #sidebarNav .nav-link:hover,
                                #sidebarNav .nav-link:focus {
                                    color: #0d6efd;
                                    background: none;
                                    text-decoration: none;
                                }

                                #sidebarNav .nav-link.active {
                                    color: #0d6efd !important;
                                    background: none;
                                    font-weight: 500;
                                }
                            </style>
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
                    <!-- Konten Pesanan Saya -->
                    <div class="col-12 order-2 order-lg-1">
                        <div class="p-4 border rounded shadow-sm bg-white h-100">
                            <div class="tab-content">
                                <!-- Detail Pesanan -->
                                <div class="tab-pane fade show active" id="detailPesanan">
                                    <h5 class="fw-bold mb-3">Detail Pesanan</h5>

                                    <div class="mb-4">
                                        <strong>Kode Pesanan:</strong>
                                        INV/{{ str_pad($pesanan['id'], 5, '0', STR_PAD_LEFT) }}<br>
                                        <strong>Status:</strong>
                                        <span
                                            class="badge
                                @if ($pesanan['status'] == 'Belum Bayar') bg-warning text-dark
                                @elseif($pesanan['status'] == 'Diproses') bg-info text-dark
                                @elseif($pesanan['status'] == 'Dikirim') bg-primary
                                @elseif($pesanan['status'] == 'Selesai') bg-success
                                @elseif($pesanan['status'] == 'Dibatalkan') bg-danger @endif
                            ">{{ $pesanan['status'] }}</span>
                                    </div>

                                    <div class="d-flex mb-3">
                                        <img src="{{ asset($pesanan['gambar']) }}" width="100" class="me-3 rounded"
                                            alt="Gambar Produk">
                                        <div>
                                            <h6>{{ $pesanan['produk'] }}</h6>
                                            <p class="mb-1">Variasi: {{ $pesanan['variasi'] }}</p>
                                            <p class="mb-1">Jumlah: {{ $pesanan['jumlah'] }}</p>
                                            <p class="mb-1">Harga: Rp{{ number_format($pesanan['harga'], 0, ',', '.') }}
                                            </p>
                                            <p class="mb-1">Total:
                                                <strong>Rp{{ number_format($pesanan['total'], 0, ',', '.') }}</strong>
                                            </p>
                                        </div>
                                    </div>

                                    <hr>

                                    <h6>Informasi Penerima</h6>
                                    <p class="mb-1"><strong>Nama:</strong> {{ $pesanan['nama_penerima'] }}</p>
                                    <p class="mb-1"><strong>No. HP:</strong> {{ $pesanan['no_hp'] }}</p>
                                    <p class="mb-1"><strong>Alamat:</strong> {{ $pesanan['alamat'] }}</p>

                                    <hr>

                                    <h6>Rincian Pembayaran</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            Harga Produk
                                            <span>Rp{{ number_format($pesanan['harga_asli'], 0, ',', '.') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            Diskon Produk
                                            <span>-Rp{{ number_format($pesanan['harga_asli'] - $pesanan['harga'], 0, ',', '.') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            Biaya Proteksi
                                            <span>Rp{{ number_format($pesanan['proteksi'], 0, ',', '.') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            Ongkos Kirim
                                            <span>Rp{{ number_format($pesanan['ongkir'], 0, ',', '.') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            Diskon Ongkir
                                            <span>-Rp{{ number_format($pesanan['diskon_ongkir'], 0, ',', '.') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            Biaya Layanan
                                            <span>Rp{{ number_format($pesanan['biaya_layanan'], 0, ',', '.') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between fw-bold">
                                            Total Bayar
                                            <span>Rp{{ number_format($pesanan['total'], 0, ',', '.') }}</span>
                                        </li>
                                    </ul>

                                    <p class="mt-3"><strong>Metode Pembayaran:</strong>
                                        {{ $pesanan['metode_pembayaran'] }}</p>

                                    <hr>

                                    <h6>Riwayat Pengiriman</h6>
                                    <style>
                                        .tracking-container {
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            gap: 8px;
                                            margin: 30px 0;
                                        }

                                        .tracking-step {
                                            display: flex;
                                            flex-direction: column;
                                            align-items: center;
                                            text-align: center;
                                            width: 100px;
                                        }

                                        .tracking-step .circle {
                                            width: 40px;
                                            height: 40px;
                                            border-radius: 50%;
                                            background-color: #e0e0e0;
                                            color: #fff;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            margin-bottom: 6px;
                                            font-size: 20px;
                                        }

                                        .tracking-step.completed .circle {
                                            background-color: #4CAF50;
                                        }

                                        .tracking-step.active .circle {
                                            background-color: #4CAF50;
                                            animation: pulse 1s infinite;
                                        }

                                        .tracking-step .label {
                                            font-size: 13px;
                                            margin-bottom: 4px;
                                        }

                                        .tracking-line {
                                            height: 4px;
                                            width: 40px;
                                            background-color: #e0e0e0;
                                            position: relative;
                                        }

                                        .tracking-line.completed {
                                            background-color: #4CAF50;
                                        }

                                        .tracking-line.loading::before {
                                            content: "";
                                            position: absolute;
                                            height: 100%;
                                            width: 100%;
                                            background: linear-gradient(to right, #4CAF50 50%, transparent 50%);
                                            background-size: 20px 100%;
                                            animation: move 1s linear infinite;
                                        }

                                        @keyframes move {
                                            0% {
                                                background-position: 0 0;
                                            }

                                            100% {
                                                background-position: 20px 0;
                                            }
                                        }

                                        @keyframes pulse {
                                            0% {
                                                box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.4);
                                            }

                                            70% {
                                                box-shadow: 0 0 0 10px rgba(76, 175, 80, 0);
                                            }

                                            100% {
                                                box-shadow: 0 0 0 0 rgba(76, 175, 80, 0);
                                            }
                                        }
                                    </style>
                                    @php
                                        $statusSteps = ['Belum Bayar', 'Diproses', 'Dikirim', 'Selesai', 'Dinilai'];
                                        $currentIndex = array_search($pesanan['status'], $statusSteps);
                                    @endphp

                                    <div class="tracking-container">
                                        @php
                                            $steps = [
                                                ['label' => 'Belum Bayar', 'icon' => '💳'],
                                                ['label' => 'Diproses', 'icon' => '📦'],
                                                ['label' => 'Dikirim', 'icon' => '🚚'],
                                                ['label' => 'Selesai', 'icon' => '✅'],
                                                ['label' => 'Dinilai', 'icon' => '⭐'],
                                            ];
                                        @endphp

                                        @foreach ($steps as $index => $step)
                                            <div
                                                class="tracking-step
                                    @if ($index < $currentIndex) completed
                                    @elseif ($index == $currentIndex) active @endif">
                                                <div class="circle">{{ $step['icon'] }}</div>
                                                <div class="label">{{ $step['label'] }}</div>
                                            </div>

                                            @if (!$loop->last)
                                                <div
                                                    class="tracking-line
                                    @if ($index < $currentIndex) completed
                                    @elseif ($index == $currentIndex) loading @endif">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <ul class="list-group">
                                        @foreach ($pesanan['tracking'] as $track)
                                            <li class="list-group-item">
                                                <strong>{{ $track['waktu'] }}</strong> - {{ $track['status'] }}<br>
                                                <small class="text-muted">{{ $track['detail'] ?? '-' }}</small>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <hr>

                                    @if ($pesanan['status'] === 'Belum Bayar')
                                        <a href="#" class="btn btn-danger mt-3 me-2">Bayar Sekarang</a>
                                    @endif

                                    <a href="{{ route('profile.pesanan') }}" class="btn btn-secondary mt-3">Kembali ke
                                        Daftar Pesanan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- col-lg-9 -->
            </div> <!-- row -->
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
