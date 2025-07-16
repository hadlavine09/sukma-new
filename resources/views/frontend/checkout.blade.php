@extends('frontend.component.main')

@section('contentfrontend')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --green: #2d5727;
            --light-bg: #fafafa;
            --gray: #555;
            --red: #e60000;
        }

        body {
            background: var(--light-bg);
        }

        .checkout-container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 15px;
        }

        .checkout-left {
            background: #fff;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .checkout-right {
            background: #fff;
            border-radius: 6px;
            padding: 20px;
        }

        .checkout-sticky {
            position: sticky;
            top: 20px;
        }

        .section-title {
            font-weight: 600;
            font-size: 16px;
            color: var(--green);
            margin-bottom: 15px;
        }

        .produk-seller-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 5px;
        }

        .produk-seller {
            font-weight: 600;
            font-size: 14px;
            color: var(--green);
        }

        .produk-location {
            font-size: 12px;
            color: var(--gray);
        }

        .btn-remove-seller {
            font-size: 20px;
            color: var(--red);
            background: none;
            border: none;
            line-height: 1;
            cursor: pointer;
        }

        .btn-remove-seller:hover {
            opacity: 0.8;
        }

        .produk-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            flex-wrap: wrap;
        }

        .produk-left {
            display: flex;
            flex: 1;
            gap: 12px;
            min-width: 0;
        }

        .produk-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .produk-info {
            font-size: 14px;
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 0;
        }

        .produk-header {
            display: flex;
            flex-direction: column;
        }

        .produk-name {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .produk-details {
            display: flex;
            gap: 20px;
            font-size: 13px;
            align-items: center;
            flex-wrap: wrap;
        }

        .produk-price {
            color: var(--red);
            font-weight: 600;
        }

        .qty-controls {
            display: inline-flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .qty-controls button {
            background: #f0f0f0;
            border: none;
            padding: 5px 10px;
        }

        .qty-controls input {
            width: 40px;
            text-align: center;
            border: none;
            font-size: 14px;
        }

        .produk-total {
            text-align: right;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
        }

        .produk-note {
            font-size: 13px;
            margin-top: 8px;
            width: 100%;
            resize: vertical;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .summary-total {
            font-weight: 600;
            font-size: 16px;
        }

        .checkout-btn {
            background: var(--green);
            color: #fff;
            border: none;
            padding: 12px 20px;
            width: 100%;
            border-radius: 6px;
            font-weight: 600;
        }

        .checkout-btn:hover {
            background: #22421f;
        }

        .btn-ubah {
            font-size: 12px;
            padding: 4px 8px;
        }

        @media (max-width: 767px) {
            .checkout-sticky {
                position: static;
            }

            .produk-details {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <form id="test">
        @csrf
        <div class="checkout-container row">
            {{-- LEFT SIDE --}}
            <div class="col-lg-8">
                {{-- Alamat --}}
                <div class="checkout-left mb-3 position-relative">
                    <button class="btn btn-outline-success btn-sm position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-toggle="modal" data-bs-target="#modalAlamat">
                        Ubah Alamat
                    </button>
                    <div class="section-title">Alamat Pengiriman</div>
                    <div>
                      <?php
                        foreach ($alamatList as $alamat) {
                            if ($alamat['is_utama']) {
                                echo '<div id="alamat-utama" data-alamat-id="' . $alamat['id'] . '">';
                                echo '<strong>' . htmlspecialchars($alamat['nama_penerima']) . '</strong> | ' . htmlspecialchars($alamat['no_hp']) . '<br>';
                                echo htmlspecialchars($alamat['alamat_lengkap']) . ' Untuk: ' . htmlspecialchars($alamat['nama_penerima']) . '<br>';
                                echo 'Sidoarjo, Kec. Sidoarjo, 61213';
                                echo '</div>';
                                break;
                            }
                        }
                        ?>

                    </div>

                </div>
                {{-- Produk Dipesan --}}
                <div class="checkout-left">
                    <div class="section-title">Produk Dipesan</div>

                    @foreach ($getprodukGrouped as $group)
                        @php
                            $toko = $group['toko'];
                            $cartList = $toko['cart'];
                            $gambarToko = $toko['gambar_toko'] ?? 'default-toko.jpg';
                        @endphp

                        <div class="mb-3 p-3 border rounded bg-white shadow-sm seller-container">
                            {{-- Toko --}}
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('storage/' . $gambarToko) }}" class="rounded-circle"
                                        style="width: 40px; height: 40px;">
                                    <div class="produk-seller fw-semibold text-success">{{ $toko['nama_toko'] }} ✅</div>
                                </div>
                                <button type="button"
                                    class="btn-remove-seller btn btn-sm btn-link text-danger fs-5">&times;</button>
                            </div>

                            {{-- Produk di toko ini --}}
                            @foreach ($cartList as $item)
                                @php
                                    $produk = $item['produk'];
                                    $harga = $item['harga_di_cart'];
                                    $qty = $item['quantity'];
                                    $stok = $produk['stok_produk'];
                                    $subtotal = $harga * $qty;
                                    $cartId = $item['cart_id'];
                                @endphp

                                <div class="produk-item d-flex flex-wrap gap-3">
                                    <img src="{{ asset('storage/' . $produk['gambar_produk']) }}" class="rounded"
                                        style="width: 70px; height: 70px;" alt="Produk">

                                    <div class="produk-info flex-grow-1">
                                        <div class="produk-header">
                                            <div class="produk-name fw-semibold mb-1">{{ $produk['nama_produk'] }}</div>

                                            <div
                                                class="produk-details d-flex flex-wrap align-items-center gap-3 small text-muted mb-2">
                                                <span class="produk-price fw-bold text-success">
                                                    Rp<span class="price"
                                                        data-price="{{ $harga }}">{{ number_format($harga, 0, ',', '.') }}</span>
                                                </span>

                                                <div
                                                    class="qty-controls d-inline-flex align-items-center border rounded overflow-hidden">
                                                    <button type="button" class="minus btn btn-sm btn-light">-</button>
                                                    <input type="text" class="qty-input border-0 text-center"
                                                        data-id="{{ $cartId }}" data-stok="{{ $stok }}"
                                                        value="{{ $qty }}" style="width: 40px;" readonly>
                                                    <button type="button" class="plus btn btn-sm btn-light">+</button>
                                                </div>

                                                <span class="badge bg-success text-white">Stok: {{ $stok }}</span>
                                            </div>
                                            <div class="text-muted small">
                                                <span>Ukuran: <strong>{{ $item['ukuran'] ?? '-' }}</strong></span> |
                                                <span>Warna: <strong>{{ $item['warna'] ?? '-' }}</strong></span> |
                                                <span>Bahan: <strong>{{ $item['bahan'] ?? '-' }}</strong></span>
                                            </div>
                                        </div>
                                        <textarea class="form-control produk-note mt-2"
                                            rows="1"
                                            placeholder="Tulis catatan ke penjual..."
                                            data-cart-id="{{ $cartId }}"></textarea>
                                    </div>

                                    <div class="produk-total text-end ms-auto">
                                        <div class="fw-semibold text-success">Total</div>
                                        <div class="fw-bold text-success">Rp<span class="total"
                                                data-id="{{ $cartId }}">{{ number_format($subtotal, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>





            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-4">
                <div class="checkout-right checkout-sticky">
                    <div class="section-title">Ringkasan Belanja</div>

                    <div class="mb-3">
                        <label class="form-label">Kode Voucher</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="voucher-code" placeholder="kode voucher">
                            <button class="btn btn-outline-success" id="apply-voucher">Terapkan</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="payment-method">
                            <option selected disabled hidden>Pilih Metode Pembayaran</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="cod">Bayar di Tempat</option>
                        </select>
                    </div>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp<span id="subtotal">0</span></span>
                    </div>

                    <div class="summary-row">
                        <span>Total Biaya Admin Desa</span>
                        <span>Rp<span id="biaya-admin">0</span></span>
                    </div>

                    <div class="summary-row">
                        <span>Total Biaya Pengiriman</span>
                        <span>Rp<span id="biaya-ongkir">0</span></span>
                    </div>

                    <div class="summary-row">
                        <span>Voucher</span>
                        <span class="text-danger">-Rp<span id="voucher-discount">0</span></span>
                    </div>

                    <div class="summary-row summary-total">
                        <span>Total Tagihan</span>
                        <span>Rp<span id="grandtotal">0</span></span>
                    </div>




                    <button class="checkout-btn mt-3">Bayar sekarang</button>
                </div>
            </div>

        </div>
    </form>
<!-- Modal Input Uang -->
<div class="modal fade" id="modalInputUang" tabindex="-1" aria-labelledby="modalInputUangLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalInputUangLabel">Masukkan Jumlah Uang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="jumlah-uang" class="form-control" placeholder="Masukkan nominal pembayaran">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="submit-uang">Kirim Pembayaran</button>
      </div>
    </div>
  </div>
</div>

    <!-- Modal Buat Alamat Pertama -->
    <div class="modal fade" id="modalBuatAlamatPertama" tabindex="-1" aria-labelledby="modalBuatAlamatPertamaLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBuatAlamatPertamaLabel">Buat Alamat Pertama Anda</h5>
                    <!-- Tidak ada tombol X -->
                </div>
                <div class="modal-body">
                    <form id="formAlamatPertama" method="POST" action="{{ route('alamat.store') }}">
                        @csrf

                        <!-- Nama Penerima -->
                        <div class="mb-3">
                            <label for="namaPenerima" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" id="namaPenerima" name="nama_penerima" required>
                        </div>

                        <!-- Nomor HP dengan +62 -->
                        <div class="mb-3">
                            <label for="noHp" class="form-label">No. HP</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="text" class="form-control" maxlength="15" id="noHp" name="no_hp"
                                    required placeholder="812xxxxxxx"
                                    oninput="this.value = this.value.replace(/[^0-9]/g,'').replace(/^0+/, '')">
                            </div>
                        </div>
                        <!-- Nama Alamat -->
                        <div class="mb-3">
                            <label for="namaAlamat" class="form-label">Nama Alamat</label>
                            <select class="form-select" id="namaAlamat" name="nama_alamat" required>
                                <option selected disabled hidden>-- Pilih Nama Alamat --</option>
                                <option value="Rumah">Rumah</option>
                                <option value="Kantor">Kantor</option>
                                <option value="Apartemen">Apartemen</option>
                                <option value="Kos">Kos</option>
                                <option value="Gudang">Gudang</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="mb-3">
                            <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamatLengkap" name="alamat_lengkap" rows="3" required></textarea>
                        </div>


                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Simpan Alamat</button>
                            <a href="{{ route('frontend.keranjang') }}" class="btn btn-outline-secondary">Nanti Saja</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <!-- Modal Alamat -->
    <div class="modal fade" id="modalAlamat" tabindex="-1" aria-labelledby="modalAlamatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-kecil">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="modalAlamatLabel">Pilih Alamat Pengiriman</h5>
                </div>

                <div class="modal-body pt-0">
                    <!-- List Alamat -->
                    <div id="alamatListSection">
                        <form id="formAlamat">
                            @php
                                $utama = $alamatList->where('is_utama', true)->first();
                                $lainnya = $alamatList->where('is_utama', false);
                            @endphp

                            @if ($utama)
                                <div class="form-check border p-3 rounded mb-3 bg-light position-relative">
                                    <input class="form-check-input alamat-radio" type="radio" name="alamat"
                                        id="alamat{{ $utama->id }}" value="{{ $utama->id }}" checked>
                                    <label class="form-check-label w-100" for="alamat{{ $utama->id }}">
                                        <strong>{{ $utama->nama_alamat }}</strong>
                                        <span class="badge bg-success ms-2">Utama</span><br>
                                        {{ $utama->nama_penerima }} | {{ $utama->no_hp }}<br>
                                        {{ $utama->alamat_lengkap }}
                                    </label>
                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary me-1 btn-edit-alamat"
                                            data-id="{{ $utama->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @foreach ($lainnya as $alamat)
                                <div class="form-check border p-3 rounded mb-3 position-relative">
                                    <input class="form-check-input alamat-radio" type="radio" name="alamat"
                                        id="alamat{{ $alamat->id }}" value="{{ $alamat->id }}">
                                    <label class="form-check-label w-100" for="alamat{{ $alamat->id }}">
                                        <strong>{{ $alamat->nama_alamat }}</strong><br>
                                        {{ $alamat->nama_penerima }} | {{ $alamat->no_hp }}<br>
                                        {{ $alamat->alamat_lengkap }}
                                    </label>
                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary me-1 btn-edit-alamat"
                                            data-id="{{ $alamat->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-alamat"
                                            data-id="{{ $alamat->id }}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                    </div>

                    <!-- Form Tambah/Edit Alamat -->
                    <div id="alamatFormSection" class="d-none">
                        <input type="hidden" id="alamatId">
                        <div class="mb-3">
                            <label for="newNama" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" id="newNama">
                        </div>
                        <div class="mb-3">
                            <label for="newHp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="newHp">
                        </div>
                        <div class="mb-3">
                            <label for="newNamaAlamat" class="form-label">Nama Alamat</label>
                            <select class="form-select" id="newNamaAlamat">
                                <option selected disabled hidden>-- Pilih Nama Alamat --</option>
                                <option value="Rumah">Rumah</option>
                                <option value="Kantor">Kantor</option>
                                <option value="Apartemen">Apartemen</option>
                                <option value="Kos">Kos</option>
                                <option value="Gudang">Gudang</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="newAlamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="newAlamat" rows="3"></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-light" data-bs-dismiss="modal" id="btnBatalTambah">Nanti Saja</button>
                            <button class="btn btn-danger" type="button" id="btnSimpanAlamat">Simpan Alamat</button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between border-0">
                    <button class="btn btn-light" data-bs-dismiss="modal" id="btnTutupModal">Nanti Saja</button>
                    <button id="btnShowTambahAlamat" class="btn btn-outline-success">+ Tambah Alamat Baru</button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Ambil data dari PHP ke JS
        var alamatList = @json($alamatList);

        // Kalau kosong, panggil modal
        if (alamatList.length === 0) {
            var modal = new bootstrap.Modal(document.getElementById('modalBuatAlamatPertama'));
            modal.show();
        }

        // Tangkap form submit
        document.getElementById('formAlamatPertama').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Terjadi kesalahan.');
                    }
                    return response.json(); // Controller harus return JSON
                })
                .then(data => {
                    // Redirect kalau sukses
                    window.location.reload();
                })
                .catch(error => {
                    alert('Gagal menyimpan alamat.');
                    console.error(error);
                });
        });
    </script>

    <script>
        $('#modalAlamat').on('shown.bs.modal', function() {
            $('#alamatId').val('');
            $('#alamatFormSection').addClass('d-none');
            $('#alamatListSection').removeClass('d-none');
            $('#btnShowTambahAlamat').removeClass('d-none');
            $('#btnTutupModal').removeClass('d-none');
            $('#modalAlamatLabel').text('Pilih Alamat Pengiriman');

            $('#newNama').val('');
            $('#newHp').val('');
            $('#newNamaAlamat').val('');
            $('#newAlamat').val('');
        });

        $('#btnShowTambahAlamat').on('click', () => {
            $('#alamatId').val('');
            $('#alamatFormSection').removeClass('d-none');
            $('#alamatListSection').addClass('d-none');
            $('#btnShowTambahAlamat').addClass('d-none');
            $('#btnTutupModal').addClass('d-none');
            $('#modalAlamatLabel').text('Tambah Alamat Baru');
        });

        $('#btnBatalTambah').on('click', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAlamat'));
            if (modal) modal.hide();
            setTimeout(() => $('#modalAlamat').modal('show'), 300);
        });

        $('#btnSimpanAlamat').on('click', function() {
            const id = $('#alamatId').val();
            const namaAlamat = $('#newNamaAlamat').val()?.trim();
            const nama = $('#newNama').val()?.trim();
            const hp = $('#newHp').val()?.trim();
            const alamat = $('#newAlamat').val()?.trim();

            if (!namaAlamat || !nama || !hp || !alamat) {
                alert('Mohon lengkapi semua field!');
                return;
            }

            const isEdit = !!id;
            const url = isEdit ?
                '{{ route('alamat.update', ':id') }}'.replace(':id', id) :
                '{{ route('alamat.store') }}';

            const method = 'POST'; // AJAX tetap POST
            const data = {
                nama_alamat: namaAlamat,
                nama_penerima: nama,
                no_hp: hp,
                alamat_lengkap: alamat,
                _token: '{{ csrf_token() }}'
            };
            if (isEdit) data._method = 'PUT';

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: res => res.success ? location.reload() : alert(res.message || 'Gagal menyimpan.'),
                error: () => alert('Terjadi kesalahan saat menyimpan.')
            });
        });


        $(document).on('change', '.alamat-radio', function() {
            const id = $(this).val();
            $.ajax({
                url: '{{ route('alamat.updateutama', ':id') }}'.replace(':id', id),
                method: 'POST',
                data: {
                    is_utama: true,
                    _token: '{{ csrf_token() }}'
                },
                success: res => res.success ? location.reload() : alert(res.message),
                error: () => alert('Gagal menghubungi server.')
            });
        });

        $(document).on('click', '.btn-delete-alamat', function() {
            const id = $(this).data('id');

            if (confirm('Yakin ingin menghapus alamat ini?')) {
                $.ajax({
                    url: '{{ route('alamat.destroy', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            location.reload();
                        } else {
                            alert(res.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus alamat: ' + (xhr.responseJSON?.message || ''));
                        console.error(xhr.responseText);
                    }
                });
            }
        });


        $(document).on('click', '.btn-edit-alamat', function() {
            const id = $(this).data('id');

            $.ajax({
                url: '{{ route('alamat.show', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(res) {
                    if (res.success && res.data) {
                        const data = res.data;

                        $('#alamatId').val(data.id);
                        $('#newNama').val(data.nama_penerima);
                        $('#newHp').val(data.no_hp);
                        $('#newNamaAlamat').val(data.nama_alamat);
                        $('#newAlamat').val(data.alamat_lengkap);

                        $('#alamatListSection').addClass('d-none');
                        $('#alamatFormSection').removeClass('d-none');
                        $('#btnShowTambahAlamat').addClass('d-none');
                        $('#btnTutupModal').addClass('d-none');
                        $('#modalAlamatLabel').text('Edit Alamat');
                    } else {
                        alert('Gagal memuat data alamat.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data alamat.');
                }
            });
        });
    </script>

    <style>
        .modal-kecil {
            max-width: 500px;
            margin: auto;
        }

        @media (max-width: 576px) {
            .modal-kecil {
                max-width: 95% !important;
            }

            .modal-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>




    <script>
        const csrfToken = '{{ csrf_token() }}';
        let voucherDiscount = 0;
        const ongkir = 44444;

        const number_format = x =>
            isNaN(x) ? '0' : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        function updateQtyText(id, qty) {
            const totalEl = document.querySelector(`.total[data-id="${id}"]`);
            const price = parseInt(document.querySelector(`.qty-input[data-id="${id}"]`)?.closest('.produk-item')
                ?.querySelector('.price')?.dataset.price || 0);
            if (totalEl) totalEl.innerText = number_format(price * qty);
        }

        function updateCart(id, qty) {
            const input = document.querySelector(`.qty-input[data-id="${id}"]`);
            input.disabled = true;
            fetch("{{ route('frontend.cartupdate') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id,
                        jumlah: qty
                    })
                })
                .then(res => {
                    if (!res.ok) throw new Error("Gagal update");
                })
                .catch(() => alert("Gagal mengupdate keranjang"))
                .finally(() => input.disabled = false);
        }


        function updateSubtotal() {
            let subtotal = 0;

            // Hitung subtotal
            document.querySelectorAll('.produk-item').forEach(item => {
                const price = parseInt(item.querySelector('.price')?.dataset.price || 0);
                const qty = parseInt(item.querySelector('.qty-input')?.value || 0);
                subtotal += price * qty;
            });

            // Biaya Admin = 10% dari subtotal
            const totalBiayaAdmin = Math.round(subtotal * 0.10);

            // Biaya Pengiriman = 2% dari subtotal
            const totalOngkir = Math.round(subtotal * 0.02);

            // Grand total = subtotal + admin + ongkir
            const grandTotal = subtotal + totalBiayaAdmin + totalOngkir;

            // Tampilkan hasil ke DOM
            document.getElementById('subtotal').innerText = number_format(subtotal);
            document.getElementById('biaya-admin').innerText = number_format(totalBiayaAdmin);
            document.getElementById('biaya-ongkir').innerText = number_format(totalOngkir);
            document.getElementById('grandtotal').innerText = number_format(grandTotal);
        }


        function initQtyControls() {
            document.querySelectorAll('.qty-controls').forEach(control => {
                const minus = control.querySelector('.minus');
                const plus = control.querySelector('.plus');
                const input = control.querySelector('.qty-input');
                const id = input.dataset.id;
                const stok = parseInt(input.dataset.stok || 0);

                minus.addEventListener('click', () => {
                    let qty = parseInt(input.value) || 1;
                    if (qty > 1) {
                        input.value = --qty;
                        updateQtyText(id, qty);
                        updateCart(id, qty);
                        updateSubtotal();
                    }
                });

                plus.addEventListener('click', () => {
                    let qty = parseInt(input.value) || 1;
                    if (qty < stok) {
                        input.value = ++qty;
                        updateQtyText(id, qty);
                        updateCart(id, qty);
                        updateSubtotal();
                    } else {
                        alert(`Maksimal pembelian hanya ${stok} item.`);
                    }
                });
            });
        }

        function initVoucher() {
            document.getElementById('apply-voucher')?.addEventListener('click', () => {
                const code = document.getElementById('voucher-code')?.value.trim().toUpperCase();
                if (code === 'POTONG50') {
                    voucherDiscount = 50000;
                    alert('Voucher berhasil diterapkan!');
                } else {
                    voucherDiscount = 0;
                    alert('Voucher tidak valid.');
                }
                document.getElementById('voucher-discount').innerText = number_format(voucherDiscount);
                updateSubtotal();
            });
        }

        function initRemoveSeller() {
            document.querySelectorAll('.btn-remove-seller').forEach(btn => {
                btn.addEventListener('click', () => {
                    const box = btn.closest('.seller-container');
                    if (box) box.remove();
                    updateSubtotal();
                });
            });
        }


        document.addEventListener('DOMContentLoaded', () => {
            initQtyControls();
            initVoucher();
            initRemoveSeller();
            updateSubtotal();
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    const checkoutButton = $('.checkout-btn');
    const submitUangButton = $('#submit-uang');
    const inputUang = $('#jumlah-uang');

    let alamatId = null;
    let cartIds = [];
    let catatan = {};
    let metodePembayaran = '';
    let catatanUmum = null;

    function formatRupiah(angka) {
        return angka.replace(/\D/g, '')
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function getAngkaBersih(str) {
        return str.replace(/\./g, '');
    }

    inputUang.on('input', function () {
        const angka = getAngkaBersih($(this).val());
        $(this).val(formatRupiah(angka));
    });

    checkoutButton.on('click', function (e) {
        e.preventDefault();

        const alamatElement = $('#alamat-utama');
        alamatId = alamatElement.data('alamat-id') || null;
        if (!alamatId) return alert('Alamat utama tidak ditemukan!');

        cartIds = [];
        catatan = {};

        $('.qty-input').each(function () {
            const id = $(this).data('id');
            if (id) {
                cartIds.push(id);
                const note = $(this).closest('.produk-item').find('.produk-note').val()?.trim() || null;
                catatan[id] = note;
            }
        });

        if (!cartIds.length) return alert('Keranjang kosong!');

        metodePembayaran = $('#payment-method').val();
        if (!metodePembayaran) return alert('Pilih metode pembayaran!');

        catatanUmum = $('#catatan-umum').val()?.trim() || null;

        if (metodePembayaran === 'cod') {
            // Langsung kirim AJAX tanpa input uang
            kirimTransaksi(null);
        } else {
            // Tampilkan modal input uang jika metode transfer
            $('#modalInputUang').modal('show');
        }
    });

    submitUangButton.on('click', function () {
        const jumlahUangRaw = inputUang.val();
        const jumlahUang = parseInt(getAngkaBersih(jumlahUangRaw), 10);

        if (!jumlahUang || isNaN(jumlahUang) || jumlahUang <= 0) {
            return Swal.fire('Error', 'Masukkan jumlah uang yang valid!', 'error');
        }

        kirimTransaksi(jumlahUang);
    });

    function kirimTransaksi(jumlahUang) {
        $.ajax({
            url: "{{ route('transaksi.store') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({
                alamat_id: alamatId,
                cart_ids: cartIds,
                catatan: catatan,
                metode_pembayaran: metodePembayaran,
                catatan_umum: catatanUmum,
                jumlah_uang: jumlahUang // null jika cod
            }),
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil',
                        text: response.message || 'Transaksi sukses!',
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = response.redirect_url || '/';
                    });
                } else {
                    Swal.fire('Gagal', response.message || 'Terjadi kesalahan saat transaksi.', 'error');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire('Error', 'Terjadi kesalahan server.', 'error');
            }
        });
    }
});
</script>





@endsection
