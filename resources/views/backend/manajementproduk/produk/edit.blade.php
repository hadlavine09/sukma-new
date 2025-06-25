@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-pencil"></i> Edit Produk</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Edit Produk</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('produk.update', $produk->kode_produk) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <!-- Nama Produk -->
                            <div class="col-md-6">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                            </div>

                            <!-- Kategori -->
                            <div class="col-md-6">
                                <label class="form-label">Kategori</label>
                                <select name="kode_kategori" class="form-select" required>
                                    @foreach($kategori as $item)
                                        <option value="{{ $item->kode_kategori }}" {{ $produk->kode_kategori == $item->kode_kategori ? 'selected' : '' }}>
                                            {{ $item->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Harga Produk -->
                            <div class="col-md-6">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga_produk" class="form-control" value="{{ old('harga_produk', $produk->harga_produk) }}" required>
                            </div>

                            <!-- Stok -->
                            <div class="col-md-6">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok_produk" class="form-control" value="{{ old('stok_produk', $produk->stok_produk) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Deskripsi -->
                            <div class="col-md-12">
                                <label class="form-label">Deskripsi Produk</label>
                                <textarea name="deskripsi_produk" class="form-control" rows="4">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Gambar Produk -->
                            <div class="col-md-6">
                                <label class="form-label">Gambar Produk</label>
                                <input type="file" name="gambar_produk" class="form-control">
                                @if($produk->gambar_produk)
                                    <small class="d-block mt-1">Gambar saat ini: <a href="{{ asset('storage/'.$produk->gambar_produk) }}" target="_blank">Lihat</a></small>
                                @endif
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label">Status Produk</label>
                                <select name="status_produk" class="form-select">
                                    <option value="Aktif" {{ $produk->status_produk == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ $produk->status_produk == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Tags -->
                            <div class="col-md-12">
                                <label class="form-label">Tags</label>
                                <select name="tags[]" class="form-select" multiple required>
                                    @foreach($allTags as $tag)
                                        <option value="{{ $tag->kode_tag }}"
                                            @if(in_array($tag->kode_tag, $tags)) selected @endif>
                                            {{ $tag->nama_tag }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Pilih satu atau lebih tag untuk produk ini</small>
                            </div>
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
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
@endsection
