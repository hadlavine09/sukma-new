@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-box"></i> Data Produk</h1>
            <p>Table untuk menampilkan data produk dengan lebih efektif</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active"><a href="#">Data Produk</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <!-- Menampilkan pesan sukses/error -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <a href="{{ route('produk.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Data</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="produkTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Stok Produk</th> <!-- Kolom stok -->
                                    <th>Harga Produk</th>
                                    <th>Gambar</th> <!-- Kolom gambar -->
                                    <th>Status Produk</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- Data akan dimuat melalui DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus produk <strong id="produk-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('produk.destroy') }}" method="POST" id="deleteProdukForm" class="d-inline">
                    @csrf
                    <input type="hidden" name="kode_produk" value=""> <!-- Hidden field for no_produk -->
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('js_content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            var produkTable = $('#produkTable').DataTable({
                processing: false,
                serverSide: false,
                responsive: false,
                scrollX: false,
                scrollY: false,
                ajax: '{!! route('produk.index') !!}',  // Get data through AJAX
                columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
                { data: 'kode_produk', name: 'kode_produk' },
                { data: 'nama_produk', name: 'nama_produk' },
                { data: 'stok_produk', name: 'stok_produk', className: "text-center" }, // Tambahan stok
                { data: 'harga_produk', name: 'harga_produk', className: "text-end" },
                { data: 'gambar_produk', name: 'gambar_produk', className: "text-center",
                    render: function(data, type, row) {
                        // Menggunakan asset() di dalam Blade untuk menghasilkan path gambar yang benar
                        var imageUrl = "{{ asset('storage') }}/" + data; // Menggunakan Blade untuk memulai URL
                        if (data) {
                            return `<img src="${imageUrl}" alt="gambar" height="50">`; // Menampilkan gambar
                        } else {
                            return '<span class="text-muted">Tidak ada</span>';
                        }
                    }
                },
                { data: 'status_produk', name: 'status_produk', className: "text-center" },
                { data: 'status_draf_produk', name: 'status_draf_produk', className: "text-center" },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" }
            ],

            });

            // Handle delete button click
            $(document).on('click', '.delete-btn', function() {
                var kode_produk = $(this).data('id');  // Get the no_produk from the clicked button
                var produkName = $(this).data('nm');  // Get the name from the button

                // Update the name in the modal
                $('#produk-name').text(produkName);

                // Update the action URL for the form
                $('#deleteProdukForm').attr('action', '{{ route('produk.destroy') }}');  // POST to destroy route

                // Update the hidden input field with the kode_produk (no_produk)
                $('#deleteProdukForm').find('input[name="kode_produk"]').val(kode_produk);

                // Show the modal
                $('#deleteModal').modal('show');
            });

            // Auto-dismiss alert after 3 seconds
            setTimeout(function() {
                $('#success-alert').fadeOut('slow');
                $('#error-alert').fadeOut('slow');
            }, 3000); // 3000 milliseconds = 3 seconds
        });
    </script>
@endsection
