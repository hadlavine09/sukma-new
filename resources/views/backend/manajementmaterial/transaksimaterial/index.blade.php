@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-people"></i> Data Transaksi Material</h1>
            <p>Table untuk menampilkan data transaksi material</p>
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

                    <div class="row mb-3">
                        <div class="col-md-3 col-12 mb-2">
                            <label for="filterTahun" class="form-label">Filter Tahun</label>
                            <select id="filterTahun" class="form-select">
                                <option disabled selected hidden>Tahun</option>
                                @for ($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 col-12 mb-2">
                            <label for="filterBulan" class="form-label">Filter Bulan</label>
                            <select id="filterBulan" class="form-select" disabled>
                                <option disabled selected hidden>Bulan</option>
                                @foreach(range(1,12) as $bulan)
                                    <option value="{{ str_pad($bulan, 2, '0', STR_PAD_LEFT) }}">
                                        {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-12 mb-2">
                            <label for="filterTanggal" class="form-label">Filter Tanggal</label>
                            <select id="filterTanggal" class="form-select" disabled>
                                <option disabled selected hidden>Tanggal</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-12 mb-2">
                            <label class="form-label d-block invisible">Export</label>
                            <div class="d-flex gap-2">
                                <a id="exportPdf" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
                                <a id="exportExcel" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="supplierTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Supplier</th>
                                    <th>Nama Supplier</th>
                                    <th>Tanggal</th>
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

@section('js_content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
   $(document).ready(function () {
    const $tahun = $('#filterTahun');
    const $bulan = $('#filterBulan');
    const $tanggal = $('#filterTanggal');

    function populateTanggal() {
        const year = $tahun.val();
        const month = $bulan.val();

        if (!year || !month) return;

        const daysInMonth = new Date(year, month, 0).getDate();
        $tanggal.prop('disabled', false);
        $tanggal.empty().append('<option disabled selected hidden>Tanggal</option>');
        for (let d = 1; d <= daysInMonth; d++) {
            const dd = d.toString().padStart(2, '0');
            $tanggal.append(`<option value="${dd}">${dd}</option>`);
        }
    }

    // Tambahkan custom filter
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const tanggalStr = data[3]; // Kolom ke-4 (tanggal)

        const tahunFilter = $tahun.val();
        const bulanFilter = $bulan.val();
        const tanggalFilter = $tanggal.val();

        if (!tanggalStr) return true;

        const tanggalParts = tanggalStr.split('-'); // diasumsikan format YYYY-MM-DD

        const tahunData = tanggalParts[0];
        const bulanData = tanggalParts[1];
        const tanggalData = tanggalParts[2];

        if (
            (tahunFilter && tahunData !== tahunFilter) ||
            (bulanFilter && bulanData !== bulanFilter) ||
            (tanggalFilter && tanggalData !== tanggalFilter)
        ) {
            return false;
        }

        return true;
    });

    const supplierTable = $('#supplierTable').DataTable({
        processing: false,
        serverSide: false,
        responsive: false,
        ajax: '{!! route('supplier.index') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
            { data: 'kode_supplier', name: 'kode_supplier' },
            { data: 'nama_supplier', name: 'nama_supplier' },
            { data: 'tanggal', name: 'tanggal' },
        ]
    });

    $tahun.on('change', function () {
        $bulan.prop('disabled', false).empty().append('<option disabled selected hidden>Bulan</option>');
        for (let i = 1; i <= 12; i++) {
            const bulanNum = i.toString().padStart(2, '0');
            const namaBulan = new Date(2000, i - 1).toLocaleString('default', { month: 'long' });
            $bulan.append(`<option value="${bulanNum}">${namaBulan}</option>`);
        }

        $tanggal.prop('disabled', true).empty().append('<option disabled selected hidden>Tanggal</option>');

        supplierTable.draw(); // filter ulang
    });

    $bulan.on('change', function () {
        populateTanggal();
        $tanggal.val('').prepend('<option disabled selected hidden>Tanggal</option>').prop('selectedIndex', 0);
        supplierTable.draw(); // filter ulang
    });

    $tanggal.on('change', function () {
        supplierTable.draw(); // filter ulang
    });
});

</script>
@endsection
