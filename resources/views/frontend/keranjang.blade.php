{{-- @extends('frontend.component.main')

@section('contentfrontend') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <style>
        .keranjang-container {
            background: #ffffff;
            margin: 20px auto;
            width: 95%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #e6f7e9;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-img {
            width: 80px;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .qty-input {
            width: 60px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
        }

        .hapus-btn {
            background: #e53935;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .footer-keranjang {
            background: #ffffff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .checkout-btn {
            background: #2e7d32;
            color: white;
            border: none;
            padding: 12px 30px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .total-text {
            font-size: 16px;
        }

        .total-price {
            font-weight: bold;
            color: #2e7d32;
            font-size: 18px;
            margin-left: 10px;
        }

        .shopee-navbar {
            background-color: #fafafa;
            color: rgb(0, 0, 0);
            font-family: Arial, sans-serif;
            font-weight: 600;
            height: 60px;
            display: flex;
            align-items: center;
            box-shadow: 0 15px 8px rgba(0, 0, 0, 0.1);
            user-select: none;
            position: relative;
        }
    </style>
    <nav
        style="background: #fff; padding: 8px 0; color: #000000; font-size: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; top: -8px; margin-top: 0; border-radius: 0;">
        <div
            style="width: 100%; max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; padding: 0 16px;">
            <div style="display: flex; align-items: center; gap: 18px;">
                <!-- Logo di ujung kiri -->
                <a href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none;">
                    <img src="{{ asset('logo/download.png') }}" alt="Logo"
                        style="height: 50px; margin-right: 20px;">
                </a>
                <span style="border-left: 1px solid #eee; height: 24px; margin: 0 12px;"></span>
                <span>Ikuti kami di</span>
                <a href="#" style="color: #000000; margin-left: 4px;"><i class="fab fa-facebook-f"></i></a>
                <a href="#" style="color: #000000;"><i class="fab fa-instagram"></i></a>
                <a href="#" style="color: #000000;"><i class="fab fa-tiktok"></i></a>
            </div>
            <div style="display: flex; align-items: center; gap: 18px; flex-wrap: wrap;">
                <span><i class="far fa-bell"></i> Notifikasi</span>
                <span><i class="far fa-question-circle"></i> Bantuan</span>
                <!-- Language Switcher -->
                <div class="profile-dropdown-wrapper" style="position: relative;">
                    <span style="cursor:pointer;" onclick="toggleLangDropdown(event)">
                        <i class="fas fa-globe"></i>
                        {{ app()->getLocale() === 'en' ? 'English' : 'Bahasa Indonesia' }}
                        <i class="fas fa-chevron-down" style="font-size: 10px;"></i>
                    </span>
                    <div id="lang-dropdown" class="profile-dropdown" style="right: auto; left: 0;">
                        <a href="{{ route('lang.switch', 'id') }}" @if(app()->getLocale() === 'id') style="font-weight:bold;" @endif>
                            Bahasa Indonesia
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}" @if(app()->getLocale() === 'en') style="font-weight:bold;" @endif>
                            English
                        </a>
                    </div>
                </div>
                <style>
                    .profile-btn {
                        background-color: #e5e7eb;
                        border-radius: 9999px;
                        width: 2rem;
                        height: 2rem;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: #000;
                        font-weight: bold;
                        cursor: pointer;
                        position: relative;
                        z-index: 101;
                    }

                    .profile-dropdown-wrapper {
                        position: relative;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    }

                    .profile-dropdown {
                        position: absolute;
                        top: 110%;
                        right: 0;
                        min-width: 10rem;
                        background-color: #fff;
                        border: 1px solid #ddd;
                        border-radius: 0.25rem;
                        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
                        display: none;
                        z-index: 100;
                    }

                    .profile-dropdown.show {
                        display: block;
                    }

                    .profile-dropdown a {
                        display: block;
                        text-align: left;
                        padding: 0.5rem 1rem;
                        color: #333;
                        background: none;
                        border: none;
                        cursor: pointer;
                        font-size: 0.9rem;
                    }

                    .profile-dropdown button {
                        width: 100%;
                        display: block;
                        text-align: left;
                        padding: 0.5rem 1rem;
                        color: #333;
                        background: none;
                        border: none;
                        cursor: pointer;
                        font-size: 0.9rem;
                    }

                    .profile-dropdown a:hover,
                    .profile-dropdown button:hover {
                        background-color: #f3f4f6;
                    }

                    .profile-name {
                        margin-left: 8px;
                        font-weight: 500;
                        color: #222;
                        font-size: 15px;
                        letter-spacing: 0.2px;
                        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
                    }

                    .profile-email {
                        margin-left: 12px;
                        font-size: 14px;
                        color: #555;
                        font-weight: 400;
                        white-space: nowrap;
                    }

                    @media (max-width: 900px) {
                        nav>div {
                            flex-direction: column;
                            align-items: flex-start !important;
                            gap: 10px;
                        }

                        nav>div>div {
                            width: 100%;
                            justify-content: flex-start !important;
                            gap: 10px;
                        }

                        .profile-email {
                            margin-left: 0;
                            margin-top: 4px;
                        }
                    }

                    @media (max-width: 600px) {
                        nav>div {
                            padding: 0 6px !important;
                        }

                        .profile-name {
                            display: none;
                        }

                        .profile-email {
                            display: none;
                        }

                        nav>div>div {
                            font-size: 13px;
                            gap: 6px;
                        }
                    }
                </style>
                @auth
                    @php
                        $emailInitial = strtoupper(substr(Auth::user()->email, 0, 1));
                    @endphp
                    <div class="profile-dropdown-wrapper">
                        <div class="profile-btn" onclick="toggleDropdown(event)">
                            {{ $emailInitial }}
                        </div>
                        <span class="profile-name">{{ Auth::user()->name }}</span>
                        <div id="dropdown" class="profile-dropdown">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-2 text-gray-600"
                                    fill="none" height="24" width="24" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A4.992 4.992 0 0112 15a4.992 4.992 0 016.879 2.804M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                                </svg>
                                Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-2 text-gray-600"
                                        fill="none" height="24" width="24" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('register2') }}" class="nav-login" tabindex="0">Daftar</a>
                    <span class="mx-1 text-black">|</span>
                    <a href="{{ route('login') }}" class="nav-login" tabindex="0">Login</a>
                @endauth

                <script>
                    function toggleDropdown(event) {
                        event.stopPropagation();
                        var dropdown = document.getElementById("dropdown");
                        dropdown.classList.toggle("show");
                    }

                    // Menutup dropdown saat klik di luar elemen
                    document.addEventListener('click', function(event) {
                        var profileBtn = document.querySelector('.profile-btn');
                        var dropdown = document.getElementById('dropdown');
                        if (profileBtn && dropdown && !profileBtn.contains(event.target) && !dropdown.contains(event.target)) {
                            dropdown.classList.remove('show');
                        }
                        // Untuk language dropdown
                        var langBtn = document.querySelector('[onclick="toggleLangDropdown(event)"]');
                        var langDropdown = document.getElementById('lang-dropdown');
                        if (langBtn && langDropdown && !langBtn.contains(event.target) && !langDropdown.contains(event.target)) {
                            langDropdown.classList.remove('show');
                        }
                    });

                    function toggleLangDropdown(event) {
                        event.stopPropagation();
                        var langDropdown = document.getElementById("lang-dropdown");
                        langDropdown.classList.toggle("show");
                    }
                </script>
            </div>
        </div>
        <!-- Font Awesome CDN for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    </nav>

    <div class="keranjang-container">
        <form method="POST" action="{{ route('frontend.checkout') }}">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="check-all"> Semua</th>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Kuantitas</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keranjang as $item)
                        <tr id="row-{{ $item->id }}">
                            <td>
                                <input type="checkbox" class="item-check" name="selected[]" value="{{ $item->id }}"
                                    data-id="{{ $item->id }}">
                            </td>
                            <td>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <img src="{{ asset('storage/' . $item->gambar_produk) }}" class="product-img"
                                        alt="gambar produk">
                                    <div>
                                        <div><strong>{{ $item->nama_produk }}</strong></div>
                                    </div>
                                </div>
                            </td>
                            <td class="harga" data-id="{{ $item->id }}">
                                Rp{{ number_format($item->harga_produk, 0, ',', '.') }}
                            </td>
                            <td>
                                <input type="number" min="0" class="qty-input update-qty"
                                    data-id="{{ $item->id }}" value="{{ $item->quantity }}">
                            </td>
                            <td class="subtotal" data-id="{{ $item->id }}">
                                Rp{{ number_format($item->harga_produk * $item->quantity, 0, ',', '.') }}
                            </td>
                            <td>
                                <button type="button" class="hapus-btn btn-remove"
                                    data-id="{{ $item->id }}">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="footer-keranjang">
                <div>
                    <span class="total-text">Total Pilihan:</span>
                    <span class="total-price" id="total-price">Rp0</span>
                </div>
                <button type="submit" class="checkout-btn">Checkout</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fungsi debounce supaya delay saat user mengetik
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        // Format angka ke IDR
        function formatRupiah(value) {
            return 'Rp' + value.toLocaleString('id-ID');
        }

        // Parsing string rupiah ke integer (hapus Rp, titik dan koma)
        function parseRupiah(text) {
            return parseInt(text.replace(/[^0-9]/g, '')) || 0;
        }

        // Update total harga sesuai checkbox terpilih
        function updateTotal() {
            let total = 0;
            $('.item-check:checked').each(function() {
                const id = $(this).data('id');
                const subtotalText = $(`.subtotal[data-id="${id}"]`).text();
                const subtotal = parseRupiah(subtotalText);
                total += subtotal;
            });
            $('#total-price').text(formatRupiah(total));
        }

        // Simpan qty sebelumnya tiap input untuk rollback jika batal hapus
        const previousQtyMap = {};

        // Inisialisasi previousQtyMap dengan value awal
        $('.update-qty').each(function() {
            const id = $(this).data('id');
            previousQtyMap[id] = $(this).val();
        });

        // Update kuantitas dengan debounce dan konfirmasi hapus jika 0
        $('.update-qty').on('input', debounce(function() {
            const $input = $(this);
            const id = $input.data('id');
            let qty = parseInt($input.val());

            if (isNaN(qty) || qty < 0) {
                qty = previousQtyMap[id];
                $input.val(qty);
                return;
            }

            if (qty === 0) {
                if (confirm('Quantity 0, hapus produk ini dari keranjang?')) {
                    // Hapus item via ajax
                    $.ajax({
                        url: "{{ route('frontend.cartdestroy', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            $('#row-' + id).remove();
                            updateTotal();
                            // alert(res.message); // Tampilkan pesan dari controller
                        },
                        error: function() {
                            alert('Gagal menghapus item.');
                        }
                    });

                } else {
                    $input.val(previousQtyMap[id]); // rollback
                }
                return;
            }

            // Update quantity di server
            $.post("{{ route('frontend.cartupdate') }}", {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    jumlah: qty
                })
                .done(function() {
                    // Update subtotal di UI
                    const hargaText = $(`.harga[data-id="${id}"]`).text();
                    const harga = parseRupiah(hargaText);
                    const subtotal = harga * qty;
                    $(`.subtotal[data-id="${id}"]`).text(formatRupiah(subtotal));

                    previousQtyMap[id] = qty; // update previous qty
                    updateTotal();
                })
                .fail(function() {
                    alert('Gagal mengupdate kuantitas.');
                    $input.val(previousQtyMap[id]); // rollback
                });

        }, 500));

        // Event checkbox semua dan update total
        $('#check-all').on('change', function() {
            $('.item-check').prop('checked', this.checked);
            updateTotal();
        });

        // Event checkbox individual update total
        $(document).on('change', '.item-check', function() {
            updateTotal();
        });

        // Event hapus button
        $('.btn-remove').on('click', function() {
            const id = $(this).data('id');
            if (confirm('Yakin ingin menghapus item ini?')) {
                $.ajax({
                    url: "{{ route('frontend.cartdestroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        $('#row-' + id).remove();
                        updateTotal();
                        delete previousQtyMap[id];
                    },
                    error: function() {
                        alert('Gagal menghapus item.');
                    }
                });
            }
        });

        // Hitung total awal saat document siap
        $(document).ready(function() {
            updateTotal();
        });
    </script>
</body>

</html>

{{-- @endsection --}}
