<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Verifikasi Toko - Step {{ $step }}</title>
    <link rel="stylesheet" href="{{ asset('assets_frontend/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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
                            xlink:href="data:img/png;base64,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" />
                    </svg>
                </a>
            </div>
            <div class="navbar-right d-flex align-items-center" style="gap: 1rem;">
                <!-- Cart Dropdown -->
                <div class="nav-cart-dropdown-wrapper position-relative" style="display:inline-block;">
                    <div id="cartDropdownCard"
                        class="cart-dropdown-card card shadow border-0 position-absolute end-0 mt-2"
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
                            <a href="{{ route('frontend.keranjang') }}" class="btn btn-danger w-100"
                                id="lihatKeranjangBtn" style="border-radius:6px;">
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
                    <form action="{{ route('verifikasitokostore', ['step' => $step]) }}" method="POST"
                        enctype="multipart/form-data">
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
                                $(document).ready(function() {
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
                                        required
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')">
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
                                    <img src="{{ asset('storage/' . $toko->logo_toko) }}" width="200"
                                        class="mt-2">
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi_toko" class="form-control" rows="3">{{ old('deskripsi_toko', $toko->deskripsi_toko ?? '') }}</textarea>
                            </div>
                        @endif

                        {{-- STEP 2 --}}
                        {{-- STEP 2 --}}
                        @if ($step == 2)
                            <h4 class="mb-4 fw-semibold">Dokumen Identitas</h4>

                            <div class="mb-3">
                                <label class="form-label">Foto KTP</label>
                                <input type="file" name="foto_ktp" class="form-control" accept="image/*">
                                @if (!empty(optional($toko->detailToko)->foto_ktp))
                                    <img src="{{ asset('storage/' . $toko->detailToko->foto_ktp) }}" width="200"
                                        class="mt-2">
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto KK</label>
                                <input type="file" name="foto_kk" class="form-control" accept="image/*">
                                @if (!empty(optional($toko->detailToko)->foto_kk))
                                    <img src="{{ asset('storage/' . $toko->detailToko->foto_kk) }}" width="200"
                                        class="mt-2">
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama KTP</label>
                                <input type="text" name="nama_ktp" class="form-control"
                                    value="{{ old('nama_ktp', optional($toko->detailToko)->nama_ktp) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor KTP</label>
                                <input type="text" name="nomor_ktp" class="form-control"
                                    value="{{ old('nomor_ktp', optional($toko->detailToko)->nomor_ktp) }}" required
                                    pattern="^[1-9][0-9]*$"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '')">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor KK</label>
                                <input type="text" name="nomor_kk" class="form-control"
                                    value="{{ old('nomor_kk', optional($toko->detailToko)->nomor_kk) }}" required
                                    pattern="^[1-9][0-9]*$"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '')">
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
                                    value="{{ old('nomor_rekening', $toko->detailToko->nomor_rekening ?? '') }}"
                                    required pattern="^[1-9][0-9]*$"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '')">
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
                            @php
                                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                $jadwalMap = collect($jam_operasional ?? [])->keyBy('hari');
                            @endphp

                            @foreach ($days as $hari)
                                @php
                                    $dataHari = $jadwalMap[$hari] ?? null;
                                @endphp
                                <div class="row mb-3 align-items-center">
                                    <label class="col-sm-3 col-form-label">{{ $hari }}</label>
                                    <div class="col-sm-4">
                                        <input type="time" name="jadwal[{{ $hari }}][buka]"
                                            class="form-control" value="{{ $dataHari ? $dataHari->jam_buka : '' }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="time" name="jadwal[{{ $hari }}][tutup]"
                                            class="form-control" value="{{ $dataHari ? $dataHari->jam_tutup : '' }}">
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Navigation -->
                        <div class="d-flex justify-content-between mt-4">
                            @if ($step > 1)
                                <a href="{{ route('verifikasitoko', ['step' => $step - 1]) }}"
                                    class="btn btn-outline-secondary">Kembali</a>
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
