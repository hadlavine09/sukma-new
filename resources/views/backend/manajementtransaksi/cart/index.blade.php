@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-cart"></i> Data Cart</h1>
            <p>Table untuk menampilkan data keranjang pengguna</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active"><a href="#">Data Cart</a></li>
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

                    <div class="mb-3">
                        <a href="{{ route('cart.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah ke Cart</a>
                        <a href="{{ route('cart.checkout') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Checkout</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="cartTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Ditambahkan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach($carts as $cart)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $cart->user->name ?? 'User Tidak Ditemukan' }}</td>
                                        <td>{{ $cart->produk->nama_produk ?? 'Produk Tidak Ditemukan' }}</td>
                                        <td>Rp.{{ number_format($cart->harga_produk, 0, ',', '.') }}</td>
                                        <td>{{ $cart->quantity }}</td>
                                        <td>Rp {{ number_format($cart->harga_produk, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($cart->harga_produk * $cart->quantity, 0, ',', '.') }}</td>
                                        <td>{{ $cart->created_at }}</td>
                                        <td>
                                           <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini dari cart?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-end">Total Seluruh:</th>
                                    <th colspan="3">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js_content')
<script>
    setTimeout(function() {
        $('#success-alert').fadeOut('slow');
        $('#error-alert').fadeOut('slow');
    }, 3000);
</script>
@endsection
