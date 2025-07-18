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
        <div class="widget-small shadow-sm" style="background-color: #007bff; color: white;"> {{-- chartColors[0] --}}
            <i class="icon bi bi-shop-window fs-1 text-white"></i>
            <div class="info">
                <h4>Total Toko</h4>
                <p><b>{{ $tokoData['total_toko'] }}</b></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-small shadow-sm" style="background-color: #17a2b8; color: white;"> {{-- chartColors[1] --}}
            <i class="icon bi bi-people-fill fs-1 text-white"></i>
            <div class="info">
                <h4>Total Pengguna</h4>
                <p><b>{{ $tokoData['total_pengguna'] }}</b></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-small shadow-sm" style="background-color: #28a745; color: white;"> {{-- chartColors[2] --}}
            <i class="icon bi bi-cash-stack fs-1 text-white"></i>
            <div class="info">
                <h4>Penghasilan Bulan Ini</h4>
                <p><b>Rp{{ number_format($tokoData['penghasilan_bulan_ini'], 0, ',', '.') }}</b></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-small shadow-sm" style="background-color: #dc3545; color: white;"> {{-- chartColors[3] --}}
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
                    <h3 class="tile-title">7 Toko Terlaris</h3>
                    <div class="ratio ratio-16x9">
                        <div id="chartTokoTerlaris"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">

            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">7 Kategori Produk Terlaris</h3>
                    <div class="ratio ratio-16x9">
                        <div id="chartKategoriTerlaris"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">7 Produk Terlaris</h3>
                    <div class="ratio ratio-16x9">
                        <div id="chartProdukTerlaris"></div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
@section('js_content')
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script>
        // Warna yang digunakan dalam chart sesuai dengan template (7 warna yang konsisten)
        const chartColors = [
            '#007bff', '#17a2b8', '#28a745', '#dc3545', '#ffc107', '#fd7e14', '#6f42c1'
        ];

        // Data Penghasilan 7 Hari
        const dataHari = @json(collect($tokoData['penghasilan_7_hari_chart'])->pluck('label'));
        const dataNilai = @json(collect($tokoData['penghasilan_7_hari_chart'])->pluck('value'));

        // Grafik Penghasilan 7 Hari (Bar Chart)
        const chartPenghasilan = echarts.init(document.getElementById('chartPenghasilan'));

        // Mengatur opsi chart
        chartPenghasilan.setOption({
            tooltip: {
                trigger: 'axis'
            },
            xAxis: {
                type: 'category',
                data: dataHari // Data untuk sumbu x (misalnya ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'])
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    formatter: function(value) {
                        return 'Rp' + value.toLocaleString(); // Format label y-axis dengan "Rp"
                    }
                }
            },
            series: [{
                data: dataNilai.map((value, index) => {
                    return {
                        value: value,
                        itemStyle: {
                            color: chartColors[index % chartColors
                                .length] // Set warna berbeda untuk setiap nilai
                        }
                    };
                }),
                type: 'bar'
            }]
        });

        // Grafik Toko Terlaris (Pie Chart)
        const tokoTerlarisData = @json($tokoData['toko_terlaris']);
        const chartTokoTerlaris = echarts.init(document.getElementById('chartTokoTerlaris'));
        chartTokoTerlaris.setOption({
            tooltip: {
                trigger: 'item',
                formatter: '{b} : {c} produk ({d}%)'
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: tokoTerlarisData.map(item => item.nama_toko)
            },
            series: [{
                type: 'pie',
                radius: ['40%', '70%'],
                data: tokoTerlarisData.map((item, index) => ({
                    value: item.total_terjual,
                    name: item.nama_toko,
                    itemStyle: {
                        color: chartColors[index % chartColors
                            .length] // Warna dinamis berdasarkan index
                    }
                })),
                label: {
                    show: false // ⛔ Sembunyikan label nama di luar pie
                },
                labelLine: {
                    show: false // ⛔ Sembunyikan garis penghubung label
                },
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.3)'
                    }
                }
            }]
        });

        // Data untuk Kategori Terlaris
        const kategoriNama = @json($tokoData['kategori_terlaris']->pluck('nama_kategori_produk'));
        const kategoriJumlah = @json($tokoData['kategori_terlaris']->pluck('total_terjual'));

        // Grafik 7 Kategori Produk Terlaris (Bar Chart)
        const chartKategoriTerlaris = echarts.init(document.getElementById('chartKategoriTerlaris'));
        chartKategoriTerlaris.setOption({
            tooltip: {
                trigger: 'axis'
            },
            xAxis: {
                type: 'category',
                data: kategoriNama // Nama kategori sebagai label X
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                type: 'bar',
                data: kategoriJumlah.map((value, index) => {
                    return {
                        value: value,
                        itemStyle: {
                            color: chartColors[index % chartColors
                                .length] // Warna berbeda untuk tiap bar
                        }
                    };
                })
            }]
        });


        // Grafik 7 Produk Terlaris (Pie Chart)
        const produkTerlarisData = @json($tokoData['produk_terlaris']);
        const chartProdukTerlaris = echarts.init(document.getElementById('chartProdukTerlaris'));

        chartProdukTerlaris.setOption({
            tooltip: {
                trigger: 'item',
                formatter: '{b} : {c} terjual ({d}%)'
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: produkTerlarisData.map(item => item.nama_produk)
            },
            series: [{
                type: 'pie',
                radius: ['40%', '70%'],
                data: produkTerlarisData.map((item, index) => ({
                    value: item.total_terjual,
                    name: item.nama_produk,
                    itemStyle: {
                        color: chartColors[index % chartColors.length]
                    }
                })),
                label: {
                    show: false // ⛔ Sembunyikan label nama di luar pie
                },
                labelLine: {
                    show: false // ⛔ Sembunyikan garis penghubung label
                },
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.3)'
                    }
                }
            }]
        });


        // Responsif: Menyesuaikan ukuran chart saat ukuran layar berubah
        [chartPenghasilan, chartTokoTerlaris, chartKategoriTerlaris, chartProdukTerlaris].forEach(chart => {
            new ResizeObserver(() => chart.resize()).observe(chart.getDom());
        });
    </script>
@endsection
