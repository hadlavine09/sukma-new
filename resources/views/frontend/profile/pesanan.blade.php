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
                                <a href="{{ route('profile.index') }}"
                                    class="nav-link px-0{{ request()->routeIs('profile.index') ? ' active text-danger' : ' text-dark' }}">Profil</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('profile.bank-kartu') }}"
                                        class="nav-link px-0{{ request()->routeIs('profile.bank-kartu') ? ' active text-danger' : ' text-dark' }}">Bank & Kartu</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('profile.alamat') }}"
                                        class="nav-link px-0{{ request()->routeIs('profile.alamat') ? ' active text-danger' : ' text-dark' }}">Alamat</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('profile.ubah-password') }}"
                                        class="nav-link px-0{{ request()->routeIs('profile.ubah-password') ? ' active text-danger' : ' text-dark' }}">Ubah Password</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('profile.notifikasi-setting') }}"
                                        class="nav-link px-0{{ request()->routeIs('profile.notifikasi-setting') ? ' active text-danger' : ' text-dark' }}">Pengaturan Notifikasi</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('profile.privasi-setting') }}"
                                        class="nav-link px-0{{ request()->routeIs('profile.privasi-setting') ? ' active text-danger' : ' text-dark' }}">Pengaturan Privasi</a>
                                </li>
                                <li class="nav-item mt-3"><strong class="text-muted">Pesanan Saya</strong></li>
                                <li class="nav-item">
                                    <a href="{{ route('profile.pesanan') }}"
                                        class="nav-link px-0{{ request()->routeIs('profile.pesanan') ? ' active text-danger' : ' text-dark' }}">Pesanan Saya</a>
                                </li>
                                <li class="nav-item mt-3"><strong class="text-muted">Lainnya</strong></li>
                                <li class="nav-item">
                                    <a href="{{ route('profile.notifikasi') }}"
                                        class="nav-link px-0{{ request()->routeIs('profile.notifikasi') ? ' active text-danger' : ' text-dark' }}">Notifikasi</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('profile.voucher') }}"
                                        class="nav-link px-0{{ request()->routeIs('profile.voucher') ? ' active text-danger' : ' text-dark' }}">Voucher Saya</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('profile.koin') }}"
                                        class="nav-link px-0{{ request()->routeIs('profile.koin') ? ' active text-danger' : ' text-dark' }}">Koin Shopee Saya</a>
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
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dibatalkan"
                                            type="button">Dibatalkan</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pesananTabContent">
                                    {{-- Semua --}}
                                    <div class="tab-pane fade show active" id="semua">
                                        @forelse($pesanan as $item)
                                            <div class="card mb-3">
                                                <div class="card-header d-flex flex-wrap justify-content-between">
                                                    <span class="text-muted small">Order ID: INV/{{ str_pad($item['id'], 5, '0', STR_PAD_LEFT) }}</span>
                                                    @if($item['status'] == 'Belum Bayar')
                                                        <span class="badge bg-warning text-dark">Belum Bayar</span>
                                                    @elseif($item['status'] == 'Diproses')
                                                        <span class="badge bg-info text-dark">Diproses</span>
                                                    @elseif($item['status'] == 'Dikirim')
                                                        <span class="badge bg-primary">Dikirim</span>
                                                    @elseif($item['status'] == 'Selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @elseif($item['status'] == 'Dibatalkan')
                                                        <span class="badge bg-danger">Dibatalkan</span>
                                                    @endif
                                                </div>
                                                <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                    <img src="{{ asset('images/product-sample.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                        width="80" height="80" alt="Product">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item['produk'] }}</h6>
                                                        <p class="mb-0 text-muted small">{{ $item['jumlah'] }} x Rp{{ number_format($item['harga'],0,',','.') }}</p>
                                                    </div>
                                                    <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                        <p class="mb-1">Total Belanja</p>
                                                        <strong>Rp{{ number_format($item['jumlah'] * $item['harga'],0,',','.') }}</strong><br>
                                                        @if($item['status'] == 'Belum Bayar')
                                                            <button class="btn btn-danger btn-sm mt-2">Bayar Sekarang</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info">Belum ada pesanan.</div>
                                        @endforelse
                                    </div>
                                    {{-- Belum Bayar --}}
                                    <div class="tab-pane fade" id="belumBayar">
                                        @php $filtered = collect($pesanan)->where('status', 'Belum Bayar'); @endphp
                                        @forelse($filtered as $item)
                                            <div class="card mb-3">
                                                <div class="card-header d-flex flex-wrap justify-content-between">
                                                    <span class="text-muted small">Order ID: INV/{{ str_pad($item['id'], 5, '0', STR_PAD_LEFT) }}</span>
                                                    <span class="badge bg-warning text-dark">Belum Bayar</span>
                                                </div>
                                                <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                    <img src="{{ asset('images/product-sample.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                        width="80" height="80" alt="Product">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item['produk'] }}</h6>
                                                        <p class="mb-0 text-muted small">{{ $item['jumlah'] }} x Rp{{ number_format($item['harga'],0,',','.') }}</p>
                                                    </div>
                                                    <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                        <p class="mb-1">Total Belanja</p>
                                                        <strong>Rp{{ number_format($item['jumlah'] * $item['harga'],0,',','.') }}</strong><br>
                                                        <button class="btn btn-danger btn-sm mt-2">Bayar Sekarang</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info">Tidak ada pesanan yang belum dibayar.</div>
                                        @endforelse
                                    </div>
                                    {{-- Diproses --}}
                                    <div class="tab-pane fade" id="diproses">
                                        @php $filtered = collect($pesanan)->where('status', 'Diproses'); @endphp
                                        @forelse($filtered as $item)
                                            <div class="card mb-3">
                                                <div class="card-header d-flex flex-wrap justify-content-between">
                                                    <span class="text-muted small">Order ID: INV/{{ str_pad($item['id'], 5, '0', STR_PAD_LEFT) }}</span>
                                                    <span class="badge bg-info text-dark">Diproses</span>
                                                </div>
                                                <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                    <img src="{{ asset('images/product-sample.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                        width="80" height="80" alt="Product">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item['produk'] }}</h6>
                                                        <p class="mb-0 text-muted small">{{ $item['jumlah'] }} x Rp{{ number_format($item['harga'],0,',','.') }}</p>
                                                    </div>
                                                    <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                        <p class="mb-1">Total Belanja</p>
                                                        <strong>Rp{{ number_format($item['jumlah'] * $item['harga'],0,',','.') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info">Tidak ada pesanan yang sedang diproses.</div>
                                        @endforelse
                                    </div>
                                    {{-- Dikirim --}}
                                    <div class="tab-pane fade" id="dikirim">
                                        @php $filtered = collect($pesanan)->where('status', 'Dikirim'); @endphp
                                        @forelse($filtered as $item)
                                            <div class="card mb-3">
                                                <div class="card-header d-flex flex-wrap justify-content-between">
                                                    <span class="text-muted small">Order ID: INV/{{ str_pad($item['id'], 5, '0', STR_PAD_LEFT) }}</span>
                                                    <span class="badge bg-primary">Dikirim</span>
                                                </div>
                                                <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                    <img src="{{ asset('images/product-sample.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                        width="80" height="80" alt="Product">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item['produk'] }}</h6>
                                                        <p class="mb-0 text-muted small">{{ $item['jumlah'] }} x Rp{{ number_format($item['harga'],0,',','.') }}</p>
                                                    </div>
                                                    <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                        <p class="mb-1">Total Belanja</p>
                                                        <strong>Rp{{ number_format($item['jumlah'] * $item['harga'],0,',','.') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info">Tidak ada pesanan yang sedang dikirim.</div>
                                        @endforelse
                                    </div>
                                    {{-- Selesai --}}
                                    <div class="tab-pane fade" id="selesai">
                                        @php $filtered = collect($pesanan)->where('status', 'Selesai'); @endphp
                                        @forelse($filtered as $item)
                                            <div class="card mb-3">
                                                <div class="card-header d-flex flex-wrap justify-content-between">
                                                    <span class="text-muted small">Order ID: INV/{{ str_pad($item['id'], 5, '0', STR_PAD_LEFT) }}</span>
                                                    <span class="badge bg-success">Selesai</span>
                                                </div>
                                                <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                    <img src="{{ asset('images/product-sample.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                        width="80" height="80" alt="Product">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item['produk'] }}</h6>
                                                        <p class="mb-0 text-muted small">{{ $item['jumlah'] }} x Rp{{ number_format($item['harga'],0,',','.') }}</p>
                                                    </div>
                                                    <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                        <p class="mb-1">Total Belanja</p>
                                                        <strong>Rp{{ number_format($item['jumlah'] * $item['harga'],0,',','.') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info">Tidak ada pesanan yang sudah selesai.</div>
                                        @endforelse
                                    </div>
                                    {{-- Dibatalkan --}}
                                    <div class="tab-pane fade" id="dibatalkan">
                                        @php $filtered = collect($pesanan)->where('status', 'Dibatalkan'); @endphp
                                        @forelse($filtered as $item)
                                            <div class="card mb-3">
                                                <div class="card-header d-flex flex-wrap justify-content-between">
                                                    <span class="text-muted small">Order ID: INV/{{ str_pad($item['id'], 5, '0', STR_PAD_LEFT) }}</span>
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                </div>
                                                <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                                    <img src="{{ asset('images/product-sample.jpg') }}" class="me-3 mb-3 mb-md-0"
                                                        width="80" height="80" alt="Product">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item['produk'] }}</h6>
                                                        <p class="mb-0 text-muted small">{{ $item['jumlah'] }} x Rp{{ number_format($item['harga'],0,',','.') }}</p>
                                                    </div>
                                                    <div class="ms-md-auto text-end mt-3 mt-md-0">
                                                        <p class="mb-1">Total Belanja</p>
                                                        <strong>Rp{{ number_format($item['jumlah'] * $item['harga'],0,',','.') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info">Tidak ada pesanan yang dibatalkan.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                    </div> <!-- row -->
                </div> <!-- col-lg-9 -->
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
