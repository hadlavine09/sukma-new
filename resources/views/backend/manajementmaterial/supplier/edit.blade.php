@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-pencil-square"></i> Edit Supplier</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
            <li class="breadcrumb-item active">Edit Supplier</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

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

                    <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                                <input type="text" class="form-control" name="nama_supplier" id="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contact_supplier" class="form-label">Kontak Supplier (opsional)</label>
                                <input type="text" class="form-control" name="contact_supplier" id="contact_supplier" value="{{ old('contact_supplier', $supplier->contact_supplier) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="material_id" class="form-label">Material</label>
                                <select class="form-control" name="material_id" id="material_id">
                                    <option disabled hidden>-- Pilih Material --</option>
                                    @foreach ($materials as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $supplier->material_id ? 'selected' : '' }}>
                                            {{ $item->nama_material }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah_material_supplier" class="form-label">Jumlah Material</label>
                                <input type="number" class="form-control" name="jumlah_material_supplier" id="jumlah_material_supplier" value="{{ old('jumlah_material_supplier', $supplier->jumlah_material_supplier) }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="total_harga_material_supplier" class="form-label">Total Harga Material</label>
                                <input type="number" class="form-control" name="total_harga_material_supplier" id="total_harga_material_supplier" value="{{ old('total_harga_material_supplier', $supplier->total_harga_material_supplier) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="alamat_supplier" class="form-label">Alamat Supplier (opsional)</label>
                                <textarea class="form-control" name="alamat_supplier" id="alamat_supplier" rows="1">{{ old('alamat_supplier', $supplier->alamat_supplier) }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="2">{{ old('deskripsi', $supplier->deskripsi) }}</textarea>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Update</button>
                            <a href="{{ route('supplier.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
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
    setTimeout(function () {
        $('#success-alert').fadeOut('slow');
        $('#error-alert').fadeOut('slow');
    }, 3000);
</script>
@endsection
