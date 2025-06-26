@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-plus-circle"></i> Tambah Tag</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Tambah Tag</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    {{-- Notifikasi sukses --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Notifikasi error --}}
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

                    <form action="{{ route('tag.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_tag" class="form-label">Nama Tag</label>
                                <input type="text" name="nama_tag" id="nama_tag" class="form-control" value="{{ old('nama_tag') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="gambar_tag" class="form-label">Gambar Tag</label>
                                <input type="file" name="gambar_tag" id="gambar_tag" class="form-control" accept="image/jpeg,image/png" required>
                                <small class="form-text text-muted">Pilih gambar JPG atau PNG</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="kategori_produk_id" class="form-label">Kategori Produk</label>
                                <select name="kategori_produk_id" id="kategori_produk_id" class="form-select" required>
                                    <option disabled selected hidden>-- Pilih Kategori Produk --</option>
                                    @foreach($kategoriProduks as $kp)
                                        <option value="{{ $kp->id }}" {{ old('kategori_produk_id') == $kp->id ? 'selected' : '' }}>
                                            {{ $kp->nama_kategori_produk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="deskripsi_tag" class="form-label">Deskripsi Tag</label>
                                <textarea name="deskripsi_tag" id="deskripsi_tag" rows="3" class="form-control">{{ old('deskripsi_tag') }}</textarea>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan
                            </button>
                            <a href="{{ route('tag.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
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
    setTimeout(() => {
        $('#success-alert').fadeOut('slow');
        $('#error-alert').fadeOut('slow');
    }, 3000);
</script>
@endsection
