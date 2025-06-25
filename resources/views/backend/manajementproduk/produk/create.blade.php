@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-plus-circle"></i> Tambah Produk</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Tambah Produk</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <!-- Nama Produk -->
                            <div class="col-md-6">
                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk" id="nama_produk" required>
                            </div>

                            <!-- Kategori -->
                            <div class="col-md-6">
                                <label for="kode_kategori" class="form-label">Kategori</label>
                                <select class="form-select" name="kode_kategori" id="kode_kategori" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($kategori as $item)
                                        <option value="{{ $item->kode_kategori }}">{{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Harga Produk -->
                            <div class="col-md-6">
                                <label for="harga_produk" class="form-label">Harga Produk</label>
                                <input type="number" class="form-control" name="harga_produk" id="harga_produk" min="1" required>
                            </div>

                            <!-- Stok Produk -->
                            <div class="col-md-6">
                                <label for="stok_produk" class="form-label">Stok Produk</label>
                                <input type="number" class="form-control" name="stok_produk" id="stok_produk" min="1" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Gambar Produk -->
                            <div class="col-md-6">
                                <label for="gambar_produk" class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" name="gambar_produk" id="gambar_produk" accept="image/*">
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-md-6">
                                <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
                                <textarea class="form-control" name="deskripsi_produk" id="deskripsi_produk" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Tag Produk -->
                            <div class="col-md-6">
                                <label for="tags" class="form-label">Tags</label>
                                <select class="form-select" name="tags[]" id="tags" multiple required>
                                    <option value="" disabled>-- Pilih Tag --</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->kode_tag }}">{{ $tag->nama_tag }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Status Produk -->
                            {{-- <div class="col-md-6">
                                <label for="status_draf_produk" class="form-label">Status Produk</label>
                                <select class="form-select" name="status_draf_produk" id="status_draf_produk" required>
                                    <option value="Aktif" selected>Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div> --}}
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
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
    // Script untuk menghilangkan alert setelah 3 detik
    setTimeout(function() {
        $('#success-alert').fadeOut('slow');
        $('#error-alert').fadeOut('slow');
    }, 3000);
</script>
@endsection
