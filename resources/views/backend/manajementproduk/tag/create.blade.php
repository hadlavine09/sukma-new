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

                    <form action="{{ route('tag.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <!-- Nama Tag -->
                            <div class="col-md-6">
                                <label class="form-label" for="nama_tag">Nama Tag</label>
                                <input type="text" class="form-control" name="nama_tag" id="nama_tag" required>
                            </div>

                            <!-- Gambar Tag -->
                            <div class="col-md-6">
                                <label class="form-label" for="gambar_tag">Gambar Tag</label>
                                <input type="file" class="form-control" name="gambar_tag" id="gambar_tag" accept="image/jpeg, image/png" required>
                                <small class="form-text text-muted">Pilih gambar JPG atau PNG</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                             <!-- Deskripsi Tag -->
                             <div class="col-md-12">
                                <label class="form-label" for="deskripsi_tag">Deskripsi Tag</label>
                                <textarea class="form-control" name="deskripsi_tag" id="deskripsi_tag" rows="3" placeholder="Masukkan deskripsi tag"></textarea>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('tag.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
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
