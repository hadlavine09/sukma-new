<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Penjual - SukMa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet" />
    <link href="{{ asset('assets_frontend/umkm_register/plugins/custom/datatables/datatables.bundle.css') }}"
        rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('assets_frontend/umkm_register/plugins/global/plugins.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets_frontend/umkm_register/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_frontend/css/style.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .text-green {
            color: #2d5727 !important;
        }

        .btn-green {
            background-color: #2d5727;
            border-color: #2d5727;
            color: #fff;
        }

        .btn-green:hover {
            background-color: #244a21;
            border-color: #244a21;
        }
    </style>
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        svg,
        video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-white {
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255, 255, 255, var(--bg-opacity))
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .border-gray-200 {
            --border-opacity: 1;
            border-color: #edf2f7;
            border-color: rgba(237, 242, 247, var(--border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
        }

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --text-opacity: 1;
            color: #edf2f7;
            color: rgba(237, 242, 247, var(--text-opacity))
        }

        .text-gray-300 {
            --text-opacity: 1;
            color: #e2e8f0;
            color: rgba(226, 232, 240, var(--text-opacity))
        }

        .text-gray-400 {
            --text-opacity: 1;
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--text-opacity))
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity))
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity))
        }

        .text-gray-900 {
            --text-opacity: 1;
            color: #1a202c;
            color: rgba(26, 32, 44, var(--text-opacity))
        }

        .underline {
            text-decoration: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        @media (min-width:640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width:768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width:1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme:dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgba(45, 55, 72, var(--bg-opacity))
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
                border-color: rgba(74, 85, 104, var(--border-opacity))
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
                color: rgba(255, 255, 255, var(--text-opacity))
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
                color: rgba(203, 213, 224, var(--text-opacity))
            }

            .dark\:text-gray-500 {
                --tw-text-opacity: 1;
                color: #6b7280;
                color: rgba(107, 114, 128, var(--tw-text-opacity))
            }
        }
    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            height: 100%;
        }

        footer {
            ;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="shopee-navbar" role="navigation" aria-label="Main navigation">
        <div class="container">
            <div class="navbar-left">
                <a href="{{ url('Home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="120"
                        height="108" viewBox="0 0 200 108">
                        <image id="logosukma" x="58" y="15" width="127" height="79"
                            xlink:href="data:img/png;base64,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" />
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <section class="py-5">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container " class="app-container container-xl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Stepper-->
                        <div class="stepper stepper-links d-flex flex-column pt-15" id="kt_create_account_stepper"
                            data-kt-stepper="true">
                            <!--begin::Nav-->
                            <div class="stepper-nav mb-5">
                                <!--begin::Step 1-->
                                <div class="stepper-item rounded-circle current" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Tahap Pertama</h3>
                                </div>
                                <!--end::Step 1-->
                                <!--begin::Step 2-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Tahap Kedua</h3>
                                </div>
                                <!--end::Step 2-->
                                <!--begin::Step 3-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Tahap Ketiga</h3>
                                </div>
                                <!--end::Step 3-->
                                <!--begin::Step 4-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Tahap Keempat</h3>
                                </div>
                                <!--end::Step 4-->
                                <!--begin::Step 5-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Selesai</h3>
                                </div>
                                <!--end::Step 5-->
                            </div>
                            <!--end::Nav-->
                            <!--begin::Form-->
                            <form class="mx-auto mw-800px w-300 pt-15 pb-10 fv-plugins-bootstrap5 fv-plugins-framework"
                                novalidate="novalidate" id="kt_create_account_form">
                                <!--begin::Step 1-->

                                <div class="current" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-15 text-center">
                                            <h1>Konfirmasi Toko</h1>
                                            <hr style="color: green ">
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="row mb-3">
                                                        <label for="nama_toko"
                                                            class="col-sm-4 col-form-label form-label">Nama Toko :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="nama_toko"
                                                                placeholder="Masukan Nama Toko" id="nama_toko"
                                                                maxlength="100" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="no_hp_toko"
                                                            class="col-sm-4 col-form-label form-label">No. Hp</label>
                                                        <div class="col-sm-8">
                                                            <div class="input-group">
                                                                <span class="input-group-text"><img
                                                                        class="h-20px w-20px rounded-sm"
                                                                        src="{{ asset('assets_frontend/umkm_register/img/indo.png') }}"
                                                                        alt="">+62</span>
                                                                <input class="form-control" type="text" name="no_hp"
                                                                    placeholder="Masukan kontak yang aktif" id="no_hp"
                                                                    required="" value="" maxlength="13"
                                                                    onkeypress="return hanyaAngka(event)">
                                                            </div>
                                                        </div>
                                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="kategori_toko"
                                                            class="col-sm-4 col-form-label form-label">Kategori Toko
                                                            :</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control custom-select"
                                                                name="kategori_toko" id="kategori_toko" required>
                                                                <option value="">-- Pilih Kategori Toko --</option>
                                                                <option value="Makanan & Minuman">Makanan & Minuman
                                                                </option>
                                                                <option value="Fashion">Fashion</option>
                                                                <option value="Kerajinan">Kerajinan</option>
                                                                <option value="Jasa">Jasa</option>
                                                                <option value="Lainnya">Lainnya</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="alamat_toko"
                                                            class="col-sm-4 col-form-label form-label">Alamat Toko
                                                            :</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="alamat_toko" id="alamat_toko" rows="3" placeholder="Masukan Alamat Toko"
                                                                required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="logo_toko"
                                                            class="col-sm-4 col-form-label form-label">Logo Toko :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="file" name="logo_toko"
                                                                id="logo_toko" accept="image/*" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="deskripsi_toko"
                                                            class="col-sm-4 col-form-label form-label">Deskripsi Toko
                                                            :</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="deskripsi_toko" id="deskripsi_toko" rows="3"
                                                                placeholder="Masukan Deskripsi Toko" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>

                                <!--end::Step 1-->
                                <!--begin::Step 2-->
                                <div data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="form" id="form-dokumen">
                                        <div class="pb-10 pb-lg-15 text-center">
                                            <h1>Dokumen Kepemilikan</h1>
                                            <hr style="color: green ">
                                        </div>
                                        <div class="fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <!-- Upload Foto KTP paling atas -->
                                                    <div class="row mb-3">
                                                        <label for="foto_ktp" class="col-sm-4 col-form-label form-label">Foto KTP</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" class="form-control mb-2" id="foto_ktp" name="foto_ktp" accept="image/*" required>
                                                            <div id="preview_ktp" style="max-width:220px;">
                                                                <img id="img_preview_ktp" src="" alt="Preview KTP" style="display:none;max-width:200px;max-height:200px;border:1px solid #eee;border-radius:6px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Hasil OCR: NIK dan Nama -->
                                                    <div class="row mb-3">
                                                        <label for="nomor_ktp" class="col-sm-4 col-form-label form-label">NIK</label>
                                                        <div class="col-sm-8 d-flex align-items-center">
                                                            <span style="font-weight:bold; margin-right:8px;">:</span>
                                                            <input type="text" class="form-control" id="nomor_ktp" name="nomor_ktp" placeholder="16 digit Nomor KTP" maxlength="16" required onkeypress="return hanyaAngka(event)" style="font-weight:bold;">
                                                            <small id="ocr_nik_hint" class="text-success ms-2" style="display:none;">NIK berhasil diambil dari foto KTP</small>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="nama_ktp" class="col-sm-4 col-form-label form-label">Nama</label>
                                                        <div class="col-sm-8 d-flex align-items-center">
                                                            <span style="font-weight:bold; margin-right:8px;">:</span>
                                                            <input type="text" class="form-control" id="nama_ktp" name="nama_ktp" placeholder="Nama sesuai KTP" maxlength="100" required style="font-weight:bold;">
                                                            <small id="ocr_nama_hint" class="text-success ms-2" style="display:none;">Nama berhasil diambil dari foto KTP</small>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="nomor_kk" class="col-sm-4 col-form-label form-label">Nomor KK</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="nomor_kk" name="nomor_kk" placeholder="16 digit Nomor KK" maxlength="16" required onkeypress="return hanyaAngka(event)">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="foto_kk" class="col-sm-4 col-form-label form-label">Foto KK</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" class="form-control" id="foto_kk" name="foto_kk" accept="image/*" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <!--end::Wrapper-->
                                        </div>
                                        <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
                                        <script>
                                            // Preview Foto KTP & OCR
                                            document.getElementById('foto_ktp').addEventListener('change', function(e) {
                                                const file = e.target.files[0];
                                                const img = document.getElementById('img_preview_ktp');
                                                const namaInput = document.getElementById('nama_ktp');
                                                const nikInput = document.getElementById('nomor_ktp');
                                                const namaHint = document.getElementById('ocr_nama_hint');
                                                const nikHint = document.getElementById('ocr_nik_hint');
                                                // Reset
                                                namaHint.style.display = 'none';
                                                nikHint.style.display = 'none';

                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = function(ev) {
                                                        img.src = ev.target.result;
                                                        img.style.display = 'block';
                                                    };
                                                    reader.readAsDataURL(file);
                                                } else {
                                                    img.src = '';
                                                    img.style.display = 'none';
                                                }

                                                // OCR KTP
                                                if (!file) return;
                                                Tesseract.recognize(
                                                    file,
                                                    'ind', // gunakan 'ind' untuk Bahasa Indonesia, fallback ke 'eng' jika tidak tersedia
                                                    { logger: m => console.log(m) }
                                                ).then(({ data: { text } }) => {
                                                    // Regex sederhana untuk cari NIK (16 digit) dan Nama (huruf besar, baris kedua biasanya)
                                                    let nikMatch = text.match(/\b\d{16}\b/);
                                                    let namaMatch = null;
                                                    // Cari baris yang kemungkinan besar adalah nama (huruf besar semua, tanpa angka)
                                                    const lines = text.split('\n').map(l => l.trim()).filter(l => l.length > 0);
                                                    for (let i = 0; i < lines.length; i++) {
                                                        // Cek baris yang mengandung "NIK" lalu ambil NIK di sebelahnya
                                                        if (/NIK/i.test(lines[i])) {
                                                            const nikLine = lines[i].replace(/[^0-9]/g, '');
                                                            if (nikLine.length === 16) {
                                                                nikMatch = [nikLine];
                                                            }
                                                        }
                                                        // Cek baris yang mengandung "Nama" lalu ambil nama di sebelahnya
                                                        if (/Nama/i.test(lines[i])) {
                                                            const namaLine = lines[i].replace(/Nama\s*:?/i, '').trim();
                                                            if (namaLine.length > 2 && /^[A-Z\s]+$/.test(namaLine)) {
                                                                namaMatch = namaLine;
                                                            } else if (lines[i+1] && /^[A-Z\s]+$/.test(lines[i+1])) {
                                                                namaMatch = lines[i+1];
                                                            }
                                                        }
                                                    }
                                                    // Fallback: cari baris huruf besar tanpa angka
                                                    if (!namaMatch) {
                                                        for (let line of lines) {
                                                            if (/^[A-Z\s]+$/.test(line) && !/\d/.test(line) && line.length > 3 && line.length < 50) {
                                                                namaMatch = line;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    if (nikMatch) {
                                                        nikInput.value = nikMatch[0];
                                                        nikHint.style.display = 'inline';
                                                    }
                                                    if (namaMatch) {
                                                        namaInput.value = namaMatch;
                                                        namaHint.style.display = 'inline';
                                                    }
                                                }).catch(err => {
                                                    console.error('OCR gagal:', err);
                                                });
                                            });
                                        </script>
                                <!--end::Step 2-->
                                <!--begin::Step 3-->
                                <div data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="form" id="form-waktu">
                                        <div class="pb-10 pb-lg-15 text-center">
                                            <h1>Jadwal Layanan</h1>
                                            <hr style="color: green ">
                                        </div>
                                        <div class="container p-xxl-6 ">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="row mb-3">
                                                        <label for="tujuan"
                                                            class="col-sm-4 col-form-label form-label ">Kantor
                                                            Tujuan</label>
                                                        <div class="col-sm-8">
                                                            <select id='tujuan' class="form-control custom-select"
                                                                name='tujuan'>
                                                                <option value=''>-- Masukan Kantor Tujuan --</option>

                                                                <!-- Read Departments -->
                                                                {{-- @foreach ($kantor as $data)
                                                                    <option value='{{ $data->nama_kota }}'>
                                                                        {{ $data->nama_kota }}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label form-label">Tanggal
                                                            Kunjungan:</label>
                                                        <div class="col-sm-8">
                                                            <input
                                                                class="form-control p flatpickr-input valid datetimepicker"
                                                                type="date" name="tanggal" id="tanggal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label form-label">Waktu
                                                            Pelayanan:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control custom-select" name="waktu"
                                                                id="waktu">
                                                                <option value="">Masukan waktu anda</option>
                                                                <option value="08:00 - 10:00">08:00 - 10:00</option>
                                                                <option value="10:00 - 12:00">10:00 - 12:00</option>
                                                                <option value="13:00 - 15:00">13:00 - 15:00</option>
                                                                <option value="15:00 - 17:00">15:00 - 17:00</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label form-label">Layanan:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control custom-select" name="layanan"
                                                                id="layanan">
                                                                <option value="">Silahkan masukan tujuan anda
                                                                </option>
                                                                {{-- @foreach ($layanan as $layan)
                                                                    <option value='{{ $layan->layanan }}'>
                                                                        {{ $layan->layanan }}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 3-->
                                <!--begin::Step 4-->
                                <div data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="form active" id="form-confirm">
                                        <h1 class="title form-title text-center">
                                            Informasi Antrean
                                        </h1>
                                        <hr style="color: green">
                                        <div class="container py-5 px-md-5 ">
                                            <fieldset>
                                                <div class="row mb-3">
                                                    <label for="conf-kanotr-tujuan"
                                                        class="col-sm-4 col-form-label form-label">Kantor tujuan</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="tujuan"
                                                            value="" id="conf-kantor-tujuan" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="conf-kanotr-tujuan"
                                                        class="col-sm-4 col-form-label form-label">Alamat Kantor</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" name="alamat" value="" id="conf-alamat-kantor" disabled cols="10"
                                                            rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="conf-alamat"
                                                        class="col-sm-4 col-form-label form-label">Jenis Layanan</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="conf-layanan"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="conf-tanggal"
                                                        class="col-sm-4 col-form-label form-label">Tanggal
                                                        Kunjungan</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text"
                                                            id="conf-tanggal-kunjungan" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="conf-sesi-pelayanan"
                                                        class="col-sm-4 col-form-label form-label">Sesi Kunjungan</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text"
                                                            id="conf-sesi-pelayanan" disabled>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="row mb-3">
                                                <div class="h-captcha"
                                                    data-sitekey="75992a63-43e1-4304-9c19-f90961c7f26b"><iframe
                                                        src="https://newassets.hcaptcha.com/captcha/v1/1f7dc62/static/hcaptcha.html#frame=checkbox&amp;id=0eye8fgutumg&amp;host=antrean-bappenda.bogorkab.go.id&amp;sentry=true&amp;reportapi=https%3A%2F%2Faccounts.hcaptcha.com&amp;recaptchacompat=true&amp;custom=false&amp;hl=id&amp;tplinks=on&amp;sitekey=75992a63-43e1-4304-9c19-f90961c7f26b&amp;theme=light"
                                                        title="widget containing checkbox for hCaptcha security challenge"
                                                        tabindex="0" frameborder="0" scrolling="no"
                                                        data-hcaptcha-widget-id="0eye8fgutumg" data-hcaptcha-response=""
                                                        style="width: 303px; height: 78px; overflow: hidden;"></iframe>
                                                    <textarea id="g-recaptcha-response-0eye8fgutumg" name="g-recaptcha-response" style="display: none;"></textarea>
                                                    <textarea id="h-captcha-response-0eye8fgutumg" name="h-captcha-response" style="display: none;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 4-->
                                <!--begin::Step 5-->
                                <div data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="form active">
                                        <h1 class="title form-title">
                                            Tiket Antrean
                                        </h1>
                                        <hr class="mb-3">
                                        <p class="p-2 col-lg-9 text-center mx-auto mb-5">
                                            Silahkan screenshoot/cetak/foto tiket Anda.<br>
                                            Harap datang 15 menit sebelum waktu kunjungan Anda
                                        </p>

                                        <div class="container bg-white shadow col-lg-10 row mx-auto tiket p-3">
                                            <div class="container col-md-8 d-flex flex-column justify-content-around row">
                                                {{-- @php $no= 1; @endphp --}}
                                                {{-- @foreach ($daftar as $data) --}}
                                                <div class="container text-center text-md-left">
                                                    No. Tiket :
                                                    <b>
                                                        <h4><input style="text-align:center" type="text"
                                                                id="no_tiket" disabled></h4>
                                                    </b>
                                                </div>
                                                {{-- @endforeach --}}
                                                <div class="container text-center text-md-left">
                                                    Nama: <br>
                                                    <b>
                                                        <h4><input style="text-align:center" type="text"
                                                                id="nama_tiket" disabled></h4>
                                                    </b>
                                                </div>
                                            </div>
                                            <div class="container col-12 col-md-4 p-3">
                                                <div id="qr" class="p-2"><img crossorigin="anonymous"
                                                        src="data:image/png;base64,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"
                                                        width="200" height="200"
                                                        style="width: 200px; height: 200px;"></div>
                                            </div>
                                        </div>
                                        <div class="container p-3">
                                            <fieldset>
                                                <div class="row mb-3">
                                                    <label for="input-kantor"
                                                        class="col-sm-4 col-form-label form-label ">Kantor Tujuan</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" id="tujuan_akhir"
                                                            value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="input-antrean"
                                                        class="col-sm-4 col-form-label form-label">No. Antrean</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" value=""
                                                            id="no_antrian" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="input-kantor"
                                                        class="col-sm-4 col-form-label form-label">Nama Kantor</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" id="kantor"
                                                            name="kantor" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="input-tiket"
                                                        class="col-sm-4 col-form-label form-label">NIK</label>
                                                    <div class="col-sm-8 row align-items-center m-auto">
                                                        <input class="form-control col" type="text" id="nik_akhir"
                                                            value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="input-tiket"
                                                        class="col-sm-4 col-form-label form-label">Layanan</label>
                                                    <div class="col-sm-8 row align-items-center m-auto">
                                                        <input class="form-control col" type="text" id="layanan_akhir"
                                                            value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <label for="input-tiket"
                                                        class="col-sm-4 col-form-label form-label">Tanggal & Waktu</label>
                                                    <input class="form-control" type="text" id="tanggal_akhir"
                                                        value="" disabled>
                                                    &nbsp;
                                                    <input class="form-control" type="text" id="waktu_akhir"
                                                        value="" disabled>

                                                </div>
                                            </fieldset>
                                            <small class="text-danger">
                                                <b>Catatan</b> : Pengubahan jenis layanan dan waktu pelayanan hanya dapat
                                                dilakukan maksimal H-1 sebelum pelayanan
                                                <br>
                                                <b>
                                                    <p>**Tiket ini tidak berlaku jika Anda datang terlambat</p>
                                                </b>
                                                <b>
                                                    <p>**Pengunjung wajib menunjukkan sertifikat vaksin covid-19</p>
                                                </b>

                                            </small>
                                            <div class="container mb-3 mx-auto d-flex justify-content-end mt-5"
                                                id="button-container">
                                                <a href="" class="btn btn-sm bg-success rounded-pill mr-3"
                                                    onclick="event.preventDefault(); printTiket()">Simpan Tiket</a>
                                                <a class="btn-print btn-sm bg-success rounded-pill mr-3"
                                                    onclick="window.print()">simpan PDF</a>
                                                <a class="btn btn-sm bg-success rounded-pill mr-3"
                                                    href="/">Selesai</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 5-->
                                <!--begin::Actions-->
                                <div class="d-flex flex-stack pt-15">
                                    <!--begin::Wrapper-->
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-lg btn-light-primary me-3"
                                            data-kt-stepper-action="previous">
                                            Kembali
                                        </button>
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Wrapper-->
                                    <div>
                                        <input type="hidden" name="_token" id="csrf"
                                            value="{{ Session::token() }}">
                                        <button type="button" class="btn btn-lg btn-primary me-3"
                                            data-kt-stepper-action="submit" id="butsave">
                                            <span class="indicator-label">Kirim
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                                <span class="svg-icon svg-icon-3 ms-2 me-0">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                                            rx="1" transform="rotate(-180 18 13)"
                                                            fill="currentColor"></rect>
                                                        <path
                                                            d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="indicator-progress">Mengirim...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <button type="button" class="btn btn-lg btn-success"
                                            data-kt-stepper-action="next" width="50">Lanjut
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->

                                            <!--end::Svg Icon-->
                                        </button>
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Actions-->
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Stepper-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="{{ asset('assets_frontend/umkm_register/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets_frontend/umkm_register/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_frontend/umkm_register/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets_frontend/umkm_register/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets_frontend/umkm_register/js/custom/utilities/modals/daftar.js') }}"></script>
    <script src="{{ asset('assets_frontend/umkm_register/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets_frontend/umkm_register/js/custom/widgets.js') }}"></script>

    <script src="{{ asset('assets_frontend/umkm_register/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets_frontend/umkm_register/js/custom/utilities/modals/create-app.js') }}"></script>
    {{-- <script src="assets/js/custom/utilities/modals/users-search.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
        integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous">
    </script>
</body>

</html>
