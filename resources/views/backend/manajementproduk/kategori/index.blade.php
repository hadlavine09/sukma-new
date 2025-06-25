@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-table"></i> Data Kategori</h1>
            <p>Table untuk menampilkan data kategori dengan lebih efektif</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active"><a href="#">Data Kategori</a></li>
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
                        <a href="{{ route('kategori.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Data</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="kategoriTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Kategori</th>
                                    <th>Nama Kategori</th>
                                    <th>Gambar Kategori</th>
                                    <th>Deskripsi</th>
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
                Apakah Anda yakin ingin menghapus kategori <strong id="kategori-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('kategori.destroy') }}" method="POST" id="deletekategoriForm" class="d-inline">
                    @csrf
                    <input type="hidden" name="kode_kategori" value=""> <!-- Hidden field for kode_kategori -->
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
            var kategoriTable = $('#kategoriTable').DataTable({
                processing: false,
                serverSide: false,
                responsive: false,
                scrollX: false,
                scrollY: false,
                ajax: '{!! route('kategori.index') !!}',  // Get data through AJAX
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
                    { data: 'kode_kategori', name: 'kode_kategori' },
                    { data: 'nama_kategori', name: 'nama_kategori' },
                    { data: 'gambar_kategori', name: 'gambar_kategori', className: "text-center",
                        render: function(data, type, row) {
                            // Menggunakan Storage::url() untuk mendapatkan URL gambar yang benar
                            var imageUrl = "{{ asset('storage') }}/" + data; // Menggunakan Blade untuk memulai URL
                            if (data) {
                                return `<img src="${imageUrl}" alt="gambar" height="50">`; // Menampilkan gambar
                            } else {
                                return '<span class="text-muted">Tidak ada</span>';
                            }
                        }
                    },
                    { data: 'deskripsi_kategori', name: 'deskripsi_kategori' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" }
                ],

            });

            $(document).ready(function() {
                // Handle delete button click
                $(document).on('click', '.delete-btn', function() {
                    var kategoriKode = $(this).data('id');  // Get the kode_kategori from the clicked button
                    var kategoriName = $(this).data('nm');  // Get the name from the button

                    // Update the name in the modal
                    $('#kategori-name').text(kategoriName);

                    // Update the action URL for the form
                    $('#deletekategoriForm').attr('action', '{{ route('kategori.destroy') }}');  // POST to destroy route

                    // Update the hidden input field with the kategoriKode (kode_kategori)
                    $('#deletekategoriForm').find('input[name="kode_kategori"]').val(kategoriKode);

                    // Show the modal
                    $('#deleteModal').modal('show');
                });

                // Auto-dismiss alert after 3 seconds
                setTimeout(function() {
                        $('#success-alert').fadeOut('slow');
                        $('#error-alert').fadeOut('slow');
                }, 3000); // 3000 milliseconds = 3 seconds
            });

        });
    </script>
@endsection
