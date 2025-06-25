@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-pencil-square"></i> Edit Kategori Toko</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Edit Kategori Toko</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    {{-- Alert --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('kategori_toko.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama & Gambar --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_kategori_toko" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" name="nama_kategori_toko" id="nama_kategori_toko"
                                    value="{{ old('nama_kategori_toko', $kategori->nama_kategori_toko) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="gambar_kategori_toko" class="form-label">Gambar Kategori</label>
                                <input type="file" class="form-control" name="gambar_kategori_toko" id="gambar_kategori_toko" accept="image/*">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti</small>
                                @if($kategori->gambar_kategori_toko)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $kategori->gambar_kategori_toko) }}" alt="Gambar Kategori" width="120" class="img-thumbnail">
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="deskripsi_kategori_toko" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi_kategori_toko" id="deskripsi_kategori_toko" rows="3" required>{{ old('deskripsi_kategori_toko', $kategori->deskripsi_kategori_toko) }}</textarea>
                            </div>
                        </div>

                        <div class="tile-footer mt-4">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Update</button>
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
