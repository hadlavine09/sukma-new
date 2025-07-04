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
    <button class="btn btn-outline-success btn-sm position-absolute top-0 end-0 mt-2 me-2" data-bs-toggle="modal" data-bs-target="#modalAlamat">
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

            {{-- Produk --}}
            @foreach ([
                ['name' => "Smart Cell's", 'location' => 'Jakarta Barat'],
                ['name' => "Gadget Mart", 'location' => 'Bandung'],
                ['name' => "Tech Store", 'location' => 'Surabaya'],
                ['name' => "Electro Shop", 'location' => 'Medan'],
                ['name' => "Mobile Hub", 'location' => 'Yogyakarta'],
            ] as $key => $seller)
                @php $price = 200000 * ($key + 1); @endphp
                <div class="mb-2 seller-container">
                    <div class="produk-seller-row">
                        <div>
                            <div class="produk-seller">{{ $seller['name'] }} ✅</div>
                            <div class="produk-location">{{ $seller['location'] }}</div>
                        </div>
                        <button type="button" class="btn-remove-seller">&times;</button>
                    </div>
                    <div class="produk-item">
                        <div class="produk-left">
                            <img src="https://picsum.photos/seed/toko{{ $key }}/70" alt="Produk">
                            <div class="produk-info">
                                <div class="produk-header">
                                    <span class="produk-name">Produk Dummy {{ $key + 1 }}</span>
                                    <div class="produk-details">
                                        <span class="text-muted">Warna: Hitam</span>
                                        <span class="produk-price">Rp<span class="price" data-price="{{ $price }}">{{ number_format($price, 0, ',', '.') }}</span></span>
                                        <div class="qty-controls" data-key="{{ $key }}">
                                            <button type="button" class="minus">-</button>
                                            <input type="text" class="qty-input" value="1" readonly>
                                            <button type="button" class="plus">+</button>
                                        </div>
                                        <span class="text-muted">(500 gr)</span>
                                    </div>
                                </div>
                                <textarea class="form-control produk-note" rows="1" placeholder="Tulis catatan ke penjual..."></textarea>
                            </div>
                        </div>
                        <div class="produk-total">
                            Total<br>
                            Rp<span class="total">{{ number_format($price, 0, ',', '.') }}</span>
                        </div>
                    </div>
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
{{-- Modal Alamat --}}
<div class="modal fade" id="modalAlamat" tabindex="-1" aria-labelledby="modalAlamatLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            {{-- HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title" id="modalAlamatLabel">Pilih Alamat Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY: Daftar Alamat --}}
            <div class="modal-body" id="alamatListSection">
                <div class="list-group mb-3">
                    @for ($a = 1; $a <= 3; $a++)
                        <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Alamat Dummy {{ $a }}</div>
                                Jl. Contoh Nomor {{ $a }}, Kota Contoh
                            </div>
                            <input class="form-check-input ms-2" type="radio" name="alamat_terpilih" value="alamat{{ $a }}">
                        </label>
                    @endfor
                </div>
                <button class="btn btn-outline-success btn-sm" id="btnShowTambahAlamat">+ Tambah Alamat</button>
            </div>

            {{-- BODY: Form Tambah Alamat --}}
            <div class="modal-body d-none" id="alamatFormSection">
                <div class="mb-3">
                    <label class="form-label">Nama Penerima</label>
                    <input type="text" class="form-control" id="newNama">
                </div>
                <div class="mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" class="form-control" id="newHp">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" rows="2" id="newAlamat"></textarea>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm d-none" id="btnBatalAlamat">Batal</button>
                <button class="btn btn-success btn-sm" id="btnSimpanAlamat">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    const alamatList = document.getElementById('alamatListSection');
    const alamatForm = document.getElementById('alamatFormSection');
    const btnShowTambah = document.getElementById('btnShowTambahAlamat');
    const btnBatal = document.getElementById('btnBatalAlamat');
    const btnSimpan = document.getElementById('btnSimpanAlamat');

    btnShowTambah.addEventListener('click', () => {
        alamatList.classList.add('d-none');
        alamatForm.classList.remove('d-none');
        btnShowTambah.classList.add('d-none');
        btnBatal.classList.remove('d-none');
    });

    btnBatal.addEventListener('click', () => {
        alamatForm.classList.add('d-none');
        alamatList.classList.remove('d-none');
        btnShowTambah.classList.remove('d-none');
        btnBatal.classList.add('d-none');
    });

    btnSimpan.addEventListener('click', () => {
        if (!alamatForm.classList.contains('d-none')) {
            const nama = document.getElementById('newNama').value.trim();
            const hp = document.getElementById('newHp').value.trim();
            const alamat = document.getElementById('newAlamat').value.trim();

            if (nama && hp && alamat) {
                alert(`Alamat baru disimpan:\n${nama} | ${hp}\n${alamat}`);
                // Reset form
                document.getElementById('newNama').value = '';
                document.getElementById('newHp').value = '';
                document.getElementById('newAlamat').value = '';
                // Tutup modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalAlamat'));
                modal.hide();
                // Kembalikan tampilan
                alamatForm.classList.add('d-none');
                alamatList.classList.remove('d-none');
                btnShowTambah.classList.remove('d-none');
                btnBatal.classList.add('d-none');
            } else {
                alert('Mohon lengkapi semua field!');
            }
        } else {
            // Tutup modal kalau pilih dari list
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAlamat'));
            modal.hide();
        }
    });
</script>

<script>
    let voucherDiscount = 0;

    document.querySelectorAll('.qty-controls').forEach(control => {
        const minus = control.querySelector('.minus');
        const plus = control.querySelector('.plus');
        const input = control.querySelector('.qty-input');
        const item = control.closest('.produk-item');
        const price = parseInt(item.querySelector('.price').dataset.price);
        const total = item.querySelector('.total');

        minus.addEventListener('click', () => {
            let qty = parseInt(input.value);
            if (qty > 1) {
                qty--;
                input.value = qty;
                total.innerText = number_format(price * qty);
                updateSubtotal();
            }
        });

        plus.addEventListener('click', () => {
            let qty = parseInt(input.value);
            qty++;
            input.value = qty;
            total.innerText = number_format(price * qty);
            updateSubtotal();
        });
    });

    document.querySelectorAll('.btn-remove-seller').forEach(btn => {
        btn.addEventListener('click', () => {
            const sellerContainer = btn.closest('.seller-container');
            sellerContainer.remove();
            updateSubtotal();
        });
    });

    document.getElementById('apply-voucher').addEventListener('click', () => {
        const code = document.getElementById('voucher-code').value.trim();
        if (code.toUpperCase() === 'POTONG50') {
            voucherDiscount = 50000;
            alert('Voucher berhasil diterapkan!');
        } else {
            voucherDiscount = 0;
            alert('Voucher tidak valid.');
        }
        document.getElementById('voucher-discount').innerText = number_format(voucherDiscount);
        updateSubtotal();
    });

    function updateSubtotal() {
        let subtotal = 0;
        document.querySelectorAll('.produk-item').forEach(item => {
            const price = parseInt(item.querySelector('.price').dataset.price);
            const qty = parseInt(item.querySelector('.qty-input').value);
            subtotal += price * qty;
        });
        document.getElementById('subtotal').innerText = number_format(subtotal);
        const grand = subtotal + 44444 - voucherDiscount;
        document.getElementById('grandtotal').innerText = number_format(Math.max(grand, 0));
    }

    function number_format(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
@endsection
