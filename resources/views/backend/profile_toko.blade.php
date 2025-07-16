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

                {{-- Informasi Umum --}}
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

                {{-- Dokumen Kepemilikan --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="mb-0"><i class="bi bi-card-list"></i> Dokumen Kepemilikan</h4>
                </div>
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
                        <img src="{{ asset('storage/' . $tokoshow->foto_ktp) }}" alt="Foto KTP" class="img-thumbnail" width="200">
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Foto KK:</label><br>
                        <img src="{{ asset('storage/' . $tokoshow->foto_kk) }}" alt="Foto KK" class="img-thumbnail" width="200">
                    </div>
                </div>

                <hr>

                {{-- Informasi Rekening --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="mb-0"><i class="bi bi-bank"></i> Informasi Rekening</h4>
                </div>
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

                {{-- Kontak & Media Sosial --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="mb-0"><i class="bi bi-telephone"></i> Kontak & Media Sosial</h4>
                </div>
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
                        <p>
                            @if ($tokoshow->link_google_maps)
                                <a href="{{ $tokoshow->link_google_maps }}" target="_blank">
                                    {{ $tokoshow->link_google_maps }}
                                </a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                <hr>

               {{-- Jam Operasional --}}
<div class="d-flex justify-content-between align-items-center mb-2">
    <h4 class="mb-0"><i class="bi bi-clock-history"></i> Jam Operasional</h4>
    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalJamOperasional">
        <i class="bi bi-pencil-square"></i> Ubah
    </a>
</div>

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
<!-- Modal -->
<div class="modal fade" id="modalJamOperasional" tabindex="-1" aria-labelledby="modalJamOperasionalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="#" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="modalJamOperasionalLabel">Edit Jadwal Operasional</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <h4 class="mb-4 fw-semibold">Jadwal Operasional</h4>
            @php
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                $jadwalMap = collect($jadwalOperasional ?? [])->keyBy('hari');
            @endphp

            @foreach ($days as $hari)
                @php
                    $dataHari = $jadwalMap[$hari] ?? null;
                @endphp
                <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label">{{ $hari }}</label>
                    <div class="col-sm-4">
                        <input type="time" name="jadwal[{{ $hari }}][jam_buka]" class="form-control"
                               value="{{ $dataHari ? $dataHari->jam_buka : '' }}">
                    </div>
                    <div class="col-sm-4">
                        <input type="time" name="jadwal[{{ $hari }}][jam_tutup]" class="form-control"
                               value="{{ $dataHari ? $dataHari->jam_tutup : '' }}">
                    </div>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jadwal[{{ $hari }}][buka]"
                                   {{ $dataHari && $dataHari->buka ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
