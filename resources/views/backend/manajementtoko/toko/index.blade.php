@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title mb-4">
        <div>
            <h4><i class="bi bi-shop me-2"></i>Data Toko</h4>
            <p class="text-muted">Tabel untuk menampilkan data toko</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><i class="bi bi-house-door"></i></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Toko</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
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
                <a href="{{ route('toko.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Toko</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle border shadow-sm rounded" id="tokoTable">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Toko</th>
                            <th>Pemilik</th>
                            <th>Kategori</th>
                            <th>Staus</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data loaded via DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus toko <strong id="toko-nama"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('toko.destroy') }}" method="POST" id="deleteTokoForm">
                    @csrf
                    <input type="hidden" name="id">
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
            $('#tokoTable').DataTable({
                processing: false,
                serverSide: false,
                responsive: false,
                scrollX: false,
                scrollY: false,
                ajax: '{!! route('toko.index') !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
                    { data: 'nama_toko', name: 'nama_toko' },
                    { data: 'nama_pemilik', name: 'nama_pemilik' },
                    { data: 'nama_kategori_toko', name: 'nama_kategori_toko' },
                    { data: 'status_aktif_toko', name: 'status_aktif_toko' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" }
                ]
            });

            $(document).on('click', '.delete-btn', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nm');

                $('#toko-nama').text(nama);
                $('#deleteTokoForm').attr('action', '{{ route('toko.destroy') }}');
                $('#deleteTokoForm input[name="id"]').val(id);
                $('#deleteModal').modal('show');
            });

            setTimeout(() => {
                $('#success-alert, #error-alert').fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection
