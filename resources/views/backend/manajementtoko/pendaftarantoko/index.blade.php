@extends('backend.component.main')

@section('content')
    <main class="app-content">
        <div class="app-title mb-4">
            <div>
                <h4><i class="bi bi-file-earmark-check me-2"></i>Data Pendaftaran Toko</h4>
                <p class="text-muted">Tabel untuk menampilkan data pengajuan toko</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><i class="bi bi-house-door"></i></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Pendaftaran Toko</li>
                </ol>
            </nav>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
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
                {{-- <div class="mb-3">
                    <a href="{{ route('izin_toko.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah
                        Toko</a>
                </div> --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle border shadow-sm rounded" id="izinTokoTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Toko</th>
                                <th>Pemilik</th>
                                <th>Logo</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data via DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

<!-- Modal Konfirmasi -->
<div class="modal fade" id="verifModal" tabindex="-1" aria-labelledby="verifModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="verifModalLabel">
                    <i class="bi bi-check-circle me-2"></i>Verifikasi Toko
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin <strong id="verif-aksi">menyetujui</strong> toko <strong
                    id="verif-nama"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('izin_toko.verifikasi') }}" method="POST" id="verifTokoForm">
                    @csrf
                    <input type="hidden" name="id">
                    <input type="hidden" name="status">
                    <button type="submit" class="btn btn-success btn-sm">Ya, Lanjutkan</button>
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
            $('#izinTokoTable').DataTable({
                processing: false,
                serverSide: false,
                responsive: true,
                ajax: '{!! route('izin_toko.index') !!}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center"
                    },
                    {
                        data: 'nama_toko',
                        name: 'nama_toko'
                    },
                    {
                        data: 'nama_pemilik',
                        name: 'nama_pemilik'
                    },
                    {
                        data: 'logo_toko',
                        name: 'logo_toko',
                        className: "text-center",
                        render: function(data) {
                            let imageUrl = "{{ asset('storage') }}/" + data;
                            return data ? `<img src="${imageUrl}" alt="logo" height="50">` :
                                '<span class="text-muted">Tidak ada</span>';
                        }
                    },
                    {
                        data: 'alamat_toko',
                        name: 'alamat_toko'
                    },
                    {
                        data: 'status_toko',
                        name: 'status_toko'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    }
                ]
            });

            // Modal verifikasi
            $(document).on('click', '.verifikasi-btn', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nm');
                const aksi = $(this).data('aksi');

                $('#verifTokoForm input[name="id"]').val(id);
                $('#verifTokoForm input[name="status"]').val(aksi);
                $('#verif-aksi').text(aksi === 'disetujui' ? 'menyetujui' : 'menolak');
                $('#verif-nama').text(nama);
                $('#verifModal').modal('show');
            });


            setTimeout(() => {
                $('#success-alert, #error-alert').fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection
