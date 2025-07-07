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
                                    <table class="table table-borderless mb-0" id="profileTable">
                                        <tr>
                                            <th class="text-muted" style="width: 180px;">Username</th>
                                            <td id="profileUsername">-</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Nama</th>
                                            <td id="profileName">-</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Email</th>
                                            <td id="profileEmail">-</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Nomor Telepon</th>
                                            <td id="profilePhone">-</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">No KTP</th>
                                            <td id="profileKtp">-</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Tanggal Dibuat</th>
                                            <td id="profileCreatedAt">-</td>
                                        </tr>
                                    </table>
                                </div>
                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    function formatTanggalIndonesia(dateString) {
                                        if (!dateString) return '-';
                                        const bulanIndo = [
                                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                        ];
                                        const date = new Date(dateString);
                                        if (isNaN(date)) return '-';
                                        const hari = date.getDate();
                                        const bulan = bulanIndo[date.getMonth()];
                                        const tahun = date.getFullYear();
                                        return `${hari} ${bulan} ${tahun}`;
                                    }

                                    fetch('{{ route('profile.getUsers') }}')
                                        .then(response => response.json())
                                        .then(users => {
                                            if (users.length > 0) {
                                                const user = users[0];
                                                document.getElementById('profileUsername').textContent = user.username ?? '-';
                                                document.getElementById('profileName').textContent = user.name ?? '-';
                                                document.getElementById('profileEmail').textContent = user.email ?? '-';
                                                document.getElementById('profilePhone').textContent = user.no_hp ?? '-';
                                                document.getElementById('profileKtp').textContent = user.no_ktp ?? '-';
                                                document.getElementById('profileCreatedAt').textContent = formatTanggalIndonesia(user.created_at);
                                            }
                                        });
                                });
                                </script>
                            </div>
                        </div>

                        <!-- Profil Gambar -->
                        <div class="col-12 col-lg-4 order-1 order-lg-2 mb-4 mb-lg-0">
                            <div
                                class="p-3 border rounded shadow-sm bg-white text-center h-100 d-flex flex-column justify-content-center align-items-center">
                                <div class="d-flex flex-column align-items-center w-100" style="margin-bottom: 20px; margin-top: -10px;">
                                    <img src="{{ asset('assets_profile/images/reviewer-2.jpg') }}"
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
