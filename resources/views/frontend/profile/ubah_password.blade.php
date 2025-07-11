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
                @php
                    use Illuminate\Support\Facades\Cache;
                    $passwordCache = Cache::get('user_password_' . Auth::id());
                @endphp
                <!-- Konten Kanan -->
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="col-12 col-md-8 col-lg-9">
                        <div class="p-4 border rounded shadow-sm bg-white h-100">
                            <h5 class="fw-bold mb-3">Ubah Password</h5>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any() && !$errors->has('verifikasi_password'))
                                <div class="alert alert-danger rounded">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Kartu Password -->
                            <div class="card-password">
                                <div class="mb-3 text-muted">
                                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                                    ({{ Auth::user()->email }})
                                </div>


                                <div class="info-group">
                                    <div class="label">Nama Pengguna</div>
                                    <div class="value">
                                        <span id="usernameText">{{ Auth::user()->username ?? 'namauser' }}</span>
                                        <button class="icon-button" onclick="copyToClipboard('usernameText')">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="info-group">
                                    <div class="label">Sandi</div>
                                    <div class="value">
                                        <input type="password" id="passwordField"
                                            class="form-control border-0 p-0 bg-transparent"
                                            value="{{ $passwordCache ?? '********' }}" readonly style="max-width: 150px;">

                                        <div class="d-flex align-items-center">
                                            <!-- Tombol Lihat Sandi -->
                                            <button class="icon-button me-2" onclick="handlePasswordClick()" type="button">
                                                <i class="bi bi-eye" id="toggleIcon"></i>
                                            </button>

                                            <!-- Tombol Salin Sandi -->
                                            <button class="icon-button" onclick="copyToClipboard('passwordField')"
                                                type="button" @if (!$isVerified) disabled @endif
                                                title="{{ $isVerified ? 'Salin sandi' : 'Akun belum diverifikasi' }}">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <div class="note-box">Tidak ada catatan yang ditambahkan</div>

                                <div class="footer-buttons">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalUbahPassword">Edit</button>

                                    <form action="{{ route('profile.delete-account') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- Modal Verifikasi Password -->
                        <div class="modal fade" id="verifikasiPasswordModal" tabindex="-1"
                            aria-labelledby="verifikasiPasswordModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('profile.verifikasi-password') }}"
                                    class="modal-content">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="verifikasiPasswordModalLabel">Verifikasi Password</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-muted">Untuk alasan keamanan, masukkan password saat ini Anda.</p>
                                        <input type="password" name="verifikasi_password" class="form-control"
                                            placeholder="Password saat ini" required>
                                        @error('verifikasi_password')
                                            <div class="text-danger mt-2 small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Lanjutkan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Ubah Password -->
                        <div class="modal fade" id="modalUbahPassword" tabindex="-1"
                            aria-labelledby="modalUbahPasswordLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content rounded-4 shadow-sm">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="modalUbahPasswordLabel">Ubah Password</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Tutup"></button>
                                    </div>
                                    <form method="POST" action="{{ route('profile.update-password') }}">
                                        @csrf
                                        <div class="modal-body">
                                            {{-- Password Saat Ini --}}
                                            <div class="mb-3">
                                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="current_password"
                                                        name="current_password" required>
                                                    <button type="button"
                                                        class="btn btn-outline-secondary toggle-password"
                                                        data-target="current_password">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Password Baru --}}
                                            <div class="mb-3">
                                                <label for="new_password" class="form-label">Password Baru</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="new_password"
                                                        name="new_password" required>
                                                    <button type="button"
                                                        class="btn btn-outline-secondary toggle-password"
                                                        data-target="new_password">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Konfirmasi Password Baru --}}
                                            <div class="mb-3">
                                                <label for="new_password_confirmation" class="form-label">Konfirmasi
                                                    Password Baru</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control"
                                                        id="new_password_confirmation" name="new_password_confirmation"
                                                        required>
                                                    <button type="button"
                                                        class="btn btn-outline-secondary toggle-password"
                                                        data-target="new_password_confirmation">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Bootstrap Icons -->
                        <link rel="stylesheet"
                            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

                        <style>
                            .card-password {
                                border: 1px solid #ddd;
                                border-radius: 10px;
                                padding: 20px;
                                background-color: #fff;
                                margin-top: 10px;
                            }

                            .card-password .info-group {
                                background-color: #f9fafb;
                                border-radius: 10px;
                                padding: 10px 15px;
                                margin-bottom: 15px;
                            }

                            .card-password .label {
                                font-size: 12px;
                                color: #6c757d;
                                margin-bottom: 2px;
                            }

                            .card-password .value {
                                font-weight: 500;
                                font-size: 15px;
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                            }

                            .card-password .icon-button {
                                background: none;
                                border: none;
                                cursor: pointer;
                                padding: 5px;
                            }

                            .card-password .note-box {
                                background-color: #f1f3f4;
                                border-radius: 10px;
                                padding: 12px 15px;
                                font-size: 14px;
                                color: #888;
                                margin-bottom: 15px;
                            }

                            .card-password .footer-buttons {
                                display: flex;
                                justify-content: flex-end;
                                gap: 10px;
                            }
                        </style>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <script>
                            function togglePassword() {
                                const input = document.getElementById('passwordField');
                                const icon = document.getElementById('toggleIcon');

                                if (input.type === 'password') {
                                    input.type = 'text';
                                    icon.classList.remove('bi-eye');
                                    icon.classList.add('bi-eye-slash');
                                } else {
                                    input.type = 'password';
                                    icon.classList.remove('bi-eye-slash');
                                    icon.classList.add('bi-eye');
                                }
                            }

                            function handlePasswordClick() {
                                const passwordField = document.getElementById('passwordField');
                                const icon = document.getElementById('toggleIcon');

                                if (passwordField.value === '********') {
                                    // Belum diverifikasi → buka modal
                                    const modal = new bootstrap.Modal(document.getElementById('verifikasiPasswordModal'));
                                    modal.show();
                                } else {
                                    togglePassword();
                                }
                            }

                            function copyToClipboard(id) {
                                const el = document.getElementById(id);
                                const val = el.value || el.textContent;

                                navigator.clipboard.writeText(val).then(() => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil Disalin!',
                                        text: 'Teks: "' + val + '" telah disalin ke clipboard.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }).catch(err => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal Menyalin',
                                        text: 'Terjadi kesalahan saat menyalin teks.',
                                    });
                                });
                            }

                            document.querySelectorAll('.toggle-password').forEach(button => {
                                button.addEventListener('click', function() {
                                    const targetId = this.getAttribute('data-target');
                                    const input = document.getElementById(targetId);
                                    const icon = this.querySelector('i');

                                    if (input.type === 'password') {
                                        input.type = 'text';
                                        icon.classList.remove('bi-eye');
                                        icon.classList.add('bi-eye-slash');
                                    } else {
                                        input.type = 'password';
                                        icon.classList.remove('bi-eye-slash');
                                        icon.classList.add('bi-eye');
                                    }
                                });
                            });
                        </script>

                        @if ($errors->has('verifikasi_password'))
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const modal = new bootstrap.Modal(document.getElementById('verifikasiPasswordModal'));
                                    modal.show();
                                });
                            </script>
                        @endif
                        <!-- col-lg-9 -->
                    </div> <!-- row -->
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

    </section>
@endsection
