@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-table"></i> Data Hak Akses</h1>
            <p>Table untuk menampilkan data hak akses dengan lebih efektif</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active"><a href="#">Data Hak Akses</a></li>
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
                        <!-- Tambahkan validasi untuk tombol Tambah Data -->
                        @php
                        $validHakAkses = ['Create', 'Read', 'Update', 'Delete'];
                        $validHakAksesCount = $hakakses->filter(function($item) use ($validHakAkses) {
                            return in_array($item->hakakses, $validHakAkses);
                        })->count();
                        @endphp

                        @if($hakakses->count() < 4 && $validHakAksesCount == $hakakses->count()) <!-- Cek jika jumlah data lebih sedikit dari 4 dan hanya ada Create, Read, Update, Delete -->
                        <div class="mb-3">
                        <a href="{{ route('hakakses.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Data</a>
                        </div>
                        @endif


                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="hakaksesTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hak Akses</th>
                                    <th>Deskripsi</th>
                                    <th>Waktu Dibuat</th>
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
                Apakah Anda yakin ingin menghapus hak akses <strong id="hakakses-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('hakakses.destroy') }}" method="POST" id="deleteForm" class="d-inline">
                    @csrf
                    <input type="hidden" name="id" value=""> <!-- Hidden field for ID -->
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
            var hakaksesTable = $('#hakaksesTable').DataTable({
                processing: false,
                serverSide: false,
                responsive: false,
                scrollX: false,
                scrollY: false,
                ajax: '{!! route('hakakses.index') !!}',  // Get data through AJAX
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
                    { data: 'hakakses', name: 'hakakses' },
                    { data: 'description', name: 'description' },
                    { data: 'time_hakakses', name: 'time_hakakses' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" }
                ],
            });
            $(document).on('click', '.delete-btn', function() {
                var hakaksesId = $(this).data('id');  // Get the ID from the clicked button
                var hakaksesName = $(this).data('nm');  // Get the name from the button

                // Update the name in the modal
                $('#hakakses-name').text(hakaksesName);

                // Update the action URL for the form
                $('#deleteForm').attr('action', '{{ route('hakakses.destroy') }}');  // POST to destroy route

                // Set the ID in the form input field
                $('#deleteForm').find('input[name="id"]').val(hakaksesId);

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
