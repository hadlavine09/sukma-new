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
      <div class="widget-small coloured-icon shadow-sm" style="background-color: #007bff; color: white;">
        <i class="icon bi bi-shop-window fs-1 text-white"></i>
        <div class="info">
          <h4>Total Toko</h4>
          <p><b>{{ $tokoData['total_toko'] }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small coloured-icon shadow-sm" style="background-color: #17a2b8; color: white;">
        <i class="icon bi bi-people-fill fs-1 text-white"></i>
        <div class="info">
          <h4>Total Pengguna</h4>
          <p><b>{{ $tokoData['total_pengguna'] }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small coloured-icon shadow-sm" style="background-color: #28a745; color: white;">
        <i class="icon bi bi-cash-stack fs-1 text-white"></i>
        <div class="info">
          <h4>Penghasilan Bulan Ini</h4>
          <p><b>Rp{{ number_format($tokoData['penghasilan_bulan_ini'], 0, ',', '.') }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small coloured-icon shadow-sm" style="background-color: #dc3545; color: white;">
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
        <h3 class="tile-title">Penghasilan 7 Hari Semua Toko</h3>
        <div class="ratio ratio-16x9">
          <div id="chartPenghasilan"></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Produk Disukai Terbanyak</h3>
        <div class="ratio ratio-16x9">
          <div id="chartLikesProduk"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Kategori Produk Terjual</h3>
        <div class="ratio ratio-16x9">
          <div id="chartKategoriProduk"></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Status Transaksi</h3>
        <div class="ratio ratio-16x9">
          <div id="chartTransaksiStatus"></div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

@section('js_content')
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
<script>
  const chartPenghasilan = echarts.init(document.getElementById('chartPenghasilan'));
  chartPenghasilan.setOption({
    xAxis: { type: 'category', data: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] },
    yAxis: { type: 'value', axisLabel: { formatter: 'Rp{value}' } },
    tooltip: { trigger: 'axis' },
    series: [{
      data: @json($tokoData['penghasilan_7_hari_toko']),
      type: 'line',
      smooth: true,
      itemStyle: { color: '#28a745' }
    }]
  });

  const chartLikesProduk = echarts.init(document.getElementById('chartLikesProduk'));
  chartLikesProduk.setOption({
    tooltip: { trigger: 'item' },
    legend: { orient: 'vertical', left: 'left' },
    series: [{
      type: 'pie',
      radius: '60%',
      data: @json($tokoData['produk_likes_top']),
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        }
      }
    }]
  });

  const chartKategoriProduk = echarts.init(document.getElementById('chartKategoriProduk'));
  chartKategoriProduk.setOption({
    xAxis: { type: 'category', data: @json(collect($tokoData['kategori_terjual'])->pluck('name')) },
    yAxis: { type: 'value' },
    tooltip: { trigger: 'axis' },
    series: [{
      data: @json(collect($tokoData['kategori_terjual'])->pluck('value')),
      type: 'bar',
      itemStyle: { color: '#ffc107' }
    }]
  });

  const chartTransaksiStatus = echarts.init(document.getElementById('chartTransaksiStatus'));
  chartTransaksiStatus.setOption({
    tooltip: { trigger: 'item' },
    series: [{
      type: 'pie',
      radius: ['40%', '70%'],
      data: @json($tokoData['transaksi_status']),
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.3)'
        }
      }
    }]
  });

  [chartPenghasilan, chartLikesProduk, chartKategoriProduk, chartTransaksiStatus].forEach(chart => {
    new ResizeObserver(() => chart.resize()).observe(chart.getDom());
  });
</script>
@endsection
