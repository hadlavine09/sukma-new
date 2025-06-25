@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-eye"></i> Detail Hak Akses</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Detail Hak Akses</a></li>
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
                                <label class="form-label">Hak Akses</label>
                                <input type="text" class="form-control" value="{{ $hakakses->hakakses }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Waktu Dibuat</label>
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($hakakses->time_hakakses)->format('d M Y, H:i') }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="1" readonly>{{ $hakakses->description }}</textarea>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <a href="{{ route('hakakses.index') }}" class="btn btn-secondary">
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
        const textarea = document.getElementById("description");

        function resizeTextarea() {
            textarea.style.height = "auto"; // Reset height
            textarea.style.height = textarea.scrollHeight + "px"; // Set height sesuai konten
        }

        resizeTextarea(); // Panggil saat halaman dimuat
    });
</script>
@endsection
