@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-plus-circle"></i> Tambah Kategori</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Tambah Kategori</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <!-- Menampilkan pesan sukses jika ada -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Menampilkan pesan error jika ada -->
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

                    <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <!-- Nama Kategori -->
                            <div class="col-md-6">
                                <label class="form-label" for="nama_kategori">Nama Kategori</label>
                                <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" required>
                            </div>

                            <!-- Gambar Kategori -->
                            <div class="col-md-6">
                                <label class="form-label" for="gambar_kategori">Gambar Kategori</label>
                                <input type="file" class="form-control" name="gambar_kategori" id="gambar_kategori" accept="image/jpeg, image/png" required>
                                <small class="form-text text-muted">Pilih gambar JPG atau PNG</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                             <!-- Deskripsi Kategori -->
                             <div class="col-md-12">
                                <label class="form-label" for="deskripsi_kategori">Deskripsi Kategori</label>
                                <textarea class="form-control" name="deskripsi_kategori" id="deskripsi_kategori" rows="3" placeholder="Masukkan deskripsi kategori"></textarea>
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
        // Menyembunyikan alert dengan class 'alert'
        $('#success-alert').fadeOut('slow');
        $('#error-alert').fadeOut('slow');
    }, 3000);  // 3 detik
</script>
@endsection
