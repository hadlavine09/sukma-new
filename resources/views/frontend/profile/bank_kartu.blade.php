@extends('frontend.component.main')
@section('contentfrontend')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CSS dan JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        #verif_password {
            padding-right: 2.75rem;
            /* ruang untuk ikon */
        }

        .toggle-password-btn {
            border: none;
            background: transparent;
            position: absolute;
            top: 75%;
            right: 0.75rem;
            transform: translateY(-50%);
            padding: 0;
            cursor: pointer;
        }

        .toggle-password-btn i {
            color: #000;
            transition: color 0.2s;
            font-size: 1.1rem;
        }

        .toggle-password-btn:hover i {
            color: #0d6efd;
        }
    </style>



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
                                <strong>{{ $user->username }}</strong><br>
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
                                <h5 class="fw-bold mb-0">Rekening Bank</h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#tambahBankModal">
                                    + Tambah Bank
                                </button>
                            </div>

                            @if ($bank_users->isEmpty())
                                <div class="alert alert-info mb-0">Belum ada bank yang terdaftar untuk akun ini.</div>
                            @else
                                {{-- Daftar bank yang sudah tersimpan --}}
                                <div class="list-group">
                                    @foreach ($bank_users as $bank_user)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $bank_user->nama_bank }}</strong><br>
                                                <small>{{ $bank_user->no_rekening }} -
                                                    {{ $bank_user->nama_pemilik }}</small>
                                            </div>
                                            <div>
                                                <form method="POST"
                                                    action="{{ route('profile.bank.delete', $bank_user->id) }}"
                                                    class="d-inline" onsubmit="return showPasswordConfirmModal(event)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="password" id="modal_password_input">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal Tambah Bank -->
                <div class="modal fade" id="tambahBankModal" tabindex="-1" aria-labelledby="tambahBankModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="formTambahBank" method="POST" action="{{ route('profile.bank.tambah') }}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Rekening Bank</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>

                                <div class="modal-body">

                                    <!-- Dropdown Bank -->
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Bank</label>
                                        <select class="form-select" name="nama_bank" id="nama_bank"
                                            onchange="updateBankLogo()" required>
                                            <option value="" selected disabled>-- Pilih Bank --</option>
                                            @foreach ($banks as $data)
                                                <option value="{{ $data->nama }}"
                                                    data-logo="{{ asset('image/logobank/' . $data->logo_filename) }}">
                                                    {{ $data->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Logo Bank Preview -->
                                    <div class="mb-3 text-center">
                                        <img id="logo_bank_preview" src="" alt="Logo Bank"
                                            style="max-height: 40px; display: none; border: 1px solid #ddd; padding: 6px; border-radius: 6px;">
                                    </div>

                                    <!-- Nomor Rekening -->
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Rekening</label>
                                        <input type="text" class="form-control" name="no_rekening" id="no_rekening"
                                            required>
                                    </div>

                                    <!-- Nama Pemilik -->
                                    <div class="mb-3">
                                        <label class="form-label">Nama Pemilik</label>
                                        <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik"
                                            required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Verifikasi Password -->
                <div class="modal fade" id="passwordConfirmModal" tabindex="-1"
                    aria-labelledby="passwordConfirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="passwordConfirmForm">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="passwordConfirmModalLabel">Verifikasi Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 position-relative">
                                        <label for="verif_password" class="form-label">Masukkan Password Anda</label>
                                        <input type="password" class="form-control" id="verif_password" required>

                                        <!-- Button Icon Eye -->
                                        <button type="button" class="toggle-password-btn" onclick="togglePassword()"
                                            aria-label="Toggle Password Visibility">
                                            <i id="togglePasswordIcon" class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Lanjutkan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>





                <!-- Script Preview Logo -->
                <script>
                    function updateBankLogo() {
                        const select = document.getElementById('nama_bank');
                        const selectedOption = select.options[select.selectedIndex];
                        const logoUrl = selectedOption.getAttribute('data-logo');
                        const logoPreview = document.getElementById('logo_bank_preview');

                        if (logoUrl) {
                            logoPreview.src = logoUrl;
                            logoPreview.style.display = 'inline-block';
                        } else {
                            logoPreview.style.display = 'none';
                        }
                    }
                </script>

                <!-- SweetAlert Success -->
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: '{{ session('success') }}',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    </script>
                @endif

                <!-- SweetAlert Error -->
                @if (session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: '{{ session('error') }}',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK'
                        });
                    </script>
                @endif
                <script>
                    let currentForm = null;

                    function showPasswordConfirmModal(event) {
                        event.preventDefault();
                        currentForm = event.target;
                        const modal = new bootstrap.Modal(document.getElementById('passwordConfirmModal'));
                        modal.show();
                        return false;
                    }

                    document.getElementById('passwordConfirmForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const password = document.getElementById('verif_password').value;
                        if (!password) return;

                        if (currentForm.querySelector('#modal_password_input')) {
                            currentForm.querySelector('#modal_password_input').value = password;
                        }

                        currentForm.submit();
                    });

                    function togglePassword() {
                        const input = document.getElementById('verif_password');
                        const icon = document.getElementById('togglePasswordIcon');

                        if (input.type === "password") {
                            input.type = "text";
                            icon.classList.remove("bi-eye-slash");
                            icon.classList.add("bi-eye");
                        } else {
                            input.type = "password";
                            icon.classList.remove("bi-eye");
                            icon.classList.add("bi-eye-slash");
                        }
                    }

                    // SweetAlert Feedback
                    @if (session('success'))
                        Swal.fire('Berhasil', '{{ session('success') }}', 'success');
                    @endif

                    @if (session('error'))
                        Swal.fire('Gagal', '{{ session('error') }}', 'error');
                    @endif
                </script>


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
