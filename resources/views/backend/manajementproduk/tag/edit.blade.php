@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-pencil"></i> Edit Tag</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Edit Tag</a></li>
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

                    <form action="{{ route('tag.update', $tag->kode_tag) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Menggunakan PUT untuk update -->

                        <div class="row mb-3">
                            <!-- Kode Tag -->
                            <div class="col-md-6">
                                <label class="form-label">Kode Tag</label>
                                <input type="text" class="form-control" value="{{ $tag->kode_tag }}" readonly>
                            </div>

                            <!-- Nama Tag -->
                            <div class="col-md-6">
                                <label class="form-label">Nama Tag</label>
                                <input type="text" class="form-control" name="nama_tag" value="{{ old('nama_tag', $tag->nama_tag) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Gambar Tag -->
                            <div class="col-md-6">
                                <label class="form-label">Gambar Tag</label>
                                <input type="file" class="form-control" name="gambar_tag" accept="image/jpeg, image/png">
                                <small class="form-text text-muted">Pilih gambar JPG atau PNG</small>
                                @if($tag->gambar_tag)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/'.$tag->gambar_tag) }}" alt="Gambar Tag" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <span class="text-muted">Tidak ada gambar</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Deskripsi Tag -->
                            <div class="col-md-6">
                                <label class="form-label">Deskripsi Tag</label>
                                <textarea class="form-control" name="deskripsi_tag" rows="4" required>{{ old('deskripsi_tag', $tag->deskripsi_tag) }}</textarea>
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
        $('.alert').fadeOut('slow');
    }, 3000);  // 3 detik
</script>
@endsection
