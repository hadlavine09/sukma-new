@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-truck"></i> Data Pengiriman</h1>
            <p>Daftar pengiriman berdasarkan toko anda</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active"><a href="#">Data Pengiriman</a></li>
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

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="pengirimanTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Pembeli</th>
                                    <th>Status Transaksi</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables akan mengisi -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js_content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            var pengirimanTable = $('#pengirimanTable').DataTable({
                processing: false,
                serverSide: false,
                responsive: false,
                scrollX: false,
                scrollY: false,
                ajax: '{!! route('pengiriman.index') !!}', // Sesuaikan dengan route Anda
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
                    { data: 'kode_transaksi', name: 'kode_transaksi' },
                    { data: 'pembeli', name: 'pembeli' },
                    {
                        data: 'status_transaksi',
                        name: 'status_transaksi',
                        className: "text-center",
                        render: function(data) {
                            if (data === 'selesai') {
                                return `<span class="badge bg-success">Selesai</span>`;
                            } else if (data === 'proses') {
                                return `<span class="badge bg-warning text-dark">Proses</span>`;
                            } else {
                                return `<span class="badge bg-secondary">${data}</span>`;
                            }
                        }
                    },
                    { data: 'metode_pembayaran', name: 'metode_pembayaran', className: "text-end" },
                    { data: 'created_at', name: 'created_at', className: "text-center" },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" }
                ]
            });

            setTimeout(function () {
                $('#success-alert').fadeOut('slow');
                $('#error-alert').fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection
