<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Verifikasi Toko - Step {{ $step }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .stepper .stepper-item {
            text-align: center;
            flex: 1;
        }

        .stepper .stepper-icon {
            margin: auto;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            line-height: 40px;
        }

        .stepper .stepper-item.current .stepper-icon,
        .stepper .stepper-item.completed .stepper-icon {
            background-color: #0d6efd;
            color: #fff;
        }

        .stepper .stepper-title {
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <section class="py-5">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    @php
                        $steps = ['Informasi Toko', 'Dokumen', 'Rekening', 'Kontak Sosial', 'Jadwal'];
                    @endphp

                    <!-- Stepper -->
                    <div class="d-flex stepper stepper-pills mb-5">
                        @foreach ($steps as $index => $label)
                            <div
                                class="stepper-item {{ $step == $index + 1 ? 'current' : ($step > $index + 1 ? 'completed' : '') }}">
                                <div class="stepper-icon">
                                    <span class="stepper-number">{{ $index + 1 }}</span>
                                </div>
                                <div class="stepper-title">{{ $label }}</div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Form -->
                    <form action="{{ route('verifikasitokostore', ['step' => $step]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- STEP 1 --}}
                        @if ($step == 1)
                            <h4>Informasi Toko</h4>
                            <div class="mb-3">
                                <label class="form-label">Nama Toko</label>
                                <input type="text" name="nama_toko" class="form-control"
                                    value="{{ old('nama_toko', session('toko_step1.nama_toko')) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori Toko</label>
                                <select name="kategori_toko_id" id="kategori_toko_id" class="form-select" required>
                                    <option selected disabled hidden>-- Pilih Kategori --</option>
                                    @foreach ($kategori_tokos as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ old('kategori_toko_id', session('toko_step1.kategori_toko_id')) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori_toko }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="kategori_toko" hidden>
                                <label class="form-label">Input Kategori Toko</label>
                                <input type="text" name="kategori_toko" class="form-control"
                                    value="{{ old('kategori_toko', session('toko_step1.kategori_toko')) }}" required>
                            </div>

                            <!-- JQUERY -->
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <!-- SCRIPT -->
                            <script>
                                $(document).ready(function () {
                                    function toggleKategoriInput() {
                                        const selectedValue = parseInt($('#kategori_toko_id').val());
                                        if (selectedValue === 20) {
                                            $('#kategori_toko').prop('hidden', false);
                                        } else {
                                            $('#kategori_toko').prop('hidden', true);
                                        }
                                    }

                                    // Jalankan saat halaman dimuat (untuk restore dari session atau validasi)
                                    toggleKategoriInput();

                                    // Jalankan saat dropdown berubah
                                    $('#kategori_toko_id').on('change', toggleKategoriInput);
                                });
                            </script>


                            <div class="mb-3">
                                <label class="form-label">No. HP Toko</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="number" name="no_hp_toko" class="form-control" maxlength="15"
                                        value="{{ old('no_hp_toko', session('toko_step1.no_hp_toko') ? ltrim(session('toko_step1.no_hp_toko'), '+62') : '') }}"
                                        pattern="[0-9]{6,13}" title="Masukkan angka setelah +62 (6-13 digit)" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat_toko" class="form-control" rows="3" required>{{ old('alamat_toko', session('toko_step1.alamat_toko')) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Logo Toko</label>
                                <input type="file" name="logo_toko" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi_toko" class="form-control" rows="3">{{ old('deskripsi_toko', session('toko_step1.deskripsi_toko')) }}</textarea>
                            </div>
                        @endif

                        {{-- STEP 2 --}}
                        @if ($step == 2)
                            <h4>Dokumen Identitas</h4>
                            <div class="mb-3">
                                <label class="form-label">Foto KTP</label>
                                <input type="file" name="foto_ktp" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor KTP</label>
                                <input type="text" name="nomor_ktp" class="form-control"
                                    value="{{ old('nomor_ktp', session('toko_step2.nomor_ktp')) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Sesuai KTP</label>
                                <input type="text" name="nama_ktp" class="form-control"
                                    value="{{ old('nama_ktp', session('toko_step2.nama_ktp')) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor KK</label>
                                <input type="text" name="nomor_kk" class="form-control"
                                    value="{{ old('nomor_kk', session('toko_step2.nomor_kk')) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto KK</label>
                                <input type="file" name="foto_kk" class="form-control" required>
                            </div>
                        @endif

                        {{-- STEP 3 --}}
                        @if ($step == 3)
                            <h4>Informasi Rekening</h4>
                            <div class="mb-3">
                                <label class="form-label">Nama Bank</label>
                                <input type="text" name="nama_bank" class="form-control"
                                    value="{{ old('nama_bank', session('toko_step3.nama_bank')) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Rekening</label>
                                <input type="text" name="nomor_rekening" class="form-control"
                                    value="{{ old('nomor_rekening', session('toko_step3.nomor_rekening')) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pemilik Rekening</label>
                                <input type="text" name="nama_pemilik_rekening" class="form-control"
                                    value="{{ old('nama_pemilik_rekening', session('toko_step3.nama_pemilik_rekening')) }}">
                            </div>
                        @endif

                        {{-- STEP 4 --}}
                        @if ($step == 4)
                            <h4>Kontak & Sosial Media</h4>
                            <div class="mb-3">
                                <label class="form-label">Email CS</label>
                                <input type="email" name="email_cs" class="form-control"
                                    value="{{ old('email_cs', session('toko_step4.email_cs')) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">WhatsApp CS</label>
                                <input type="text" name="whatsapp_cs" class="form-control"
                                    value="{{ old('whatsapp_cs', session('toko_step4.whatsapp_cs')) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Instagram</label>
                                <input type="text" name="link_instagram" class="form-control"
                                    value="{{ old('link_instagram', session('toko_step4.link_instagram')) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="text" name="link_facebook" class="form-control"
                                    value="{{ old('link_facebook', session('toko_step4.link_facebook')) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TikTok</label>
                                <input type="text" name="link_tiktok" class="form-control"
                                    value="{{ old('link_tiktok', session('toko_step4.link_tiktok')) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Website / Google Maps</label>
                                <input type="text" name="link_website" class="form-control"
                                    value="{{ old('link_website', session('toko_step4.link_website')) }}">
                            </div>
                        @endif

                        {{-- STEP 5 --}}
                        @if ($step == 5)
                            <h4>Jadwal Operasional</h4>
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">{{ $hari }}</label>
                                    <div class="col-sm-5">
                                        <input type="time" name="jadwal[{{ $hari }}][buka]"
                                            class="form-control">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="time" name="jadwal[{{ $hari }}][tutup]"
                                            class="form-control">
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="mt-4 d-flex justify-content-between">
                            @if ($step > 1)
                                <a href="{{ route('verifikasitoko', ['step' => $step - 1]) }}"
                                    class="btn btn-secondary">Kembali</a>
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
