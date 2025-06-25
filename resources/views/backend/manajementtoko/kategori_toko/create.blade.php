@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-plus-circle"></i> Tambah Kategori Toko</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Tambah Kategori Toko</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    {{-- Alert success --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Alert error --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Validation errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('kategori_toko.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama & Gambar dalam 1 baris --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_kategori_toko" class="form-label">Nama Kategori Toko</label>
                                <input type="text" class="form-control" name="nama_kategori_toko" id="nama_kategori_toko"
                                    value="{{ old('nama_kategori_toko') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="gambar_kategori_toko" class="form-label">Gambar Kategori</label>
                                <input type="file" class="form-control" name="gambar_kategori_toko" id="gambar_kategori_toko" accept="image/*" required>
                                <small class="text-muted">Format: JPG, PNG, Max: 2MB</small>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="deskripsi_kategori_toko" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi_kategori_toko" id="deskripsi_kategori_toko" rows="3" required>{{ old('deskripsi_kategori_toko') }}</textarea>
                            </div>
                        </div>

                        <div class="tile-footer mt-4">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('kategori_toko.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js_content')
<script>
    setTimeout(function () {
        $('#success-alert').fadeOut('slow');
        $('#error-alert').fadeOut('slow');
    }, 3000);
</script>
@endsection
