@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title mb-4">
        <div>
            <h4><i class="bi bi-plus-circle me-2"></i>Tambah Material</h4>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active">Tambah Material</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            {{-- Success Alert --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Error Alert --}}
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

            {{-- Form --}}
            <form action="{{ route('material.store') }}" method="POST">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="nama_material" class="form-label">Nama Material</label>
                        <input type="text" class="form-control shadow-sm" name="nama_material" id="nama_material" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jumlah_material" class="form-label">Jumlah Material</label>
                        <input type="number" class="form-control shadow-sm" name="jumlah_material" id="jumlah_material" min="1" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="harga_material" class="form-label">Harga Material</label>
                        <input type="number" class="form-control shadow-sm" name="harga_material" id="harga_material" min="0" required>
                    </div>

                    <div class="col-md-6">
                        <label for="deskripsi_material" class="form-label">Deskripsi Material</label>
                        <textarea class="form-control shadow-sm" name="deskripsi_material" id="deskripsi_material" rows="3" required></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-check-circle me-1"></i> Simpan
                    </button>
                    <a href="{{ route('material.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('js_content')
<script>
    setTimeout(function() {
        $('#success-alert').fadeOut('slow');
        $('#error-alert').fadeOut('slow');
    }, 3000);
</script>
@endsection
