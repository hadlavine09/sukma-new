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
                                    Saya</a>
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
                    <div class="col-12 order-2 order-lg-1">
                        <div class="p-4 border rounded shadow-sm bg-white h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">Alamat Saya</h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahAlamat">
                                    Tambah Alamat
                                </button>
                            </div>

                            @if (empty($alamat_user))
                                <div class="alert alert-info">Belum ada alamat yang terdaftar untuk akun ini.</div>
                            @else
                                @foreach ($alamat_user as $index => $alamat)
                                    <div class="card mb-3 {{ $alamat['utama'] ? 'border-success' : 'border-secondary' }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="card-title fw-bold mb-2">
                                                    {{ $alamat['label'] }}
                                                    @if ($alamat['utama'])
                                                        <span class="badge bg-success">Utama</span>
                                                    @else
                                                        <span class="badge bg-secondary">Bukan Utama</span>
                                                    @endif
                                                </h6>
                                                <div class="text-end">
                                                    <a href="#" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                    @if (!$alamat['utama'])
                                                        <form action="" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="btn btn-sm btn-outline-success">Jadikan
                                                                Utama</button>
                                                        </form>
                                                    @endif
                                                </div>
                                                {{-- <div class="text-end">
                                                    <a href="#" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                    @if (!$alamat['utama'])
                                                        <form
                                                            action="{{ route('profile.alamat.setUtama', ['id' => $index]) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="btn btn-sm btn-outline-success">Jadikan
                                                                Utama</button>
                                                        </form>
                                                    @endif
                                                </div> --}}
                                            </div>
                                            <p class="mb-1"><strong>Penerima:</strong> {{ $alamat['nama_penerima'] }}</p>
                                            <p class="mb-1"><strong>Telepon:</strong> {{ $alamat['telepon'] }}</p>
                                            <p class="mb-1">
                                                <strong>Alamat:</strong> {{ $alamat['alamat_lengkap'] }},
                                                {{ $alamat['kecamatan'] }}, {{ $alamat['kota'] }},
                                                {{ $alamat['provinsi'] }} - {{ $alamat['kode_pos'] }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!-- col-lg-9 -->
            </div> <!-- row -->

            <div class="modal fade" id="modalTambahAlamat" tabindex="-1" aria-labelledby="modalTambahAlamatLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form action="" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahAlamatLabel">Tambah Alamat Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Penerima</label>
                                    <input type="text" name="nama_penerima" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Telepon</label>
                                    <input type="text" name="telepon" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" class="form-control" required></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kota</label>
                                    <input type="text" name="kota" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Label Alamat</label>
                                    <select name="label" class="form-select">
                                        <option value="Rumah">Rumah</option>
                                        <option value="Kantor">Kantor</option>
                                        <option value="Apartemen">Apartemen</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="utama" value="1"
                                            id="utamaCheck">
                                        <label class="form-check-label" for="utamaCheck">
                                            Jadikan Alamat Utama
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer mt-3">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <style>
                .card.border-success {
                    border-left: 4px solid #198754;
                }

                .card.border-secondary {
                    border-left: 4px solid #6c757d;
                }

                .card .badge {
                    font-size: 0.75rem;
                    padding: 0.35em 0.6em;
                    vertical-align: middle;
                }

                .modal .form-label {
                    font-weight: 500;
                }

                .modal .form-control,
                .modal .form-select {
                    border-radius: 0.5rem;
                }
            </style>
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

        <!-- Bootstrap JS (pastikan sudah ter-include jika belum di layout) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Custom JS -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const tambahModal = document.getElementById('modalTambahAlamat');
                if (tambahModal) {
                    tambahModal.addEventListener('shown.bs.modal', function() {
                        const input = document.querySelector('input[name="nama_penerima"]');
                        if (input) input.focus();
                    });
                }

                const formTambah = document.querySelector('form[action*="alamat/store"]');
                if (formTambah) {
                    formTambah.addEventListener("submit", function(e) {
                        const inputs = formTambah.querySelectorAll("input[required], textarea[required]");
                        let valid = true;
                        inputs.forEach(input => {
                            if (!input.value.trim()) {
                                input.classList.add("is-invalid");
                                valid = false;
                            } else {
                                input.classList.remove("is-invalid");
                            }
                        });
                        if (!valid) {
                            e.preventDefault();
                        }
                    });
                }
            });
        </script>
    </section>
@endsection
