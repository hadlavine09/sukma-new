@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-eye"></i> Detail Tag</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Produk</li>
            <li class="breadcrumb-item active"><a href="#">Detail Tag</a></li>
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
                                <label class="form-label">Kode Tag</label>
                                <input type="text" class="form-control" value="{{ $tag->kode_tag }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Tag</label>
                                <input type="text" class="form-control" value="{{ $tag->nama_tag }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi_tag" rows="2" readonly>{{ $tag->deskripsi_tag }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Gambar Tag</label>
                                <div>
                                    @if($tag->gambar_tag)
                                        <img src="{{ asset('storage/'.$tag->gambar_tag) }}" alt="Gambar Tag" class="img-thumbnail" style="max-height: 100px;">
                                    @else
                                        <span class="text-muted">Tidak ada gambar</span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Waktu Diupdate</label>
                                <input type="text" class="form-control"
                                value="{{ $tag->updated_at ? \Carbon\Carbon::parse($tag->updated_at)->format('d M Y, H:i') : '-' }}"
                                readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Waktu Dibuat</label>
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($tag->created_at)->format('d M Y, H:i') }}" readonly>
                            </div>
                        </div>

                        <div class="tile-footer">
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
    document.addEventListener("DOMContentLoaded", function () {
        const textarea = document.getElementById("deskripsi_tag");

        function resizeTextarea() {
            textarea.style.height = "auto";
            textarea.style.height = textarea.scrollHeight + "px";
        }

        resizeTextarea();
    });
</script>
@endsection
