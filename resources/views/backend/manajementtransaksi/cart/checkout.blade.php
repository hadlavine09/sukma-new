@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-credit-card"></i> Checkout</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Transaksi</li>
            <li class="breadcrumb-item active"><a href="#">Checkout</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    {{-- Alert --}}
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- Form Checkout --}}
                    <form action="{{ route('cart.checkoutstore') }}" method="POST">
                        @csrf

                        {{-- Pilih User --}}
                        <div class="mb-3">
                            <label for="user_select" class="form-label">Pilih User</label>
                            <select id="user_select" class="form-select">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pilih Cart Berdasarkan User --}}
                        <div id="cart_list" class="mb-4">
                            <h5>Daftar Produk</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                            <th>User</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach($carts as $cart)
                                            @php $subtotal = $cart->harga_produk * $cart->quantity; @endphp
                                            <tr class="cart-item user-{{ $cart->user_id }}" style="display:none;">
                                                <td><input type="checkbox" name="cart_ids[]" value="{{ $cart->cart_id }}" data-subtotal="{{ $subtotal }}" class="cart-checkbox"></td>
                                                <td>{{ $cart->nama_produk }}</td>
                                                <td>Rp {{ number_format($cart->harga_produk, 0, ',', '.') }}</td>
                                                <td>{{ $cart->quantity }}</td>
                                                <td class="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                                <td>{{ $cart->user_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-end">Total Harga:</th>
                                            <th colspan="2" id="total_display">Rp 0</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Voucher --}}
                        {{-- <div class="mb-3">
                            <label for="voucher_id" class="form-label">Pilih Voucher (Opsional)</label>
                            <select name="voucher_id" id="voucher_id" class="form-select">
                                <option value="">-- Tanpa Voucher --</option>
                                @foreach($vouchers as $voucher)
                                    <option value="{{ $voucher->id }}">
                                        {{ $voucher->kode_voucher }} - Potongan Rp {{ number_format($voucher->potongan, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}

                        {{-- Tombol --}}
                        <div class="tile-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-cash-stack"></i> Proses Checkout
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js_content')
<script>
    document.getElementById('user_select').addEventListener('change', function () {
        const userId = this.value;
        const cartItems = document.querySelectorAll('.cart-item');

        cartItems.forEach(item => {
            item.style.display = item.classList.contains('user-' + userId) ? '' : 'none';
        });

        updateTotal();
    });

    document.querySelectorAll('.cart-checkbox').forEach(cb => {
        cb.addEventListener('change', updateTotal);
    });

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.cart-checkbox:checked').forEach(cb => {
            total += parseInt(cb.getAttribute('data-subtotal')) || 0;
        });
        document.getElementById('total_display').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endsection
