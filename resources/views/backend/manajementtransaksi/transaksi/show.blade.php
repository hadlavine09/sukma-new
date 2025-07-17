@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <h1><i class="bi bi-receipt"></i> Detail Transaksi</h1>
    </div>

    <!-- Informasi Transaksi Utama -->
    <div class="tile p-4 bg-white shadow rounded mb-4">
        <h5>Informasi Transaksi</h5>
        <table class="table table-bordered">
            <tr>
                <th>Kode Transaksi</th>
                <td>{{ $transaksi->kode_transaksi }}</td>
            </tr>
            <tr>
                <th>Nama User</th>
                <td>{{ $transaksi->nama_user }}</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ strtoupper($transaksi->metode_pembayaran) }}</td>
            </tr>
            @if ($roleName === 'superadmin')

            <tr>
                <th>Subtotal</th>
                <td>Rp{{ number_format($transaksi->subtotal) }}</td>
            </tr>
            <tr>
                <th>Biaya Admin Desa</th>
                <td>Rp{{ number_format($transaksi->biaya_admin_desa_persen) }}</td>
            </tr>
            <tr>
                <th>Biaya Pengiriman</th>
                <td>Rp{{ number_format($transaksi->biaya_pengiriman) }}</td>
            </tr>
            <tr>
                <th>Total Setelah Biaya</th>
                <td>Rp{{ number_format($transaksi->total_setelah_biaya) }}</td>
            </tr>
            <tr>
                <th>Jumlah Uang (Transfer)</th>
                <td>Rp{{ number_format($transaksi->jumlah_uang ?? 0) }}</td>
            </tr>

            <tr>
                <th>Status Transaksi</th>
                <td>{{ ucfirst($transaksi->status_transaksi) }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Informasi Alamat -->
    <div class="tile p-4 bg-white shadow rounded mb-4">
        <h5>Alamat Pengiriman</h5>
        <table class="table table-bordered">
            <tr>
                <th>Label Alamat</th>
                <td>{{ $transaksi->nama_alamat }}</td>
            </tr>
            <tr>
                <th>Nama Penerima</th>
                <td>{{ $transaksi->nama_penerima }}</td>
            </tr>
            <tr>
                <th>No HP</th>
                <td>{{ $transaksi->no_hp }}</td>
            </tr>
            <tr>
                <th>Alamat Lengkap</th>
                <td>{{ $transaksi->alamat_lengkap }}</td>
            </tr>
        </table>
    </div>

    <!-- Transaksi Toko dan Produk -->
    @foreach ($transaksiTokos as $toko)
    <div class="tile p-4 bg-light shadow-sm rounded mb-4">
        <h5 class="mb-3">Toko: {{ $toko->nama_toko }}</h5>
        <table class="table table-bordered">
            <tr>
                <th>Status Pengiriman</th>
                <td>{{ ucfirst($toko->status_pengiriman) }}</td>
            </tr>
            <tr>
                <th>Subtotal Toko</th>
                <td>Rp{{ number_format($toko->subtotal) }}</td>
            </tr>
            <tr>
                <th>Biaya Admin Desa</th>
                <td>Rp{{ number_format($toko->biaya_admin_desa_persen) }}</td>
            </tr>
            <tr>
                <th>Biaya Pengiriman</th>
                <td>Rp{{ number_format($toko->biaya_pengiriman) }}</td>
            </tr>
            <tr>
                <th>Total Setelah Biaya</th>
                <td>Rp{{ number_format($toko->total_setelah_biaya) }}</td>
            </tr>
            <tr>
                <th>Jumlah Uang (Transfer Toko)</th>
                <td>Rp{{ number_format($toko->jumlah_uang ?? 0) }}</td>
            </tr>
            <tr>
                <th>Status Transaksi</th>
                <td>{{ ucfirst($toko->status_transaksi) }}</td>
            </tr>
        </table>

        <h6 class="mt-4">Detail Produk:</h6>
        <table class="table table-bordered mt-2">
            <thead class="table-dark">
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($toko->produks as $produk)
                <tr>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ $produk->qty }}</td>
                    <td>Rp{{ number_format($produk->harga_satuan) }}</td>
                    <td>Rp{{ number_format($produk->subtotal_produk) }}</td>
                    <td>{{ $produk->catatan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach

    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</main>
@endsection
