@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title mb-4">
        <div>
            <h4><i class="bi bi-eye me-2"></i>Detail Material</h4>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Material</li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Material</label>
                    <input type="text" class="form-control shadow-sm" value="{{ $material->nama_material }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jumlah Material</label>
                    <input type="text" class="form-control shadow-sm" value="{{ $material->jumlah_material }}" readonly>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Harga Material</label>
                    <input type="text" class="form-control shadow-sm" value="Rp{{ number_format($material->harga_material, 0, ',', '.') }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi Material</label>
                    <textarea class="form-control shadow-sm" rows="3" readonly>{{ $material->deskripsi_material }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-start">
                <a href="{{ route('material.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
