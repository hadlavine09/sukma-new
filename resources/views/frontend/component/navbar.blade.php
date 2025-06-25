<nav class="shopee-navbar" role="navigation" aria-label="Main navigation">
    <div class="container">
        <div class="navbar-left">
            <a href="{{ url('Home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="120"
                    height="108" viewBox="0 0 200 108">
                    <image id="logosukma" x="58" y="15" width="127" height="79"
                        xlink:href="data:img/png;base64,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" />
                </svg>
            </a>
        </div>
        <div class="navbar-center">
            <form action="#" method="GET" class="search-form" role="search" aria-label="Product search form"
                onsubmit="return false;">
                <div class="search-input-wrapper">
                    <input type="text" name="q" id="search-input" placeholder="Cari produk, brand, dan lainnya"
                        autocomplete="off" aria-autocomplete="list" aria-controls="search-suggestions"
                        aria-expanded="false" />
                    <button type="submit" aria-label="Search">
                        <svg fill="#777" height="20" width="20" viewBox="0 0 24 24" aria-hidden="true"
                            focusable="false">
                            <path
                                d="M21.71 20.29l-3.388-3.388a7.918 7.918 0 001.62-5.092C19.942 7.015 16.927 4 13.221 4S6.5 7.015 6.5 10.71c0 3.696 3.015 6.71 6.721 6.71a7.918 7.918 0 005.092-1.62l3.388 3.388c.39.39 1.025.39 1.414 0a1 1 0 000-1.414zM8 10.71a5.22 5.22 0 015.221-5.21 5.22 5.22 0 015.22 5.21 5.22 5.22 0 01-5.22 5.21A5.22 5.22 0 018 10.71z" />
                        </svg>
                    </button>
                </div>
                <ul id="search-suggestions" role="listbox" class="suggestions" hidden></ul>
            </form>
        </div>
        <div class="navbar-right d-flex align-items-center" style="gap: 1rem;">
            <!-- Cart Dropdown -->
            <div class="nav-cart-dropdown-wrapper position-relative" style="display:inline-block;">
                <a href="{{ route('frontend.keranjang') }}" class="nav-icon" aria-label="Keranjang Belanja"
                    title="Keranjang Belanja" id="cartDropdownBtn">
                    <svg fill="#fff" height="24" width="24" viewBox="0 0 24 24" aria-hidden="true"
                        focusable="false">
                        <path
                            d="M7 18c-1.104 0-2 .895-2 2 0 1.104.896 2 2 2 1.104 0 2-.896 2-2 0-1.105-.896-2-2-2zm10 0c-1.104 0-2 .895-2 2 0 1.104.896 2 2 2 1.104 0 2-.896 2-2 0-1.105-.896-2-2-2zM7.2 13h9.599c.75 0 1.423-.436 1.734-1.115l3.732-7.221-1.972-.972-3.069 5.917-5.727-.008L6.473 2.28A1 1 0 005.58 2H2v2h2.41l3.413 9.336a1.001 1.001 0 00.38.384l.998.6a1.007 1.007 0 00.999 0z" />
                    </svg>
                </a>
                <div id="cartDropdownCard" class="cart-dropdown-card card shadow border-0 position-absolute end-0 mt-2"
                    style="min-width:370px; max-width:400px; z-index:1000; display:none; opacity:0; transform:translateY(10px); transition:opacity 0.25s, transform 0.25s; border-radius:12px; overflow:hidden;">
                    <!-- ... (cart dropdown content remains unchanged) ... -->
                    <div class="cart-dropdown-header px-4 py-3"
                        style="background:#f44336; color:#fff; font-weight:600; font-size:1.1rem;">
                        Keranjang Belanja
                    </div>
                    <div class="cart-dropdown-body px-0 py-0" style="max-height:340px; overflow-y:auto;">
                        <ul class="list-group list-group-flush" id="cartDropdownList" style="background:#fff;">
                            <li class="list-group-item text-center text-muted py-5 empty-cart-message"
                                style="display:none; border:none;">
                                <div>
                                    <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart-empty-v2.png"
                                        alt="Empty Cart" style="width:80px; opacity:0.7;">
                                    <div class="mt-2" style="font-size:1rem;">Keranjang masih kosong</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="cart-dropdown-footer px-4 py-3"
                        style="background:#fafafa; border-top:1px solid #f0f0f0;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-weight:500;">Total</span>
                            <strong id="cartDropdownTotal" style="font-size:1.1rem;">Rp0</strong>
                        </div>
                        <a href="{{ route('frontend.keranjang') }}" class="btn btn-danger w-100" id="lihatKeranjangBtn"
                            style="border-radius:6px;">
                            Lihat Keranjang
                        </a>
                    </div>
                    <div class="px-3 pb-2" style="display:none;">
                        <pre id="cartJsonData" style="font-size:12px; background:#f8f9fa; border-radius:4px; padding:8px; overflow:auto;"></pre>
                    </div>
                </div>
                <style>
                    /* ... (cart dropdown styles remain unchanged) ... */
                    .cart-dropdown-card {
                        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.18);
                        border: none;
                        font-family: inherit;
                    }
                    .cart-dropdown-card.show {
                        display: block !important;
                        opacity: 1 !important;
                        transform: translateY(0) !important;
                        pointer-events: auto;
                    }
                    .cart-dropdown-card.hiding {
                        opacity: 0 !important;
                        transform: translateY(10px) !important;
                        pointer-events: none;
                        transition: opacity 0.25s, transform 0.25s;
                    }
                    .cart-dropdown-body::-webkit-scrollbar {
                        width: 6px;
                        background: #f5f5f5;
                    }
                    .cart-dropdown-body::-webkit-scrollbar-thumb {
                        background: #eee;
                        border-radius: 4px;
                    }
                    .cart-dropdown-item-img {
                        width: 48px;
                        height: 48px;
                        object-fit: cover;
                        border-radius: 6px;
                        background: #f5f5f5;
                        border: 1px solid #eee;
                    }
                    .cart-dropdown-item {
                        display: flex;
                        align-items: center;
                        gap: 12px;
                        padding: 12px 24px;
                        border-bottom: 1px solid #f5f5f5;
                        background: #fff;
                    }
                    .cart-dropdown-item:last-child {
                        border-bottom: none;
                    }
                    .cart-dropdown-item-info {
                        flex: 1;
                        min-width: 0;
                    }
                    .cart-dropdown-item-title {
                        font-size: 1rem;
                        font-weight: 500;
                        color: #222;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }
                    .cart-dropdown-item-category {
                        font-size: 0.85rem;
                        color: #888;
                        margin-bottom: 2px;
                    }
                    .cart-dropdown-item-qty {
                        font-size: 0.85rem;
                        color: #f44336;
                        font-weight: 500;
                    }
                    .cart-dropdown-item-price {
                        font-size: 1rem;
                        font-weight: 600;
                        color: #f44336;
                        min-width: 70px;
                        text-align: right;
                    }
                </style>
                <script>
                    // ... (cart dropdown scripts remain unchanged) ...
                    window.loadCartData = function(force = false) {
                        const cartList = document.querySelector('#cartDropdownList');
                        const totalDisplay = document.getElementById('cartDropdownTotal');
                        const emptyMsg = cartList.querySelector('.empty-cart-message');
                        const cartJsonData = document.getElementById('cartJsonData');
                        if (!window.cartLoaded) window.cartLoaded = false;
                        if (window.cartLoaded && !force) return;
                        fetch('{{ route('frontend.keranjang_down') }}', {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('HTTP ' + response.status + ' - ' + response.statusText);
                                }
                                return response.json();
                            })
                            .then(data => {
                                cartJsonData.textContent = JSON.stringify(data, null, 2);
                                let total = 0;
                                cartList.querySelectorAll('.cart-dropdown-item').forEach(item => item.remove());
                                cartList.querySelectorAll('.list-group-item.text-center.py-2').forEach(item => item.remove());
                                let items = [];
                                if (data && Array.isArray(data.data)) {
                                    items = data.data;
                                }
                                if (!Array.isArray(items) || items.length === 0) {
                                    emptyMsg.style.display = '';
                                } else {
                                    emptyMsg.style.display = 'none';
                                    items.slice(0, 5).forEach(item => {
                                        const li = document.createElement('li');
                                        li.className = 'cart-dropdown-item';
                                        let imgSrc = '';
                                        if (item.gambar_produk) {
                                            imgSrc = item.gambar_produk.startsWith('http') ? item.gambar_produk :
                                                '/storage/' + item.gambar_produk;
                                        }
                                        const nama_produk = item.nama_produk || item.nama || item.kode_produk ||
                                            'Produk';
                                        const kategori = item.nama_kategori || item.kategori || '';
                                        const qty = item.quantity || item.qty || 1;
                                        const harga = item.harga_produk || item.harga || 0;
                                        li.innerHTML = `
                                                <img src="${imgSrc}" alt="${nama_produk}" class="cart-dropdown-item-img">
                                                <div class="cart-dropdown-item-info">
                                                    <div class="cart-dropdown-item-title" title="${nama_produk}">${nama_produk}</div>
                                                    <div class="cart-dropdown-item-category">${kategori}</div>
                                                    <div class="cart-dropdown-item-qty">x${qty}</div>
                                                </div>
                                                <div class="cart-dropdown-item-price">${formatRupiah(harga)}</div>
                                            `;
                                        cartList.insertBefore(li, emptyMsg.nextSibling);
                                        total += harga * qty;
                                    });
                                    if (items.length > 5) {
                                        const moreLi = document.createElement('li');
                                        moreLi.className = 'list-group-item text-center py-2';
                                        moreLi.style.fontSize = '0.95rem';
                                        moreLi.style.background = '#fff';
                                        moreLi.textContent = `+${items.length - 5} produk lainnya`;
                                        cartList.insertBefore(moreLi, emptyMsg.nextSibling.nextSibling);
                                    }
                                }
                                totalDisplay.textContent = formatRupiah(total);
                                window.cartLoaded = true;
                            })
                            .catch(error => {
                                cartJsonData.textContent = 'Gagal memuat data keranjang: ' + error;
                                emptyMsg.style.display = '';
                                totalDisplay.textContent = 'Rp0';
                            });
                    };

                    document.addEventListener('DOMContentLoaded', function() {
                        window.cartLoaded = false;
                        loadCartData();
                        const lihatBtn = document.getElementById('lihatKeranjangBtn');
                        const cartList = document.querySelector('#cartDropdownList');
                        const emptyMsg = cartList.querySelector('.empty-cart-message');
                        lihatBtn.addEventListener('click', function(e) {
                            const items = cartList.querySelectorAll('.cart-dropdown-item');
                            if (items.length === 0) {
                                e.preventDefault();
                                emptyMsg.style.display = '';
                            }
                        });
                        const cartBtn = document.getElementById('cartDropdownBtn');
                        cartBtn.addEventListener('mouseenter', function() {
                            window.cartLoaded = false;
                            loadCartData(true);
                        });
                        cartBtn.addEventListener('focus', function() {
                            window.cartLoaded = false;
                            loadCartData(true);
                        });
                    });

                    // Dropdown show/hide logic
                    document.addEventListener('DOMContentLoaded', function() {
                        const cartBtn = document.getElementById('cartDropdownBtn');
                        const cartCard = document.getElementById('cartDropdownCard');
                        const wrapper = cartBtn.closest('.nav-cart-dropdown-wrapper');
                        let hideTimeout = null;

                        function showCartCard() {
                            clearTimeout(hideTimeout);
                            cartCard.style.display = 'block';
                            cartCard.classList.remove('hiding');
                            void cartCard.offsetWidth;
                            cartCard.classList.add('show');
                        }

                        function hideCartCard() {
                            cartCard.classList.remove('show');
                            cartCard.classList.add('hiding');
                            hideTimeout = setTimeout(() => {
                                cartCard.style.display = 'none';
                                cartCard.classList.remove('hiding');
                            }, 250);
                        }
                        wrapper.addEventListener('mouseenter', showCartCard);
                        wrapper.addEventListener('mouseleave', function() {
                            hideTimeout = setTimeout(hideCartCard, 120);
                        });
                        cartBtn.addEventListener('focus', showCartCard);
                        cartBtn.addEventListener('blur', function() {
                            hideTimeout = setTimeout(hideCartCard, 120);
                        });
                        cartCard.addEventListener('mouseenter', function() {
                            clearTimeout(hideTimeout);
                        });
                        cartCard.addEventListener('mouseleave', function() {
                            hideTimeout = setTimeout(hideCartCard, 120);
                        });
                    });
                </script>
            </div>
            <!-- End Cart Dropdown -->

            <!-- Profile Dropdown -->
            <div class="profile-dropdown-wrapper" style="margin-left: 0.5rem;">
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
                        nav > div {
                            flex-direction: column;
                            align-items: flex-start !important;
                            gap: 10px;
                        }
                        nav > div > div {
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
                        nav > div {
                            padding: 0 6px !important;
                        }
                        .profile-name {
                            display: none;
                        }
                        .profile-email {
                            display: none;
                        }
                        nav > div > div {
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
                    <a href="{{ route('register2') }}" class="nav-login" tabindex="0">Register</a>
                    <span class="mx-1 text-black">|</span>
                    <a href="{{ route('LoginToko') }}" class="nav-login" tabindex="0">Daftar sebagai UMKM</a>
                    <span class="mx-1 text-black">|</span>
                    <a href="{{ route('login') }}" class="nav-login" tabindex="0">Login</a>
                @endauth

                <script>
                    function toggleDropdown(event) {
                        event.stopPropagation();
                        var dropdown = document.getElementById("dropdown");
                        dropdown.classList.toggle("show");
                    }
                    document.addEventListener('click', function(event) {
                        var profileBtn = document.querySelector('.profile-btn');
                        var dropdown = document.getElementById('dropdown');
                        if (!profileBtn.contains(event.target) && !dropdown.contains(event.target)) {
                            dropdown.classList.remove('show');
                        }
                    });
                </script>
            </div>
            <!-- End Profile Dropdown -->
        </div>
</nav>
