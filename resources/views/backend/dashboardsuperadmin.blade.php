@extends('backend.component.main')

@section('content')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-bar-chart-line-fill"></i> Dashboard Superadmin</h1>
      <p>Statistik keseluruhan sistem marketplace</p>
    </div>
  </div>

  {{-- Widget Statistik --}}
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small shadow-sm" style="background-color: #007bff; color: white;">
        <i class="icon bi bi-shop-window fs-1 text-white"></i>
        <div class="info">
          <h4>Total Toko</h4>
          <p><b>{{ $tokoData['total_toko'] }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small shadow-sm" style="background-color: #17a2b8; color: white;">
        <i class="icon bi bi-people-fill fs-1 text-white"></i>
        <div class="info">
          <h4>Total Pengguna</h4>
          <p><b>{{ $tokoData['total_pengguna'] }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small shadow-sm" style="background-color: #28a745; color: white;">
        <i class="icon bi bi-cash-stack fs-1 text-white"></i>
        <div class="info">
          <h4>Penghasilan Bulan Ini</h4>
          <p><b>Rp{{ number_format($tokoData['penghasilan_bulan_ini'], 0, ',', '.') }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small shadow-sm" style="background-color: #dc3545; color: white;">
        <i class="icon bi bi-cart-check-fill fs-1 text-white"></i>
        <div class="info">
          <h4>Total Transaksi</h4>
          <p><b>{{ $tokoData['total_transaksi_semua_toko'] }}</b></p>
        </div>
      </div>
    </div>
  </div>

  {{-- Grafik --}}
  <div class="row mt-4">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Penghasilan 7 Hari Terakhir</h3>
        <div class="ratio ratio-16x9">
          <div id="chartPenghasilan"></div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Toko Terlaris</h3>
        <div class="ratio ratio-16x9">
          <div id="chartTokoTerlaris"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">7 Kategori Produk Terlaris</h3>
        <div class="ratio ratio-16x9">
          <div id="chartKategoriTerlaris"></div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

@section('js_content')
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
<script>
  // Data Penghasilan 7 Hari
  const dataHari = @json(collect($tokoData['penghasilan_7_hari_chart'])->pluck('label'));
  const dataNilai = @json(collect($tokoData['penghasilan_7_hari_chart'])->pluck('value'));

  const chartPenghasilan = echarts.init(document.getElementById('chartPenghasilan'));
  chartPenghasilan.setOption({
    tooltip: { trigger: 'axis' },
    xAxis: {
      type: 'category',
      data: dataHari
    },
    yAxis: {
      type: 'value',
      axisLabel: {
        formatter: function (value) {
          return 'Rp' + value.toLocaleString();
        }
      }
    },
    series: [{
      data: dataNilai,
      type: 'bar',
      itemStyle: {
        color: '#28a745'
      }
    }]
  });

  // Grafik Toko Terlaris (Pie Chart)
  const chartTokoTerlaris = echarts.init(document.getElementById('chartTokoTerlaris'));
  chartTokoTerlaris.setOption({
    tooltip: { trigger: 'item' },
    series: [{
      type: 'pie',
      radius: '60%',
      data: [{
        name: @json($tokoData['toko_terlaris']->nama_toko ?? 'Tidak Ada'),
        value: @json($tokoData['toko_terlaris']->total_terjual ?? 0)
      }],
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        }
      }
    }]
  });

  // Grafik 7 Kategori Produk Terlaris
  const chartKategoriTerlaris = echarts.init(document.getElementById('chartKategoriTerlaris'));
  chartKategoriTerlaris.setOption({
    tooltip: { trigger: 'axis' },
    xAxis: {
      type: 'category',
      data: @json($tokoData['kategori_terlaris']->pluck('nama_kategori_produk'))
    },
    yAxis: {
      type: 'value'
    },
    series: [{
      data: @json($tokoData['kategori_terlaris']->pluck('total_terjual')),
      type: 'bar',
      itemStyle: {
        color: '#ffc107'
      }
    }]
  });

  // Responsive
  [chartPenghasilan, chartTokoTerlaris, chartKategoriTerlaris].forEach(chart => {
    new ResizeObserver(() => chart.resize()).observe(chart.getDom());
  });
</script>
@endsection
