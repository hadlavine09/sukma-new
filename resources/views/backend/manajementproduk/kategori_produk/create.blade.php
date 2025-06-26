@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-plus-circle"></i> Tambah Kategori Produk</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Tambah Kategori Produk</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    {{-- Pesan sukses --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Pesan error dari validasi --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('kategori_produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <!-- Nama Kategori Produk -->
                            <div class="col-md-6">
                                <label class="form-label" for="nama_kategori_produk">Nama Kategori Produk</label>
                                <input type="text" class="form-control" name="nama_kategori_produk" id="nama_kategori_produk" value="{{ old('nama_kategori_produk') }}" required>
                            </div>

                            <!-- Kategori Toko -->
                            <div class="col-md-6">
                                <label class="form-label" for="kategori_toko_id">Kategori Toko</label>
                                <select class="form-select" name="kategori_toko_id" id="kategori_toko_id" required>
                                    <option selected disabled hidden>-- Pilih Kategori Toko --</option>
                                    @foreach ($kategoriTokos as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_toko_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori_toko }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Deskripsi Kategori Produk -->
                            <div class="col-md-6">
                                <label class="form-label" for="deskripsi_kategori_produk">Deskripsi Kategori Produk</label>
                                <textarea class="form-control" name="deskripsi_kategori_produk" id="deskripsi_kategori_produk" rows="3" required>{{ old('deskripsi_kategori_produk') }}</textarea>
                            </div>

                            <!-- Gambar Kategori Produk -->
                            <div class="col-md-6">
                                <label class="form-label" for="gambar_kategori_produk">Gambar Kategori Produk</label>
                                <input type="file" class="form-control" name="gambar_kategori_produk" id="gambar_kategori_produk" accept="image/jpeg, image/png" required>
                                <small class="form-text text-muted">Format gambar: JPG, JPEG, PNG. Max 2MB.</small>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('kategori_produk.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
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
    // Sembunyikan alert setelah 3 detik
    setTimeout(function () {
        $('#success-alert').fadeOut('slow');
        $('#error-alert').fadeOut('slow');
    }, 3000);
</script>
@endsection
