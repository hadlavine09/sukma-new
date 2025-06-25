@extends('frontend.component.main')
@section('contentfrontend')

<section class="py-5" style="background-color: #f9f9f9;">
    <div class="container-fluid">
        <div class="row">
            <!-- Card Menu -->
            <div class="col-lg-3 mb-4">
                <div class="bg-white p-3 shadow-sm border rounded">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/default-profile.png') }}" class="rounded-circle me-2" width="40" height="40" alt="Profile">
                        <div>
                            <strong>{{ $user->username ?? 'Username' }}</strong><br>
                            <a href="#" class="text-primary text-decoration-none small">✎ Ubah Profil</a>
                        </div>
                    </div>
                    <hr>
                    <ul class="nav flex-column small">
                        <li class="nav-item mb-2"><strong class="text-muted">Akun Saya</strong></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 text-danger">Profil</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 text-dark">Bank & Kartu</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 text-dark">Alamat</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 text-dark">Ubah Password</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 text-dark">Pengaturan Notifikasi</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 text-dark">Pengaturan Privasi</a></li>
                        <li class="nav-item mt-3"><strong class="text-muted">Pesanan Saya</strong></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 text-dark">Pesanan Saya</a></li>
                        <li class="nav-item mt-3"><strong class="text-muted">Lainnya</strong></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 text-dark">Notifikasi</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 text-dark">Voucher Saya</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 text-dark">Koin Shopee Saya</a></li>
                    </ul>
                </div>
            </div>

            <!-- Card Content + Card Profile -->
            <div class="col-lg-9">
                <div class="row gy-4">
                    <!-- Card Content -->
                    <div class="col-md-8">
                        <div class="p-4 border rounded shadow-sm bg-white">
                            <h5 class="fw-bold mb-3">Profil Saya</h5>
                            <p class="text-muted small mb-4">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>

                            <form action="#" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" value="{{ $user->username ?? '' }}" readonly>
                                    <small class="text-muted">Username hanya dapat diubah satu (1) kali.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="d-flex align-items-center">
                                        <input type="email" class="form-control me-2" value="{{ $user->email ?? '' }}" readonly>
                                        <a href="#" class="text-decoration-none">Ubah</a>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $user->phone ?? '' }}" placeholder="Tambah">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Toko</label>
                                    <input type="text" class="form-control" name="store_name" value="{{ $user->store_name ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label d-block">Jenis Kelamin</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Laki-laki" {{ ($user->gender ?? '') == 'Laki-laki' ? 'checked' : '' }}>
                                        <label class="form-check-label">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Perempuan" {{ ($user->gender ?? '') == 'Perempuan' ? 'checked' : '' }}>
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Lainnya" {{ ($user->gender ?? '') == 'Lainnya' ? 'checked' : '' }}>
                                        <label class="form-check-label">Lainnya</label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <select class="form-select" name="birth_day" style="flex: 1;">
                                            <option>Tanggal</option>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <select class="form-select" name="birth_month" style="flex: 1;">
                                            <option>Bulan</option>
                                            @foreach ([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num => $month)
                                                <option value="{{ $num }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-select" name="birth_year" style="flex: 1;">
                                            <option>Tahun</option>
                                            @for ($year = date('Y'); $year >= 1900; $year--)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-danger px-4">Simpan</button>
                            </form>
                        </div>
                    </div>
<div class="col-md-4">
    <div class="p-3 border rounded shadow-sm bg-white text-center h-50 d-flex flex-column justify-content-center">

        <!-- Gambar Besar, Geser ke Atas -->
        <div class="d-flex flex-column align-items-center" style="margin-bottom: 20px; margin-top: -10px;">
            <img
                src="{{ asset('assets_frontend/images/reviewer-2.jpg') }}"
                class="rounded-circle border img-fluid mb-4"
                style="max-width: 200px; height: auto; cursor: pointer;"
                alt="Profile"
                data-bs-toggle="modal"
                data-bs-target="#profileModal"
            >

            <button type="button" class="btn btn-outline-secondary btn-sm">Pilih Gambar</button>
            <div class="text-muted small mt-2 text-center">
                Ukuran gambar maks. 1 MB<br>Format: JPEG, PNG
            </div>
        </div>

    </div>
</div>

<!-- Modal ukuran kecil -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img
                    src="{{ asset('logo/logo2.png') }}"
                    class="img-fluid rounded"
                    alt="Profile Besar"
                >
            </div>
        </div>
    </div>
</div>

                </div> <!-- row -->
            </div>
        </div> <!-- row -->
    </div>
</section>

@endsection
