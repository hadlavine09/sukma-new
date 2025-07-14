<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Verifikasi Toko - Step {{ $step }}</title>
      <link rel="stylesheet" href="{{ asset('assets_frontend/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <nav class="shopee-navbar" role="navigation" aria-label="Main navigation">
    <div class="container">
        <div class="navbar-left">
            <a href="{{ url('/') }}">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="120"
                    height="108" viewBox="0 0 200 108">
                    <image id="logosukma" x="58" y="15" width="127" height="79"
                        xlink:href="">
                </svg>
            </a>
        </div>
        <div class="navbar-center">
            <form action="#" method="GET" class="search-form" role="search" aria-label="Product search form"
                onsubmit="return false;">
                <div class="search-input-wrapper">
                    <input type="text" name="searchInput" id="search-input"
                        placeholder="Cari produk, brand, dan lainnya" autocomplete="off" aria-autocomplete="list"
                        aria-controls="search-suggestions" aria-expanded="false" />
                    <button type="submit" aria-label="Search">
                        <svg fill="#777" height="20" width="20" viewBox="0 0 24 24" aria-hidden="true"
                            focusable="false">
                            <path
                                d="M21.71 20.29l-3.388-3.388a7.918 7.918 0 001.62-5.092C19.942 7.015 16.927 4 13.221 4S6.5 7.015 6.5 10.71c0 3.696 3.015 6.71 6.721 6.71a7.918 7.918 0 005.092-1.62l3.388 3.388c.39.39 1.025.39 1.414 0a1 1 0 000-1.414zM8 10.71a5.22 5.22 0 015.221-5.21 5.22 5.22 0 015.22 5.21 5.22 5.22 0 01-5.22 5.21A5.22 5.22 0 018 10.71z" />
                        </svg>
                    </button>
                </div>
                <ul id="search-suggestions" role="listbox" class="suggestions" hidden></ul>
            </form>
        </div>
        <div class="navbar-right d-flex align-items-center" style="gap: 1rem;">
            <!-- Cart Dropdown -->
            <div class="nav-cart-dropdown-wrapper position-relative" style="display:inline-block;">
                <a href="{{ route('frontend.keranjang') }}" class="nav-icon" aria-label="Keranjang Belanja"
                    title="Keranjang Belanja" id="cartDropdownBtn">
                    <svg fill="#fff" height="24" width="24" viewBox="0 0 24 24" aria-hidden="true"
                        focusable="false">
                        <path
                            d="M7 18c-1.104 0-2 .895-2 2 0 1.104.896 2 2 2 1.104 0 2-.896 2-2 0-1.105-.896-2-2-2zm10 0c-1.104 0-2 .895-2 2 0 1.104.896 2 2 2 1.104 0 2-.896 2-2 0-1.105-.896-2-2-2zM7.2 13h9.599c.75 0 1.423-.436 1.734-1.115l3.732-7.221-1.972-.972-3.069 5.917-5.727-.008L6.473 2.28A1 1 0 005.58 2H2v2h2.41l3.413 9.336a1.001 1.001 0 00.38.384l.998.6a1.007 1.007 0 00.999 0z" />
                    </svg>
                </a>
                <div id="cartDropdownCard" class="cart-dropdown-card card shadow border-0 position-absolute end-0 mt-2"
                    style="min-width:370px; max-width:400px; z-index:1000; display:none; opacity:0; transform:translateY(10px); transition:opacity 0.25s, transform 0.25s; border-radius:12px; overflow:hidden;">
                    <!-- ... (cart dropdown content remains unchanged) ... -->
                    <div class="cart-dropdown-header px-4 py-3"
                        style="background:#f44336; color:#fff; font-weight:600; font-size:1.1rem;">
                        Keranjang Belanja
                    </div>
                    <div class="cart-dropdown-body px-0 py-0" style="max-height:340px; overflow-y:auto;">
                        <ul class="list-group list-group-flush" id="cartDropdownList" style="background:#fff;">
                            <li class="list-group-item text-center text-muted py-5 empty-cart-message"
                                style="display:none; border:none;">
                                <div>
                                    <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart-empty-v2.png"
                                        alt="Empty Cart" style="width:80px; opacity:0.7;">
                                    <div class="mt-2" style="font-size:1rem;">Keranjang masih kosong</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="cart-dropdown-footer px-4 py-3"
                        style="background:#fafafa; border-top:1px solid #f0f0f0;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-weight:500;">Total</span>
                            <strong id="cartDropdownTotal" style="font-size:1.1rem;">Rp0</strong>
                        </div>
                        <a href="{{ route('frontend.keranjang') }}" class="btn btn-danger w-100" id="lihatKeranjangBtn"
                            style="border-radius:6px;">
                            Lihat Keranjang
                        </a>
                    </div>
                    <div class="px-3 pb-2" style="display:none;">
                        <pre id="cartJsonData" style="font-size:12px; background:#f8f9fa; border-radius:4px; padding:8px; overflow:auto;"></pre>
                    </div>
                </div>

            </div>
            <!-- End Cart Dropdown -->

            <!-- Profile Dropdown -->
            <div class="profile-dropdown-wrapper" style="margin-left: 0.5rem;">
                <style>
                    .profile-btn {
                        background-color: #e5e7eb;
                        border-radius: 9999px;
                        width: 2rem;
                        height: 2rem;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: #000;
                        font-weight: bold;
                        cursor: pointer;
                        position: relative;
                        z-index: 101;
                    }

                    .profile-dropdown-wrapper {
                        position: relative;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    }

                    .profile-dropdown {
                        position: absolute;
                        top: 110%;
                        right: 0;
                        min-width: 10rem;
                        background-color: #fff;
                        border: 1px solid #ddd;
                        border-radius: 0.25rem;
                        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
                        display: none;
                        z-index: 100;
                    }

                    .profile-dropdown.show {
                        display: block;
                    }

                    .profile-dropdown a {
                        display: block;
                        text-align: left;
                        padding: 0.5rem 1rem;
                        color: #333;
                        background: none;
                        border: none;
                        cursor: pointer;
                        font-size: 0.9rem;
                    }

                    .profile-dropdown button {
                        width: 100%;
                        display: block;
                        text-align: left;
                        padding: 0.5rem 1rem;
                        color: #333;
                        background: none;
                        border: none;
                        cursor: pointer;
                        font-size: 0.9rem;
                    }

                    .profile-dropdown a:hover,
                    .profile-dropdown button:hover {
                        background-color: #f3f4f6;
                    }

                    .profile-name {
                        margin-left: 8px;
                        font-weight: 500;
                        color: #222;
                        font-size: 15px;
                        letter-spacing: 0.2px;
                        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
                    }

                    .profile-email {
                        margin-left: 12px;
                        font-size: 14px;
                        color: #555;
                        font-weight: 400;
                        white-space: nowrap;
                    }

                    @media (max-width: 900px) {
                        nav>div {
                            flex-direction: column;
                            align-items: flex-start !important;
                            gap: 10px;
                        }

                        nav>div>div {
                            width: 100%;
                            justify-content: flex-start !important;
                            gap: 10px;
                        }

                        .profile-email {
                            margin-left: 0;
                            margin-top: 4px;
                        }
                    }

                    @media (max-width: 600px) {
                        nav>div {
                            padding: 0 6px !important;
                        }

                        .profile-name {
                            display: none;
                        }

                        .profile-email {
                            display: none;
                        }

                        nav>div>div {
                            font-size: 13px;
                            gap: 6px;
                        }
                    }
                </style>
                @auth
                    @php
                        $emailInitial = strtoupper(substr(Auth::user()->email, 0, 1));
                    @endphp
                    <div class="profile-dropdown-wrapper">
                        <div class="profile-btn" onclick="toggleDropdown(event)">
                            {{ $emailInitial }}
                        </div>
                        <span class="profile-name">{{ Auth::user()->name }}</span>
                        <div id="dropdown" class="profile-dropdown">
                            <a href="{{ url('/profile') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-2 text-gray-600"
                                    fill="none" height="24" width="24" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A4.992 4.992 0 0112 15a4.992 4.992 0 016.879 2.804M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                                </svg>
                                Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="inline-block w-5 h-5 mr-2 text-gray-600" fill="none" height="24"
                                        width="24" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('register2') }}" class="nav-login" tabindex="0">Daftar</a>
                    <span class="mx-1 text-black">|</span>
                    <a href="{{ route('login') }}" class="nav-login" tabindex="0">Login</a>
                @endauth

                <script>
                    function toggleDropdown(event) {
                        event.stopPropagation();
                        var dropdown = document.getElementById("dropdown");
                        dropdown.classList.toggle("show");
                    }
                    document.addEventListener('click', function(event) {
                        var profileBtn = document.querySelector('.profile-btn');
                        var dropdown = document.getElementById('dropdown');
                        if (!profileBtn.contains(event.target) && !dropdown.contains(event.target)) {
                            dropdown.classList.remove('show');
                        }
                    });
                </script>
            </div>
            <!-- End Profile Dropdown -->
        </div>
</nav>
<section class="py-5 overflow-hidden">
    <div class="container-fluid px-3 px-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body py-4 px-3 px-md-5">

                @php
                    $steps = ['Informasi Toko', 'Dokumen', 'Rekening', 'Kontak Sosial', 'Jadwal'];
                @endphp

                <!-- Step Indicator -->
                <div class="d-flex justify-content-between mb-5 overflow-auto step-indicator-scroll pb-3">
                    @foreach ($steps as $index => $label)
                        <div class="text-center flex-fill position-relative" style="min-width: 120px;">
                            <div class="mb-2">
                                <div class="rounded-circle mx-auto
                                    {{ $step == $index + 1 ? 'bg-primary text-white' : ($step > $index + 1 ? 'bg-success text-white' : 'bg-light text-dark') }}"
                                    style="width: 40px; height: 40px; line-height: 40px; font-weight: 600;">
                                    {{ $index + 1 }}
                                </div>
                            </div>
                            <small class="fw-medium d-block">{{ $label }}</small>

                            @if ($index < count($steps) - 1)
                                <div class="position-absolute top-50 start-100 translate-middle-y"
                                     style="width: 100%; height: 2px; background: {{ $step > $index + 1 ? '#198754' : '#dee2e6' }};">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Form Start -->
                <form action="{{ route('verifikasitokostore', ['step' => $step]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- STEP 1 --}}
                    @if ($step == 1)
                        <h4 class="mb-4 fw-semibold">Informasi Toko</h4>

                        <div class="mb-3">
                            <label class="form-label">Nama Toko</label>
                            <input type="text" name="nama_toko" class="form-control"
                                   value="{{ old('nama_toko', $toko->nama_toko ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Toko</label>
                            <select name="kategori_toko_id" id="kategori_toko_id" class="form-select" required>
                                <option selected disabled hidden>-- Pilih Kategori --</option>
                                @foreach ($kategori_tokos as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ old('kategori_toko_id', $toko->kategori_toko_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori_toko }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="kategori_toko" hidden>
                            <label class="form-label">Input Kategori Toko</label>
                            <input type="text" name="kategori_toko" class="form-control"
                                   value="{{ old('kategori_toko') }}">
                        </div>

                        <script>
                            $(document).ready(function () {
                                const toggleKategoriInput = () => {
                                    $('#kategori_toko').prop('hidden', $('#kategori_toko_id').val() != 20);
                                };
                                toggleKategoriInput();
                                $('#kategori_toko_id').on('change', toggleKategoriInput);
                            });
                        </script>

                        <div class="mb-3">
                            <label class="form-label">No. HP Toko</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="text" name="no_hp_toko" class="form-control" maxlength="15"
                                       value="{{ old('no_hp_toko', ltrim(ltrim($toko->no_hp_toko ?? '', '+62'), '0')) }}"
                                       required oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat_toko" class="form-control" rows="3" required>{{ old('alamat_toko', $toko->alamat_toko ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Logo Toko</label>
                            <input type="file" name="logo_toko" class="form-control" accept="image/*">
                            @if (!empty($toko->logo_toko))
                                <img src="{{ asset('storage/' . $toko->logo_toko) }}" width="200" class="mt-2">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi_toko" class="form-control" rows="3">{{ old('deskripsi_toko', $toko->deskripsi_toko ?? '') }}</textarea>
                        </div>
                    @endif

                    {{-- STEP 2 --}}
                    @if ($step == 2)
                        <h4 class="mb-4 fw-semibold">Dokumen Identitas</h4>

                        <div class="mb-3">
                            <label class="form-label">Nama KTP</label>
                            <input type="text" name="nama_ktp" class="form-control"
                                   value="{{ old('nama_ktp', $toko->detailToko->nama_ktp ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor KTP</label>
                            <input type="text" name="nomor_ktp" class="form-control"
                                   value="{{ old('nomor_ktp', $toko->detailToko->nomor_ktp ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor KK</label>
                            <input type="text" name="nomor_kk" class="form-control"
                                   value="{{ old('nomor_kk', $toko->detailToko->nomor_kk ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto KTP</label>
                            <input type="file" name="foto_ktp" class="form-control" accept="image/*" required>
                            @if (!empty($toko->detailToko->foto_ktp))
                                <img src="{{ asset('storage/' . $toko->detailToko->foto_ktp) }}" width="200" class="mt-2">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto KK</label>
                            <input type="file" name="foto_kk" class="form-control" accept="image/*" required>
                            @if (!empty($toko->detailToko->foto_kk))
                                <img src="{{ asset('storage/' . $toko->detailToko->foto_kk) }}" width="200" class="mt-2">
                            @endif
                        </div>
                    @endif

                    {{-- STEP 3 --}}
                    @if ($step == 3)
                        <h4 class="mb-4 fw-semibold">Informasi Rekening</h4>

                        <div class="mb-3">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" name="nama_bank" class="form-control"
                                   value="{{ old('nama_bank', $toko->detailToko->nama_bank ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" class="form-control"
                                   value="{{ old('nomor_rekening', $toko->detailToko->nomor_rekening ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Pemilik Rekening</label>
                            <input type="text" name="nama_pemilik_rekening" class="form-control"
                                   value="{{ old('nama_pemilik_rekening', $toko->detailToko->nama_pemilik_rekening ?? '') }}">
                        </div>
                    @endif

                    {{-- STEP 4 --}}
                    @if ($step == 4)
                        <h4 class="mb-4 fw-semibold">Kontak & Sosial Media</h4>

                        <div class="mb-3">
                            <label class="form-label">Email CS</label>
                            <input type="email" name="email_cs" class="form-control"
                                   value="{{ old('email_cs', $toko->detailToko->email_cs ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">WhatsApp CS</label>
                            <input type="text" name="whatsapp_cs" class="form-control"
                                   value="{{ old('whatsapp_cs', $toko->detailToko->whatsapp_cs ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Instagram</label>
                            <input type="text" name="link_instagram" class="form-control"
                                   value="{{ old('link_instagram', $toko->detailToko->link_instagram ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Facebook</label>
                            <input type="text" name="link_facebook" class="form-control"
                                   value="{{ old('link_facebook', $toko->detailToko->link_facebook ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">TikTok</label>
                            <input type="text" name="link_tiktok" class="form-control"
                                   value="{{ old('link_tiktok', $toko->detailToko->link_tiktok ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Website / Google Maps</label>
                            <input type="text" name="link_website" class="form-control"
                                   value="{{ old('link_website', $toko->detailToko->link_google_maps ?? '') }}">
                        </div>
                    @endif

                    {{-- STEP 5 --}}
                    @if ($step == 5)
                        <h4 class="mb-4 fw-semibold">Jadwal Operasional</h4>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label">{{ $hari }}</label>
                                <div class="col-sm-4">
                                    <input type="time" name="jadwal[{{ $hari }}][buka]" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <input type="time" name="jadwal[{{ $hari }}][tutup]" class="form-control">
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- Navigation -->
                    <div class="d-flex justify-content-between mt-4">
                        @if ($step > 1)
                            <a href="{{ route('verifikasitoko', ['step' => $step - 1]) }}" class="btn btn-outline-secondary">Kembali</a>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            {{ $step < 5 ? 'Lanjut' : 'Selesai & Simpan' }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

</body>


</html>
