@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-table"></i> Data Kategori Produk</h1>
            <p>Menampilkan data kategori produk secara lengkap dan terstruktur.</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active"><a href="#">Kategori Produk</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    {{-- Notifikasi --}}
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

                    {{-- Tombol Tambah --}}
                    @if ($role->id != 2)
                        <div class="mb-3">
                            <a href="{{ route('kategori_produk.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus"></i> Tambah Kategori Produk
                            </a>
                        </div>
                    @endif

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="kategoriTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Kategori</th>
                                    <th>Nama Kategori Produk</th>
                                    <th>Gambar</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Diisi oleh DataTables --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Konfirmasi Hapus Kategori Produk</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              Apakah Anda yakin ingin menghapus kategori produk <strong id="kategori-name"></strong>?
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <form action="{{ route('kategori_produk.destroy') }}" method="POST" id="deletekategoriForm">
                  @csrf
                  <input type="hidden" name="kode_kategori_produk">
                  <button type="submit" class="btn btn-danger">Hapus</button>
              </form>
          </div>
      </div>
  </div>
</div>
@endsection

@section('js_content')
{{-- Include DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        let kategoriTable = $('#kategoriTable').DataTable({
                processing: false,
                serverSide: false,
                responsive: false,
                scrollX: false,
                scrollY: false,
            ajax: '{!! route('kategori_produk.index') !!}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
                { data: 'kode_kategori_produk', name: 'kode_kategori_produk' },
                { data: 'nama_kategori_produk', name: 'nama_kategori_produk' },
                {
                    data: 'gambar_kategori_produk',
                    name: 'gambar_kategori_produk',
                    className: "text-center",
                    render: function (data) {
                        if (data) {
                            return `<img src="{{ asset('storage') }}/` + data + `" class="img-thumbnail" height="50">`;
                        } else {
                            return '<span class="text-muted">Tidak ada gambar</span>';
                        }
                    }
                },
                { data: 'deskripsi_kategori_produk', name: 'deskripsi_kategori_produk' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: "text-center"
                }
            ]
        });

        // Buka modal saat klik tombol hapus
        $(document).on('click', '.delete-btn', function () {
            const kategoriKode = $(this).data('id');
            const kategoriName = $(this).data('nm');

            $('#kategori-name').text(kategoriName);
            $('#deletekategoriForm input[name="kode_kategori_produk"]').val(kategoriKode);
            $('#deleteModal').modal('show');
        });

        // Auto-hide alert
        setTimeout(() => {
            $('#success-alert').fadeOut('slow');
            $('#error-alert').fadeOut('slow');
        }, 3000);
    });
</script>
@endsection
