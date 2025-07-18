@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title mb-4">
        <h1><i class="bi bi-truck"></i> Detail Pengiriman</h1>
    </div>

    {{-- Step Pengiriman --}}
    <div class="tile bg-white p-4 shadow-sm rounded mb-4">
        <h5 class="mb-3">Status Pengiriman</h5>
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-geo-alt-fill text-primary fs-3"></i>
            <div>
                <strong>Status:</strong>
                @if($transaksiToko->status_pengiriman === 'selesai')
                    <span class="badge bg-success">Selesai</span>
                @else
                    <span class="badge bg-warning text-dark">Proses</span>
                @endif
                <br>
                <small class="text-muted">Transaksi: #{{ $transaksiToko->kode_transaksi }}</small>
            </div>
        </div>
    </div>

    {{-- Informasi Pembeli dan Alamat --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="tile bg-white p-4 shadow-sm rounded h-100">
                <h5 class="mb-3">Informasi Pembeli</h5>
                <p><strong>Nama:</strong> {{ $transaksiToko->nama_user }}</p>
                <p><strong>Nama Toko:</strong> {{ $transaksiToko->nama_toko }}</p>
                <p><strong>Status Transaksi:</strong> {{ ucfirst($transaksiToko->status_transaksi) }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile bg-white p-4 shadow-sm rounded h-100">
                <h5 class="mb-3">Alamat Pengiriman</h5>
                <p><strong>Label:</strong> {{ $transaksiToko->nama_alamat }}</p>
                <p><strong>Nama Penerima:</strong> {{ $transaksiToko->nama_penerima }}</p>
                <p><strong>No HP:</strong> {{ $transaksiToko->no_hp }}</p>
                <p><strong>Alamat Lengkap:</strong><br>{{ $transaksiToko->alamat_lengkap }}</p>
            </div>
        </div>
    </div>

    {{-- Daftar Produk --}}
    <div class="tile bg-white p-4 shadow-sm rounded mb-4">
        <h5 class="mb-3">Produk dalam Pesanan</h5>
        @forelse ($produks as $produk)
        <div class="d-flex justify-content-between align-items-center border-bottom py-3">
            <div>
                <h6 class="mb-1">{{ $produk->nama_produk }}</h6>
                <small>Catatan: {{ $produk->catatan ?? '-' }}</small>
            </div>
            <div class="text-end">
                <p class="mb-0">Qty: <strong>{{ $produk->qty }}</strong></p>
                <p class="mb-0">Harga: <strong>Rp{{ number_format($produk->harga_satuan) }}</strong></p>
                <p class="mb-0">Subtotal: <strong>Rp{{ number_format($produk->subtotal_produk) }}</strong></p>
            </div>
        </div>
        @empty
        <p class="text-muted">Tidak ada produk pada transaksi ini.</p>
        @endforelse
    </div>

    {{-- Ringkasan Pembayaran --}}
    <div class="tile bg-light p-4 shadow-sm rounded mb-4">
        <h5 class="mb-3">Ringkasan Pembayaran</h5>
        <table class="table table-borderless">
            <tr>
                <td>Subtotal Toko</td>
                <td class="text-end">Rp{{ number_format($transaksiToko->subtotal) }}</td>
            </tr>
            <tr>
                <td>Biaya Admin Desa</td>
                <td class="text-end">Rp{{ number_format($transaksiToko->biaya_admin_desa_persen) }}</td>
            </tr>
            <tr>
                <td>Biaya Pengiriman</td>
                <td class="text-end">Rp{{ number_format($transaksiToko->biaya_pengiriman) }}</td>
            </tr>
            <tr>
                <th>Total Setelah Biaya</th>
                <th class="text-end">Rp{{ number_format($transaksiToko->total_setelah_biaya) }}</th>
            </tr>
            <tr>
                <td>Transfer ke Toko</td>
                <td class="text-end">Rp{{ number_format($transaksiToko->jumlah_uang ?? 0) }}</td>
            </tr>
        </table>
    </div>

    {{-- Form Bukti Penyerahan Barang --}}
    @if($transaksiToko->status_pengiriman !== 'selesai')
    <div class="tile bg-white p-4 shadow-sm rounded mb-4">
        <h5 class="mb-3">Penyerahan Barang</h5>
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="bukti_pengiriman">Upload Bukti Penyerahan (Foto)</label>
                <input type="file" name="bukti_pengiriman" id="bukti_pengiriman" class="form-control" required>
                @error('bukti_pengiriman')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle-fill"></i> Tandai Sudah Diserahkan
            </button>
        </form>
    </div>
    @endif

    <div class="text-end">
        <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</main>
@endsection
