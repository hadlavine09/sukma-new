@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-shop"></i> Detail Toko</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Manajemen Toko</li>
            <li class="breadcrumb-item active"><a href="#">Detail</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile p-4">
                {{-- Logo Toko --}}
                @if($tokoshow->logo_toko)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $tokoshow->logo_toko) }}"
                         alt="Logo Toko"
                         class="img-fluid rounded shadow-sm border"
                         style="max-height: 150px; object-fit: contain;">
                </div>
                @endif

                <h4 class="mb-4"><i class="bi bi-shop-window"></i> Informasi Umum Toko</h4>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="fw-bold">Kode Toko:</label>
                        <p>{{ $tokoshow->kode_toko }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold">Nama Toko:</label>
                        <p>{{ $tokoshow->nama_toko }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold">Kategori:</label>
                        <p>{{ $tokoshow->nama_kategori_toko }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold">Pemilik:</label>
                        <p>{{ $tokoshow->nama_pemilik }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="fw-bold">No HP:</label>
                        <p>{{ $tokoshow->no_hp_toko }}</p>
                    </div>
                    <div class="col-md-5">
                        <label class="fw-bold">Alamat:</label>
                        <p>{{ $tokoshow->alamat_toko }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Deskripsi:</label>
                        <p>{{ $tokoshow->deskripsi_toko }}</p>
                    </div>
                </div>

                <hr>
                <h4 class="mb-4"><i class="bi bi-card-list"></i> Dokumen Kepemilikan</h4>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="fw-bold">Nama di KTP:</label>
                        <p>{{ $tokoshow->nama_ktp }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Nomor KTP:</label>
                        <p>{{ $tokoshow->nomor_ktp }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Nomor KK:</label>
                        <p>{{ $tokoshow->nomor_kk }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold">Foto KTP:</label><br>
                        <img src="{{ asset('storage/' . $tokoshow->foto_ktp) }}"
                             alt="Foto KTP"
                             class="img-thumbnail"
                             width="200">
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Foto KK:</label><br>
                        <img src="{{ asset('storage/' . $tokoshow->foto_kk) }}"
                             alt="Foto KK"
                             class="img-thumbnail"
                             width="200">
                    </div>
                </div>

                <hr>
                <h4 class="mb-4"><i class="bi bi-bank"></i> Informasi Rekening</h4>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="fw-bold">Nama Bank:</label>
                        <p>{{ $tokoshow->nama_bank ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Nomor Rekening:</label>
                        <p>{{ $tokoshow->nomor_rekening ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Pemilik Rekening:</label>
                        <p>{{ $tokoshow->nama_pemilik_rekening ?? '-' }}</p>
                    </div>
                </div>

                <hr>
                <h4 class="mb-4"><i class="bi bi-telephone"></i> Kontak & Media Sosial</h4>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="fw-bold">Email CS:</label>
                        <p>{{ $tokoshow->email_cs ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">WhatsApp:</label>
                        <p>{{ $tokoshow->whatsapp_cs ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Instagram:</label>
                        <p>{{ $tokoshow->link_instagram ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Facebook:</label>
                        <p>{{ $tokoshow->link_facebook ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">TikTok:</label>
                        <p>{{ $tokoshow->link_tiktok ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Link Google Maps:</label>
                        <p><a href="{{ $tokoshow->link_google_maps }}" target="_blank">{{ $tokoshow->link_google_maps }}</a></p>
                    </div>
                </div>

                <hr>
                <h4 class="mb-4"><i class="bi bi-clock-history"></i> Jam Operasional</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Status</th>
                            <th>Jam Buka</th>
                            <th>Jam Tutup</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwalOperasional as $jadwal)
                            <tr>
                                <td>{{ $jadwal->hari }}</td>
                                <td>
                                    @if ($jadwal->buka)
                                        <span class="badge bg-success">Buka</span>
                                    @else
                                        <span class="badge bg-danger">Tutup</span>
                                    @endif
                                </td>
                                <td>{{ $jadwal->jam_buka ?? '-' }}</td>
                                <td>{{ $jadwal->jam_tutup ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <a href="{{ route('izin_toko.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection
