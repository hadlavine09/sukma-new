@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1><i class="bi bi-tags"></i> Data Tag</h1>
            <p>Tabel interaktif untuk menampilkan data Tag</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active"><a href="#">Data Tag</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="tile">
                <div class="tile-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="mb-3 text-end">
                        <a href="{{ route('tag.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Tambah Data
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tagTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Tag</th>
                                    <th>Nama Tag</th>
                                    <th>Gambar</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTable akan mengisi otomatis -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus Tag <strong id="tag-name"></strong>?
            </div>
            <div class="modal-footer">
                <form action="{{ route('tag.destroy') }}" method="POST" id="deletetagForm">
                    @csrf
                    <input type="hidden" name="kode_tag" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('js_content')
<!-- DataTables CSS & JS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    let tagTable = $('#tagTable').DataTable({
        processing: false,
        serverSide: false,
        responsive: false,
        scrollX: false,
        scrollY: false,
        ajax: '{{ route('tag.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center' },
            { data: 'kode_tag', name: 'kode_tag' },
            { data: 'nama_tag', name: 'nama_tag' },
            {
                data: 'gambar_tag',
                name: 'gambar_tag',
                className: 'text-center',
                render: function(data) {
                    if (data) {
                        return `<img src="{{ asset('storage') }}/${data}" alt="gambar" height="50">`;
                    }
                    return '<span class="text-muted">Tidak ada</span>';
                }
            },
            { data: 'deskripsi_tag', name: 'deskripsi_tag' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ]
    });

    // Event delete
    $(document).on('click', '.delete-btn', function() {
        const tagKode = $(this).data('id');
        const tagName = $(this).data('nm');
        $('#tag-name').text(tagName);
        $('#deletetagForm input[name="kode_tag"]').val(tagKode);
        $('#deleteModal').modal('show');
    });

    // Auto-dismiss alert
    setTimeout(() => {
        $('#success-alert, #error-alert').fadeOut('slow');
    }, 3000);
});
</script>
@endsection
