@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-people"></i> Data Supplier</h1>
            <p>Table untuk menampilkan data supplier</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active"><a href="#">Data Supplier</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
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
                        <a href="{{ route('supplier.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Supplier</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="supplierTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Supplier</th>
                                    <th>Nama Supplier</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data loaded via DataTables -->
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
                <h5 class="modal-title text-danger" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus Data Supplier
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus supplier <strong id="supplier-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('supplier.destroy') }}" method="POST" id="deleteSupplierForm" class="d-inline">
                    @csrf
                    <input type="hidden" name="id" value="">
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
            var supplierTable = $('#supplierTable').DataTable({
                processing: false,
                serverSide: false,
                responsive: false,
                scrollX: false,
                scrollY: false,
                ajax: '{!! route('supplier.index') !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
                    { data: 'kode_supplier', name: 'kode_supplier' },
                    { data: 'nama_supplier', name: 'nama_supplier' },
                    { data: 'tanggal', name: 'tanggal' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" }
                ]
            });

            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                var nama_supplier = $(this).data('nm');

                $('#supplier-name').text(nama_supplier);
                $('#deleteSupplierForm').attr('action', '{{ route('supplier.destroy') }}');
                $('#deleteSupplierForm').find('input[name="id"]').val(id);
                $('#deleteModal').modal('show');
            });

            setTimeout(function() {
                $('#success-alert').fadeOut('slow');
                $('#error-alert').fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection
