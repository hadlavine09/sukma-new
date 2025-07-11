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
                                <h5 class="fw-bold mb-0">Rekening Bank</h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#tambahBankModal">
                                    + Tambah Bank
                                </button>
                            </div>

                            @if (empty($alamat_user))
                                <div class="alert alert-info mb-0">Belum ada bank yang terdaftar untuk akun ini.</div>
                            @else
                                {{-- Daftar bank yang sudah tersimpan --}}
                                <div class="list-group">
                                    @foreach ($alamat_user as $bank)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $bank->nama_bank }}</strong><br>
                                                <small>{{ $bank->no_rekening }} - {{ $bank->nama_pemilik }}</small>
                                            </div>
                                            <span class="badge bg-success">Terverifikasi</span>
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
                                            <option value="BCA"
                                                data-logo="https://upload.wikimedia.org/wikipedia/commons/thumb/6/69/BCA_logo.svg/512px-BCA_logo.svg.png">
                                                BCA</option>
                                            <option value="BNI"
                                                data-logo="https://upload.wikimedia.org/wikipedia/id/thumb/0/04/Logo_BNI.png/640px-Logo_BNI.png">
                                                BNI</option>
                                            <option value="BRI"
                                                data-logo="https://upload.wikimedia.org/wikipedia/id/thumb/c/cf/Bank_Rakyat_Indonesia.svg/512px-Bank_Rakyat_Indonesia.svg.png">
                                                BRI</option>
                                            <option value="Mandiri"
                                                data-logo="https://upload.wikimedia.org/wikipedia/id/thumb/4/4e/Bank_Mandiri_logo.svg/512px-Bank_Mandiri_logo.svg.png">
                                                Mandiri</option>
                                            <option value="BSI"
                                                data-logo="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Logo_BSI_Bank_Syariah_Indonesia.svg/512px-Logo_BSI_Bank_Syariah_Indonesia.svg.png">
                                                BSI</option>
                                            <option value="CIMB Niaga"
                                                data-logo="https://upload.wikimedia.org/wikipedia/id/thumb/2/2e/CIMB_Niaga_logo.svg/512px-CIMB_Niaga_logo.svg.png">
                                                CIMB Niaga</option>
                                            <option value="Permata"
                                                data-logo="https://upload.wikimedia.org/wikipedia/id/thumb/e/eb/Bank_Permata_logo.svg/512px-Bank_Permata_logo.svg.png">
                                                Permata</option>
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
                                        <label class="form-label">Nama Pemilik (Otomatis)</label>
                                        <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik"
                                            readonly>
                                    </div>

                                    <!-- Tombol Verifikasi -->
                                    <button type="button" class="btn btn-info btn-sm" onclick="verifikasiRekening()">
                                        Verifikasi Rekening
                                    </button>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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

                    function verifikasiRekening() {
                        const norek = document.getElementById('no_rekening').value;

                        if (!norek) {
                            alert('Masukkan nomor rekening terlebih dahulu.');
                            return;
                        }

                        // Simulasi: Ganti dengan API asli jika tersedia
                        fetch(`https://api.fakebank.id/cek-norek?norek=${norek}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    document.getElementById('nama_pemilik').value = data.nama;
                                    alert('Rekening terverifikasi!');
                                } else {
                                    alert('Nomor rekening tidak valid.');
                                }
                            })
                            .catch(() => alert('Gagal terhubung ke server.'));
                    }
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
