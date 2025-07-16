@extends('backend.component.main')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-eye"></i> Detail Produk</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Produk</li>
                <li class="breadcrumb-item active"><a href="#">Detail Produk</a></li>
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
                                    <label class="form-label">Kode Produk</label>
                                    <input type="text" class="form-control" value="{{ $produkDetail->kode_produk }}"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" value="{{ $produkDetail->nama_produk }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                {{-- <div class="col-md-6">
                                <label class="form-label">Harga Produk</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($produkDetail->harga_produk, 0, ',', '.') }}" readonly>
                            </div> --}}

                                <div class="col-md-6">
                                    <label class="form-label">Harga Produk</label>
                                    <input type="text" class="form-control"
                                        value="Rp {{ number_format($produkDetail->harga_produk, 0, ',', '.') }}" readonly>

                                    <!-- Biaya Admin -->
                                    <small class="form-text text-muted mt-1">
                                        Biaya Admin (10%):
                                        <span>Rp
                                            {{ number_format(round($produkDetail->harga_produk * 0.1), 0, ',', '.') }}</span>
                                    </small>

                                    <!-- Biaya Pengiriman -->
                                    <small class="form-text text-muted">
                                        Biaya Pengiriman (2%):
                                        <span>Rp
                                            {{ number_format(round($produkDetail->harga_produk * 0.02), 0, ',', '.') }}</span>
                                    </small>

                                    <!-- Harga Total -->
                                    @php
                                        $biayaAdmin = round($produkDetail->harga_produk * 0.1);
                                        $biayaPengiriman = round($produkDetail->harga_produk * 0.02);
                                        $hargaTotal = $produkDetail->harga_produk + $biayaAdmin + $biayaPengiriman;
                                    @endphp
                                    <small class="form-text text-muted">
                                        Harga Total:
                                        <span>Rp {{ number_format($hargaTotal, 0, ',', '.') }}</span>
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Stok Produk</label>
                                    <input type="text" class="form-control" value="{{ $produkDetail->stok_produk }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi Produk</label>
                                    <textarea class="form-control" id="deskripsi_produk" rows="3" readonly>{{ $produkDetail->deskripsi_produk }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Kategori</label>
                                    <input type="text" class="form-control" value="{{ $produkDetail->nama_kategori }}"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status Produk</label>
                                    <input type="text" class="form-control" value="{{ $produkDetail->status_produk }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Gambar Produk</label>
                                    <div>
                                        @if ($produkDetail->gambar_produk)
                                            <img src="{{ asset('storage/' . $produkDetail->gambar_produk) }}"
                                                alt="Gambar Produk" height="150">
                                        @else
                                            <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Waktu Dibuat</label>
                                    <input type="text" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($produkDetail->created_at)->format('d M Y, H:i') }}"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Waktu Diupdate</label>
                                    <input type="text" class="form-control"
                                        value="{{ $produkDetail->updated_at ? \Carbon\Carbon::parse($produkDetail->updated_at)->format('d M Y, H:i') : '-' }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Tags</label>
                                    @if (count($tags) > 0)
                                        <ul class="mb-0 ps-3">
                                            @foreach ($tags as $tag)
                                                <li>{{ $tag }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Tidak ada tag untuk produk ini.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="tile-footer">
                                <a href="{{ route('produk.index') }}" class="btn btn-secondary">
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
        document.addEventListener("DOMContentLoaded", function() {
            const textarea = document.getElementById("deskripsi_produk");
            textarea.style.height = "auto";
            textarea.style.height = textarea.scrollHeight + "px";
        });
    </script>
@endsection
