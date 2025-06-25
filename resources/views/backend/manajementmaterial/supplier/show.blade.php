@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-info-circle"></i> Detail Supplier</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
            <li class="breadcrumb-item active">Detail Supplier</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kode Supplier:</label>
                            <div>{{ $supplier->kode_supplier }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Supplier:</label>
                            <div>{{ $supplier->nama_supplier }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kontak Supplier:</label>
                            <div>{{ $supplier->contact_supplier ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Alamat Supplier:</label>
                            <div>{{ $supplier->alamat_supplier ?? '-' }}</div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Material:</label>
                            <div>{{ $supplier->material->nama_material ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jumlah Material:</label>
                            <div>{{ number_format($supplier->jumlah_material_supplier) }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Harga Material:</label>
                            <div>Rp {{ number_format($supplier->harga_material_supplier, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Input:</label>
                            <div>{{ \Carbon\Carbon::parse($supplier->tanggal)->format('d-m-Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi:</label>
                        <div>{{ $supplier->deskripsi ?? '-' }}</div>
                    </div>

                    <div class="tile-footer mt-3">
                        <a href="{{ route('supplier.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
