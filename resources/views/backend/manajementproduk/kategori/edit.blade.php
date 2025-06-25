@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-pencil"></i> Edit Kategori</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Edit Kategori</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <!-- Menampilkan pesan error jika ada -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('kategori.update', $kategori->kode_kategori) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Menggunakan PUT untuk update -->

                        <div class="row mb-3">

                            <!-- Nama Kategori -->
                            <div class="col-md-6">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                            </div>
                             <!-- Deskripsi Kategori -->
                             <div class="col-md-6">
                                <label class="form-label">Deskripsi Kategori</label>
                                <textarea class="form-control" name="deskripsi_kategori" rows="4" required>{{ old('deskripsi_kategori', $kategori->deskripsi_kategori) }}</textarea>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <!-- Gambar Kategori -->
                            <div class="col-md-6">
                                <label class="form-label">Gambar Kategori</label>
                                <input type="file" class="form-control" name="gambar_kategori" accept="image/jpeg, image/png">
                                <small class="form-text text-muted">Pilih gambar JPG atau PNG</small>

                                <!-- Menampilkan gambar yang ada -->
                                @if($kategori->gambar_kategori)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/'.$kategori->gambar_kategori) }}" alt="Gambar Kategori" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <span class="text-muted">Tidak ada gambar</span>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
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
        $('.alert').fadeOut('slow');
    }, 3000);  // 3 detik
</script>
@endsection
