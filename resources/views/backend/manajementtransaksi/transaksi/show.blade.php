@extends('backend.component.main')

@section('content')
<main class="app-content">
  <div class="app-title">
    <h1><i class="bi bi-receipt"></i> Detail Transaksi</h1>
  </div>

  <!-- INFORMASI TRANSAKSI -->
  <div class="tile p-4 shadow-sm bg-white rounded mb-4">
    <div class="row justify-content-between">
      <div class="col-md-6">
        <h5>Informasi Transaksi</h5>
        <ul class="list-unstyled small">
          <li><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</li>
          <li><strong>Status Transaksi:</strong>
            <span class="badge bg-{{ $transaksi->status_transaksi == 'selesai' ? 'success' : 'warning' }}">
              {{ ucfirst($transaksi->status_transaksi) }}
            </span>
          </li>
          <li><strong>Status Pengiriman:</strong>
            <span class="badge bg-{{ $transaksi->status_pengiriman == 'selesai' ? 'success' : 'info' }}">
              {{ ucfirst($transaksi->status_pengiriman) }}
            </span>
          </li>
          <li><strong>Metode Pembayaran:</strong> {{ strtoupper($transaksi->metode_pembayaran) }}</li>
          <li><strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y, H:i') }}</li>
        </ul>
      </div>
      <div class="col-md-5 text-md-end mt-3 mt-md-0">
        <h5>Total Bayar</h5>
        <h4 class="text-success">Rp {{ number_format($transaksi->total_bayar, 2, ',', '.') }}</h4>
      </div>
    </div>
  </div>

  <!-- INFORMASI PEMBELI & ALAMAT -->
  <div class="tile p-4 shadow-sm bg-white rounded mb-4">
    <div class="row">
      <div class="col-md-6">
        <h5>Data Pembeli</h5>
        <ul class="list-unstyled small">
          <li><strong>Nama:</strong> {{ $transaksi->user->name ?? '-' }}</li>
          <li><strong>Email:</strong> {{ $transaksi->user->email ?? '-' }}</li>
          <li><strong>No. HP:</strong> {{ $transaksi->user->phone ?? '-' }}</li>
        </ul>
      </div>
      <div class="col-md-6">
        <h5>Alamat Pengiriman</h5>
        @if($transaksi->alamat)
        <ul class="list-unstyled small">
          <li><strong>Label Alamat:</strong> {{ $transaksi->alamat->nama_alamat }}</li>
          <li><strong>Nama Penerima:</strong> {{ $transaksi->alamat->nama_penerima }}</li>
          <li><strong>No. HP:</strong> {{ $transaksi->alamat->no_hp }}</li>
          <li><strong>Alamat Lengkap:</strong><br> {{ $transaksi->alamat->alamat_lengkap }}</li>
        </ul>
        @else
        <p class="text-muted">Alamat tidak tersedia.</p>
        @endif
      </div>
    </div>
  </div>

  <!-- PRODUK YANG DIBELI -->
  <div class="tile p-4 shadow-sm bg-white rounded mb-4">
    <h5 class="mb-3">Produk yang Dibeli</h5>
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>Produk</th>
          <th class="text-center">Harga</th>
          <th class="text-center">Jumlah</th>
          <th class="text-end">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($produkDetails as $p)
        <tr>
          <td>
            <div class="d-flex align-items-center">
              @if($p['foto'])
              <img src="{{ asset($p['foto']) }}" alt="foto produk" class="rounded me-3" style="width:60px; height:60px; object-fit:cover;">
              @endif
              <div>
                <div class="fw-semibold">{{ $p['nama'] }}</div>
                <div class="small text-muted">ID: {{ $p['produk_id'] ?? '-' }}</div>
              </div>
            </div>
          </td>
          <td class="text-center">Rp {{ number_format($p['harga'], 2, ',', '.') }}</td>
          <td class="text-center">{{ $p['jumlah'] }}</td>
          <td class="text-end">Rp {{ number_format($p['subtotal'], 2, ',', '.') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- RINGKASAN PEMBAYARAN -->
  <div class="tile p-4 shadow-sm bg-white rounded mb-4">
    <h5>Ringkasan Pembayaran</h5>
    <div class="row">
      <div class="col-md-6 offset-md-6">
        <ul class="list-group list-group-flush small">
          <li class="list-group-item d-flex justify-content-between">
            <span>Subtotal</span>
            <strong>Rp {{ number_format($transaksi->subtotal, 2, ',', '.') }}</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Diskon</span>
            <strong>- Rp {{ number_format($transaksi->diskon, 2, ',', '.') }}</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Biaya Pengiriman</span>
            <strong>Rp {{ number_format($transaksi->biaya_pengiriman ?? 0, 2, ',', '.') }}</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span><strong>Total Bayar</strong></span>
            <strong class="text-success">Rp {{ number_format($transaksi->total_bayar, 2, ',', '.') }}</strong>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- CATATAN TRANSAKSI -->
  @if($transaksi->catatan)
  <div class="tile p-4 shadow-sm bg-white rounded mb-4">
    <h5>Catatan Pembeli</h5>
    <p class="small">{{ $transaksi->catatan }}</p>
  </div>
  @endif

  <!-- KEMBALI -->
  <div class="text-start mt-4">
    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Kembali ke Daftar Transaksi
    </a>
  </div>
</main>
@endsection
