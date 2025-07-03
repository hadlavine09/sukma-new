@extends('backend.component.main')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-plus-circle"></i> Tambah Produk</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active"><a href="#">Tambah Produk</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                       @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


                        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <!-- Nama Produk -->
                                <div class="col-md-6">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk" id="nama_produk" required>
                                </div>
                                <!-- Gambar Produk -->
                                <div class="col-md-6">
                                    <label for="gambar_produk" class="form-label">Gambar Produk</label>
                                    <input type="file" class="form-control" name="gambar_produk" id="gambar_produk"
                                        accept="image/*">
                                </div>
                            </div>

                            <div class="row mb-3">

                                <!-- Kategori -->
                                <div class="col-md-6">
                                    <label for="kategori_id" class="form-label">Kategori</label>
                                    <select class="form-select" name="kategori_id" id="kategori_id"
                                        required>
                                        <option disabled selected hidden>-- Pilih Kategori --</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama_kategori_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="kode_tag" class="form-label">Tag Produk</label>
                                    <select class="form-select" name="kode_tag[]" id="kode_tag" multiple required disabled>
                                        <!-- Options akan diisi otomatis oleh JavaScript -->
                                    </select>
                                </div>


                            </div>
                            <div class="row mb-3">
                                <!-- Harga Produk -->
                                <div class="col-md-6">
                                    <label for="harga_produk" class="form-label">Harga Produk</label>
                                    <input type="number" class="form-control" name="harga_produk" id="harga_produk"
                                        min="1" required>
                                </div>

                                <!-- Stok Produk -->
                                <div class="col-md-6">
                                    <label for="stok_produk" class="form-label">Stok Produk</label>
                                    <input type="number" class="form-control" name="stok_produk" id="stok_produk"
                                        min="1" required>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <!-- Deskripsi -->
                                <div class="col-md-12">
                                    <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
                                    <textarea class="form-control" name="deskripsi_produk" id="deskripsi_produk" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i>
                                    Simpan</button>
                                <a href="{{ route('produk.index') }}" class="btn btn-secondary"><i
                                        class="bi bi-arrow-left"></i> Kembali</a>
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
        // Script untuk menghilangkan alert setelah 3 detik
        setTimeout(function() {
            $('#success-alert').fadeOut('slow');
            $('#error-alert').fadeOut('slow');
        }, 3000);


    $(document).ready(function () {
        $('#kategori_id').on('change', function () {
            var kategoriId = $(this).val();

            if (!kategoriId) {
                $('#kode_tag').html('').prop('disabled', true);
                return;
            }

            $.ajax({
                url: "{{ route('produk.tagkategori') }}",
                type: "POST",
                data: {
                    kategori_id: kategoriId,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        let options = '';
                        response.data.forEach(function (tag) {
                            options += `<option value="${tag.id}">${tag.nama_tag}</option>`;
                        });

                        $('#kode_tag').html(options).prop('disabled', false);
                    } else {
                        $('#kode_tag').html('').prop('disabled', true);
                    }
                },
                error: function (xhr) {
                    console.error('Gagal ambil tag:', xhr.responseText);
                    $('#kode_tag').html('').prop('disabled', true);
                }
            });
        });
    });
</script>
@endsection

