@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-eye"></i> Detail Kategori</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Produk</li>
            <li class="breadcrumb-item active"><a href="#">Detail Kategori</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form>
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Kode Kategori</label>
                                <input type="text" class="form-control" value="{{ $kategori->kode_kategori }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" value="{{ $kategori->nama_kategori }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi_kategori" rows="2" readonly>{{ $kategori->deskripsi_kategori }}</textarea>
                            </div>
                        </div>

                        <!-- Menambahkan Gambar Kategori -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Gambar Kategori</label>
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

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Waktu Dibuat</label>
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($kategori->created_at)->format('d M Y, H:i') }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Waktu Diupdate</label>
                                <input type="text" class="form-control"
                                       value="{{ $kategori->updated_at ? \Carbon\Carbon::parse($kategori->updated_at)->format('d M Y, H:i') : '-' }}"
                                       readonly>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
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
    document.addEventListener("DOMContentLoaded", function () {
        const textarea = document.getElementById("deskripsi_kategori");

        function resizeTextarea() {
            textarea.style.height = "auto";
            textarea.style.height = textarea.scrollHeight + "px";
        }

        resizeTextarea();
    });
</script>
@endsection
