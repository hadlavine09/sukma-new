@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-cart-plus"></i> Tambah Cart</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Transaksi</li>
            <li class="breadcrumb-item active"><a href="#">Tambah Cart</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    {{-- Alert Sukses --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Alert Error --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            {{-- User --}}
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">Nama User</label>
                                <select name="user_id" id="user_id" class="form-select" required>
                                    <option disabled selected>-- Pilih User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Produk --}}
                            <div class="col-md-6">
                                <label for="kode_produk" class="form-label">Produk</label>
                                <select name="kode_produk" id="kode_produk" class="form-select" required>
                                    <option disabled selected>-- Pilih Produk --</option>
                                    @foreach($produks as $produk)
                                        <option value="{{ $produk->kode_produk }}"
                                            data-stok="{{ $produk->stok_produk }}">
                                            {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            {{-- Jumlah --}}
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                                <small id="stok-info" class="text-muted">Stok tersedia: -</small>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cart-plus"></i> Tambah ke Cart
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-secondary">
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
    document.addEventListener('DOMContentLoaded', function () {
        const produkSelect = document.getElementById('kode_produk');
        const quantityInput = document.getElementById('quantity');
        const stokInfo = document.getElementById('stok-info');

        produkSelect.addEventListener('change', function () {
            const selectedOption = produkSelect.options[produkSelect.selectedIndex];
            const stok = selectedOption.getAttribute('data-stok');
            if (stok) {
                quantityInput.max = stok;
                stokInfo.textContent = `Stok tersedia: ${stok}`;
            } else {
                quantityInput.removeAttribute('max');
                stokInfo.textContent = 'Stok tersedia: -';
            }
        });

        setTimeout(() => {
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');
            if (successAlert) successAlert.style.display = 'none';
            if (errorAlert) errorAlert.style.display = 'none';
        }, 3000);
    });
</script>
@endsection
