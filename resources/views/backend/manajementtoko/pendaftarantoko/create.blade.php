@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-building-add"></i> Pendaftaran Toko</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Daftar Toko</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    {{-- Alerts --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('izin_toko.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama, Logo, Kategori --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Nama Toko</label>
                                <input type="text" name="nama_toko" class="form-control" required value="{{ old('nama_toko') }}">
                            </div>
                            <div class="col-md-4">
                                <label>Kategori Toko</label>
                                <select name="kategori_toko_id" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoriTokos as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori_toko }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Logo Toko</label>
                                <input type="file" name="logo_toko" class="form-control" accept="image/*">
                            </div>
                        </div>

                        {{-- No HP, Alamat, Deskripsi --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>No HP Toko</label>
                                <input type="text" name="no_hp_toko" class="form-control" required value="{{ old('no_hp_toko') }}">
                            </div>
                            <div class="col-md-4">
                                <label>Alamat Toko</label>
                                <textarea name="alamat_toko" rows="1" class="form-control">{{ old('alamat_toko') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label>Deskripsi Toko</label>
                                <textarea name="deskripsi_toko" rows="1" class="form-control">{{ old('deskripsi_toko') }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5>Dokumen Kepemilikan</h5>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Nama di KTP</label>
                                <input type="text" name="nama_ktp" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Nomor KTP</label>
                                <input type="text" name="nomor_ktp" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Nomor KK</label>
                                <input type="text" name="nomor_kk" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Foto KTP</label>
                                <input type="file" name="foto_ktp" class="form-control" accept="image/*" required>
                            </div>
                            <div class="col-md-6">
                                <label>Foto KK</label>
                                <input type="file" name="foto_kk" class="form-control" accept="image/*" required>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5>Informasi Rekening</h5>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Nama Bank</label>
                                <input type="text" name="nama_bank" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Nomor Rekening</label>
                                <input type="text" name="nomor_rekening" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Nama Pemilik Rekening</label>
                                <input type="text" name="nama_pemilik_rekening" class="form-control">
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5>Kontak & Sosial Media</h5>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Email CS</label>
                                <input type="email" name="email_cs" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>WhatsApp CS</label>
                                <input type="text" name="whatsapp_cs" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Instagram</label>
                                <input type="text" name="link_instagram" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Facebook</label>
                                <input type="text" name="link_facebook" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>TikTok</label>
                                <input type="text" name="link_tiktok" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Link Google Maps</label>
                                <input type="text" name="link_google_maps" class="form-control">
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5>Jam Operasional Toko</h5>

                        @php
                            $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                        @endphp

                        @foreach($hariList as $hari)
                        <div class="row align-items-center mb-3">
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="jadwal[{{ $hari }}][buka]" id="buka_{{ $hari }}" value="1">
                                    <label class="form-check-label" for="buka_{{ $hari }}">
                                        {{ $hari }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Jam Buka</label>
                                <input type="time" name="jadwal[{{ $hari }}][jam_buka]" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Jam Tutup</label>
                                <input type="time" name="jadwal[{{ $hari }}][jam_tutup]" class="form-control">
                            </div>
                        </div>
                        @endforeach

                        <div class="mt-4">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Daftarkan Toko</button>
                            <a href="{{ route('toko.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
