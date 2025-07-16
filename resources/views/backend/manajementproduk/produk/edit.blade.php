@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-pencil-square"></i> Edit Produk</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Edit Produk</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('produk.update', $produk->kode_produk) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
                            </div>
                            <div class="col-md-6">
                                <label>Gambar Produk</label>
                                <input type="file" name="gambar_produk" class="form-control" accept="image/*">
                                @if ($produk->gambar_produk)
                                    <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="mt-2 rounded" height="100">
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Kategori</label>
                                <select name="kategori_id" id="kategori_id" class="form-select" required>
                                    <option disabled hidden>-- Pilih Kategori --</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $produk->kategori_toko_id ? 'selected' : '' }}>
                                            {{ $item->nama_kategori_produk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Tag Produk</label>
                                <select name="kode_tag[]" id="kode_tag" class="form-select" multiple required>
                                    {{-- Akan dimuat via JS --}}
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Harga Produk</label>
                                <input type="text" class="form-control" id="harga_produk_view" value="{{ number_format($produk->harga_produk, 0, '', '.') }}" required>

                                <input type="hidden" name="harga_produk" id="harga_produk">

                                <small class="form-text text-muted mt-1">Biaya Admin (10%): <span id="biaya_admin">Rp 0</span></small>
                                <small class="form-text text-muted">Biaya Pengiriman (2%): <span id="biaya_pengiriman">Rp 0</span></small>
                                <small class="form-text text-muted">Harga Total: <span id="harga_total">Rp 0</span></small>

                                <input type="hidden" name="biaya_admin_desa_persen" value="10">
                                <input type="hidden" name="biaya_pengiriman" id="biaya_pengiriman_val">
                                <input type="hidden" name="harga_total" id="harga_total_val">
                            </div>
                            <div class="col-md-6">
                                <label>Stok Produk</label>
                                <input type="number" name="stok_produk" class="form-control" value="{{ $produk->stok_produk }}" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Deskripsi Produk</label>
                            <textarea name="deskripsi_produk" class="form-control" rows="3" required>{{ $produk->deskripsi_produk }}</textarea>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Update</button>
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
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
    const selectedTags = @json($tags); // array id tag produk

    function loadTags(kategoriId) {
        if (!kategoriId) {
            $('#kode_tag').html('').prop('disabled', true);
            return;
        }

        $.ajax({
            url: "{{ route('produk.tagkategori') }}",
            method: "POST",
            data: {
                kategori_id: kategoriId,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.success) {
                    let options = '';
                    response.data.forEach(tag => {
                        const selected = selectedTags.includes(tag.id) ? 'selected' : '';
                        options += `<option value="${tag.id}" ${selected}>${tag.nama_tag}</option>`;
                    });
                    $('#kode_tag').html(options).prop('disabled', false);
                } else {
                    $('#kode_tag').html('').prop('disabled', true);
                }
            },
            error: function () {
                $('#kode_tag').html('').prop('disabled', true);
            }
        });
    }

    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function cleanNumber(val) {
        return val.replace(/[^\d]/g, '');
    }

    $(document).ready(function () {
        // Auto-hide alert
        setTimeout(() => {
            $('#success-alert').fadeOut('slow');
            $('#error-alert').fadeOut('slow');
        }, 3000);

        // Load tag pertama kali
        const initialKategori = $('#kategori_id').val();
        loadTags(initialKategori);

        // On kategori change
        $('#kategori_id').on('change', function () {
            const kategoriId = $(this).val();
            loadTags(kategoriId);
        });

        // Harga format & kalkulasi
        $('#harga_produk_view').on('input', function () {
            let raw = cleanNumber($(this).val());
            $(this).val(formatRupiah(raw));
            $('#harga_produk').val(raw);

            if (raw) {
                const harga = parseInt(raw);
                const biayaAdmin = Math.round(harga * 0.10);
                const biayaPengiriman = Math.round(harga * 0.02);
                const hargaTotal = harga + biayaAdmin + biayaPengiriman;

                $('#biaya_admin').text('Rp ' + formatRupiah(biayaAdmin));
                $('#biaya_pengiriman').text('Rp ' + formatRupiah(biayaPengiriman));
                $('#harga_total').text('Rp ' + formatRupiah(hargaTotal));

                $('#biaya_pengiriman_val').val(biayaPengiriman);
                $('#harga_total_val').val(hargaTotal);
            } else {
                $('#biaya_admin, #biaya_pengiriman, #harga_total').text('Rp 0');
                $('#harga_produk').val('');
                $('#biaya_pengiriman_val').val('');
                $('#harga_total_val').val('');
            }
        });

        $('#harga_produk_view').trigger('input'); // Trigger perhitungan saat load

        // Blok input huruf & simbol aneh
        $('#harga_produk_view').on('keydown', function (e) {
            const key = e.key;
            if (['e', 'E', '+', '-', ','].includes(key) || ((e.ctrlKey || e.metaKey) && key === 'v')) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
