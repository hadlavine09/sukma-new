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

    <div class="checkout-container row">
        {{-- LEFT SIDE --}}
        <div class="col-lg-8">
            {{-- Alamat --}}
            <div class="checkout-left mb-3 position-relative">
                <button class="btn btn-outline-success btn-sm position-absolute top-0 end-0 mt-2 me-2" data-bs-toggle="modal"
                    data-bs-target="#modalAlamat">
                    Ubah Alamat
                </button>
                <div class="section-title">Alamat Pengiriman</div>
                <div>
                    <strong>Agung Wijaya</strong> | 085239935929<br>
                    Lemah Putro gang 3 RT02/RW02 Dr. Rina Untuk: Agung Wijaya <br>
                    Sidoarjo, Kec. Sidoarjo, 61213
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

                                    <textarea class="form-control produk-note mt-2" rows="1" placeholder="Tulis catatan ke penjual..."></textarea>
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
                        <option value="">Pilih Metode</option>
                        <option value="bank">Transfer Bank</option>
                        <option value="ewallet">E-Wallet</option>
                        <option value="cod">Bayar di Tempat</option>
                    </select>
                </div>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp<span id="subtotal">1.500.000</span></span>
                </div>

                <div class="summary-row">
                    <span>Proteksi Produk</span>
                    <span class="text-success">Rp44.444</span>
                </div>

                <div class="summary-row">
                    <span>Voucher</span>
                    <span class="text-danger">-Rp<span id="voucher-discount">0</span></span>
                </div>

                <div class="summary-row summary-total">
                    <span>Total Tagihan</span>
                    <span>Rp<span id="grandtotal">1.544.444</span></span>
                </div>

                <button class="checkout-btn mt-3">Pilih Pembayaran</button>
            </div>
        </div>
    </div>
<!-- Modal Pilih Alamat -->
<!-- Modal Pilih Alamat -->
<!-- Modal Pilih Alamat -->
<!-- Modal Pilih Alamat -->
<div class="modal fade" id="modalAlamat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAlamatLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-kecil">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header border-0">
        <h5 class="modal-title fw-semibold" id="modalAlamatLabel">Pilih Alamat Pengiriman</h5>
      </div>

      <!-- Body -->
      <div class="modal-body pt-0">

        <!-- Tombol Tambah Alamat -->
        <div class="mb-3">
          <button id="btnShowTambahAlamat" class="btn btn-outline-success w-100">+ Tambah Alamat Baru</button>
        </div>

        <!-- Daftar Alamat -->
        <div id="alamatListSection">
          <form id="formAlamat">
            <div class="form-check border p-3 rounded mb-3">
              <input class="form-check-input alamat-radio" type="radio" name="alamat" id="alamat1" value="1" checked>
              <label class="form-check-label w-100" for="alamat1">
                <strong>Agung Wijaya</strong> | 085239935929<br>
                Lemah Putro gang 3 RT02/RW02<br>
                Sidoarjo, Kec. Sidoarjo, 61213
              </label>
            </div>

            <div class="form-check border p-3 rounded mb-3">
              <input class="form-check-input alamat-radio" type="radio" name="alamat" id="alamat2" value="2">
              <label class="form-check-label w-100" for="alamat2">
                <strong>Budi Santoso</strong> | 081234567890<br>
                Jl. Melati No. 10<br>
                Surabaya, Kec. Tambaksari, 60133
              </label>
            </div>
          </form>
        </div>

        <!-- Form Tambah Alamat -->
        <div id="alamatFormSection" class="d-none">
          <div class="mb-3">
            <label for="newNama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="newNama" placeholder="Nama Lengkap">
          </div>

          <div class="mb-3">
            <label for="newHp" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" id="newHp" placeholder="Nomor Telepon">
          </div>

          <div class="mb-3">
            <label for="newAlamat" class="form-label">Alamat Lengkap</label>
            <textarea class="form-control" id="newAlamat" rows="3" placeholder="Nama Jalan, RT/RW, Kecamatan, Kode Pos, Kota, Provinsi"></textarea>
          </div>
        </div>

      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-between border-0">
        <button class="btn btn-light" data-bs-dismiss="modal" id="btnNantiSaja">Nanti Saja</button>
        <button class="btn btn-danger" id="btnSimpanAlamat">Simpan Alamat</button>
      </div>

    </div>
  </div>
</div>

<!-- Style Modal Responsive -->
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
  const btnShowTambahAlamat = document.getElementById('btnShowTambahAlamat');
  const alamatListSection = document.getElementById('alamatListSection');
  const alamatFormSection = document.getElementById('alamatFormSection');
  const btnNantiSaja = document.getElementById('btnNantiSaja');
  const btnSimpanAlamat = document.getElementById('btnSimpanAlamat');
  const alamatUtama = document.getElementById('alamatUtama'); // Elemen di luar modal untuk menampilkan alamat terpilih

  // Tampilkan form tambah alamat
  btnShowTambahAlamat.addEventListener('click', () => {
    alamatListSection.classList.add('d-none');
    alamatFormSection.classList.remove('d-none');
  });

  // Tombol 'Nanti Saja'
  btnNantiSaja.addEventListener('click', () => {
    alamatFormSection.classList.add('d-none');
    alamatListSection.classList.remove('d-none');
  });

  // Simpan alamat baru (simulasi)
  btnSimpanAlamat.addEventListener('click', () => {
    const nama = document.getElementById('newNama').value.trim();
    const hp = document.getElementById('newHp').value.trim();
    const alamatLengkap = document.getElementById('newAlamat').value.trim();

    if (!nama || !hp || !alamatLengkap) {
      alert('Mohon lengkapi semua field!');
      return;
    }

    // Buat ID unik
    const newId = `alamat${Date.now()}`;

    // Tambahkan ke daftar alamat (simulasi)
    const form = document.getElementById('formAlamat');
    const newDiv = document.createElement('div');
    newDiv.className = "form-check border p-3 rounded mb-3";
    newDiv.innerHTML = `
      <input class="form-check-input alamat-radio" type="radio" name="alamat" id="${newId}" value="${newId}">
      <label class="form-check-label w-100" for="${newId}">
        <strong>${nama}</strong> | ${hp}<br>
        ${alamatLengkap.replace(/\n/g, "<br>")}
      </label>
    `;
    form.appendChild(newDiv);

    // Reset form
    document.getElementById('newNama').value = '';
    document.getElementById('newHp').value = '';
    document.getElementById('newAlamat').value = '';

    // Kembali ke tampilan list
    alamatFormSection.classList.add('d-none');
    alamatListSection.classList.remove('d-none');

    // Set radio baru sebagai terpilih
    form.querySelectorAll('input[type=radio]').forEach(r => r.checked = false);
    newDiv.querySelector('input').checked = true;

    // Update tampilan di luar modal
    updateAlamatUtama();

    // Tutup modal
    const modalEl = document.getElementById('modalAlamat');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();
  });

  // Update tampilan alamat utama saat memilih radio
  function updateAlamatUtama() {
    const selectedRadio = document.querySelector('input[name="alamat"]:checked');
    if (!selectedRadio) return;

    const label = selectedRadio.nextElementSibling;
    if (label && alamatUtama) {
      alamatUtama.innerHTML = label.innerHTML;
    }
  }

  // Deteksi saat radio dipilih secara manual
  document.addEventListener('change', function (e) {
    if (e.target.classList.contains('alamat-radio')) {
      updateAlamatUtama();
    }
  });
</script>



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
            document.querySelectorAll('.produk-item').forEach(item => {
                const price = parseInt(item.querySelector('.price')?.dataset.price || 0);
                const qty = parseInt(item.querySelector('.qty-input')?.value || 0);
                subtotal += price * qty;
            });
            document.getElementById('subtotal').innerText = number_format(subtotal);
            const grand = subtotal + ongkir - voucherDiscount;
            document.getElementById('grandtotal').innerText = number_format(Math.max(grand, 0));
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


@endsection
