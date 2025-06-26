@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-pencil"></i> Edit Kategori Produk</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Edit Kategori Produk</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    {{-- Alert error dari session --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Alert validasi --}}
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

                    <form action="{{ route('kategori_produk.update', $kategori->kode_kategori_produk) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <!-- Nama Kategori Produk -->
                            <div class="col-md-6">
                                <label class="form-label">Nama Kategori Produk</label>
                                <input type="text" class="form-control" name="nama_kategori_produk"
                                    value="{{ old('nama_kategori_produk', $kategori->nama_kategori_produk) }}" required>
                            </div>

                            <!-- Kategori Toko -->
                            <div class="col-md-6">
                                <label class="form-label">Kategori Toko</label>
                                <select name="kategori_toko_id" class="form-select" required>
                                    <option disabled hidden>-- Pilih Kategori Toko --</option>
                                    @foreach ($kategoriTokos as $kt)
                                        <option value="{{ $kt->id }}"
                                            {{ old('kategori_toko_id', $kategori->kategori_toko_id) == $kt->id ? 'selected' : '' }}>
                                            {{ $kt->nama_kategori_toko }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Deskripsi Kategori Produk -->
                            <div class="col-md-6">
                                <label class="form-label">Deskripsi Kategori Produk</label>
                                <textarea name="deskripsi_kategori_produk" rows="4" class="form-control" required>{{ old('deskripsi_kategori_produk', $kategori->deskripsi_kategori_produk) }}</textarea>
                            </div>

                            <!-- Gambar Kategori Produk -->
                            <div class="col-md-6">
                                <label class="form-label">Gambar Kategori Produk</label>
                                <input type="file" name="gambar_kategori_produk" class="form-control" accept="image/jpeg, image/png">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>

                                @if($kategori->gambar_kategori_produk)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/'.$kategori->gambar_kategori_produk) }}" class="img-thumbnail" style="max-height: 100px;" alt="Gambar Kategori Produk Saat Ini">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Simpan Perubahan</button>
                            <a href="{{ route('kategori_produk.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Daftar</a>
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
    setTimeout(function() {
        $('#error-alert').fadeOut('slow');
    }, 3000);
</script>
@endsection
