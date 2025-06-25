@extends('frontend.component.main')
@section('contentfrontend')
    @include('frontend.component.judul');

    <style>
        /* Responsive Product Tabs & Grid */
        .product-tabs .tabs-header {
            flex-direction: column;
            gap: 1rem;
        }

        .product-tabs .tabs-header h3 {
            margin-bottom: 0.5rem;
        }

        .product-tabs .nav-tabs {
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .product-tabs .nav-link {
            margin-bottom: 0.25rem;
        }

        .product-grid {
            gap: 1.5rem 0;
        }

        .product-item {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            padding: 1.25rem 1rem 1rem 1rem;
            position: relative;
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-item figure {
            margin: 0 0 1rem 0;
            text-align: center;
        }

        .product-item img.tab-image {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        .product-item h3 {
            font-size: 1.1rem;
            margin: 0 0 0.25rem 0;
            font-weight: 600;
        }

        .product-item .qty,
        .product-item .rating {
            font-size: 0.9rem;
            color: #888;
            margin-right: 0.5rem;
        }

        .product-item .price {
            font-size: 1.1rem;
            font-weight: bold;
            color: #2d5727;
            margin-bottom: 0.5rem;
            display: block;
        }

        .product-item .btn-wishlist {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background: #f5f6ef;
            border-radius: 50%;
            padding: 0.25rem;
            z-index: 2;
        }

        .product-item .badge {
            left: 0.75rem;
            top: 0.75rem;
            z-index: 2;
        }

        .product-item .input-group.product-qty {
            max-width: 120px;
        }

        .product-item .input-group .form-control {
            text-align: center;
            padding: 0.25rem 0.5rem;
            font-size: 1rem;
            height: 2rem;
        }

        .product-item .input-group-btn .btn {
            padding: 0.25rem 0.5rem;
            font-size: 1rem;
        }

        .product-item .nav-link {
            font-size: 0.95rem;
            font-weight: 500;
            color: #2d5727;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            background: #f5f6ef;
            transition: background 0.2s;
        }

        .product-item .nav-link:hover {
            background: #e0e7e9;
            color: #1b4d3e;
        }

        /* Responsive grid columns */
        @media (max-width: 1199.98px) {
            .product-grid.row-cols-xl-5>.col {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        @media (max-width: 991.98px) {
            .product-grid.row-cols-lg-4>.col {
                flex: 0 0 25%;
                max-width: 25%;
            }
        }

        @media (max-width: 767.98px) {
            .product-grid.row-cols-md-3>.col {
                flex: 0 0 33.3333%;
                max-width: 33.3333%;
            }

            .product-tabs .tabs-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 575.98px) {
            .product-grid.row-cols-sm-2>.col {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .product-item {
                padding: 1rem 0.5rem 0.75rem 0.5rem;
            }

            .product-item h3 {
                font-size: 1rem;
            }

            .product-item .price {
                font-size: 1rem;
            }
        }

        @media (max-width: 400px) {
            .product-grid.row-cols-1>.col {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .product-item {
                padding: 0.75rem 0.25rem 0.5rem 0.25rem;
            }
        }
    </style>
    <section class="">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="bootstrap-tabs product-tabs">
                        <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                            <h3>Trending Products {{ $kategori->nama_kategori }}</h3>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a href="#" class="nav-link text-uppercase fs-6 active" id="nav-all-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-all">All</a>
                                    <a href="#" class="nav-link text-uppercase fs-6" id="nav-fruits-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-fruits">Fruits & Veges</a>
                                    <a href="#" class="nav-link text-uppercase fs-6" id="nav-juices-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-juices">Juices</a>
                                </div>
                            </nav>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-all" role="tabpanel"
                                aria-labelledby="nav-all-tab">
                                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5"
                                    id="product-grid">
                                    <!-- Produk akan dimuat secara dinamis melalui SSE -->
                                </div>


                                <script>
                                    const productGrid = document.getElementById('product-grid');

                                    const formatRupiah = (number) => {
                                        return new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                        }).format(number);
                                    };

                                    // Render produk dan pasang event handler setelah render
                                    const renderProducts = (products) => {
                                        productGrid.innerHTML = '';
                                        products.forEach(item => {
                                            const diskonBadge = item.diskon > 0 ?
                                                `<span class="badge bg-success position-absolute m-3">-${item.diskon}%</span>` :
                                                '';

                                            const tags = item.tags && item.tags.length ?
                                                `<div class="mt-1 small text-muted">Tags: ${item.tags.join(', ')}</div>` :
                                                '';
                                                const linkDetailProduk = `detail/${encodeURIComponent(item.nama_produk)}?kode=${encodeURIComponent(item.kode_produk)}`;

                                            const html = `
                                                <div class="col">
                                                    <div class="product-item text-decoration-none text-dark" style="cursor:pointer;">
                                                        <a href="{{ asset('${linkDetailProduk}') }}" style="text-decoration: none;">
                                                            ${diskonBadge}
                                                            <span class="btn-wishlist">
                                                                <svg width="24" height="24"><use xlink:href="#heart"></use></svg>
                                                            </span>
                                                            <figure>
                                                                <img src="{{ asset('storage/${item.gambar_produk}') }}" class="tab-image" alt="${item.nama_produk}">
                                                            </figure>
                                                            <h3>${item.nama_produk}</h3>
                                                            <span class="rating">
                                                                <svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg> 4.5
                                                            </span>
                                                            <span class="price">${formatRupiah(item.harga_produk)}</span>
                                                        </a>
                                                        <div class="d-flex align-items-center justify-content-between mt-2">
                                                            <div class="input-group product-qty">
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                                                        <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="quantity" class="form-control input-number" value="1">
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                                                        <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <span class="nav-link add-to-cart-btn" style="cursor:pointer;">Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon></span>
                                                        </div>
                                                        ${tags}
                                                    </div>
                                                </div>
                                            `;
                                            productGrid.insertAdjacentHTML('beforeend', html);
                                        });

                                        // Pasang event handler qty dan add to cart setelah render
                                        setupProductEvents();
                                    };

                                    // SSE produk
                                    const sseUrl = "{{ route('frontend.GetProdukDetailKategoriFrontEnd') }}?kode_kategori={{ urlencode($kategori->kode_kategori) }}";

                                    // Buat EventSource dari URL SSE dengan parameter kode_kategori
                                    const evtSource = new EventSource(sseUrl);

                                    evtSource.onmessage = function(event) {
                                        const data = JSON.parse(event.data);
                                        console.log(data.produk);
                                        if (data.status === 'success') {
                                            renderProducts(data.produk); // Pastikan fungsi renderProducts sudah ada
                                        } else {
                                            console.error("Error fetching products:", data.message);
                                        }
                                    };
                                    // --- Cart Logic ---
                                    let cart = [];
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const cartBtn = document.getElementById('cartDropdownBtn');
                                        const cartCard = document.getElementById('cartDropdownCard');
                                        const cartList = cartCard.querySelector('ul.list-group');
                                        const cartTotal = cartCard.querySelector('strong');
                                        const cartDropdownWrapper = document.querySelector('.nav-cart-dropdown-wrapper');

                                        function formatRupiah(num) {
                                            return 'Rp' + num.toLocaleString('id-ID');
                                        }

                                        function updateCartDropdown() {
                                            cartList.querySelectorAll('li:not(:last-child)').forEach(li => li.remove());
                                            let total = 0;
                                            cart.forEach(item => {
                                                total += item.price * item.qty;
                                                const li = document.createElement('li');
                                                li.className = "list-group-item d-flex justify-content-between lh-sm";
                                                li.innerHTML = `
                                                    <div>
                                                        <h6 class="my-0">${item.name}</h6>
                                                        <small class="text-body-secondary">${item.desc}</small>
                                                        <span class="badge bg-secondary ms-2">${item.qty}x</span>
                                                    </div>
                                                    <span class="text-body-secondary">${formatRupiah(item.price * item.qty)}</span>
                                                `;
                                                cartList.insertBefore(li, cartList.lastElementChild);
                                            });
                                            cartTotal.textContent = formatRupiah(total);
                                        }

                                        // --- Animate to Cart ---
                                        function animateToCart(img, startRect, endRect) {
                                            const flyingImg = img.cloneNode(true);
                                            flyingImg.style.position = 'fixed';
                                            flyingImg.style.zIndex = 2000;
                                            flyingImg.style.left = startRect.left + 'px';
                                            flyingImg.style.top = startRect.top + 'px';
                                            flyingImg.style.width = startRect.width + 'px';
                                            flyingImg.style.height = startRect.height + 'px';
                                            flyingImg.style.transition = 'all 0.7s cubic-bezier(.6,-0.28,.74,.05)';
                                            flyingImg.style.pointerEvents = 'none';
                                            document.body.appendChild(flyingImg);

                                            setTimeout(() => {
                                                flyingImg.style.left = (endRect.left + endRect.width / 2 - startRect.width / 2) + 'px';
                                                flyingImg.style.top = (endRect.top + endRect.height / 2 - startRect.height / 2) + 'px';
                                                flyingImg.style.width = '24px';
                                                flyingImg.style.height = '24px';
                                                flyingImg.style.opacity = 0.5;
                                            }, 10);

                                            setTimeout(() => {
                                                flyingImg.remove();
                                                cartCard.style.display = 'block';
                                                cartCard.classList.add('show');
                                            }, 700);
                                        }

                                        // --- Cart Dropdown Toggle ---
                                        cartBtn.addEventListener('click', function() {
                                            cartCard.classList.toggle('show');
                                            cartCard.style.display = cartCard.classList.contains('show') ? 'block' : 'none';
                                        });

                                        // --- Hide cart dropdown if click outside ---
                                        document.addEventListener('mousedown', function(e) {
                                            if (!cartDropdownWrapper.contains(e.target)) {
                                                cartCard.classList.remove('show');
                                                cartCard.style.display = 'none';
                                            }
                                        });

                                        // --- Setup product events (qty & add to cart) ---
                                        window.setupProductEvents = function() {
                                            document.querySelectorAll('.product-item').forEach(product => {
                                                const minusBtn = product.querySelector('.quantity-left-minus');
                                                const plusBtn = product.querySelector('.quantity-right-plus');
                                                const qtyInput = product.querySelector('input[name="quantity"]');

                                                if (qtyInput && minusBtn && plusBtn) {
                                                    minusBtn.addEventListener('click', function(e) {
                                                        e.preventDefault();
                                                        let currentQty = parseInt(qtyInput.value) || 1;
                                                        if (currentQty > 1) {
                                                            qtyInput.value = currentQty - 1;
                                                        }
                                                    });

                                                    plusBtn.addEventListener('click', function(e) {
                                                        e.preventDefault();
                                                        let currentQty = parseInt(qtyInput.value) || 1;
                                                        qtyInput.value = currentQty + 1;
                                                    });

                                                    qtyInput.addEventListener('input', function() {
                                                        this.value = this.value.replace(/[^0-9]/g, '');
                                                        if (this.value === '' || parseInt(this.value) < 1) {
                                                            this.value = 1;
                                                        }
                                                    });
                                                }

                                                // Add to Cart button
                                                const addToCartBtn = product.querySelector('.add-to-cart-btn');
                                                if (addToCartBtn) {
                                                    addToCartBtn.addEventListener('click', function(e) {
                                                        e.preventDefault();
                                                        const baseUrl = document.querySelector('meta[name="base-url"]').content;
                                                        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
                                                        if (!isAuthenticated) {
                                                            const returnUrl = encodeURIComponent(window.location.href);
                                                            window.location.href = `${baseUrl}/login?redirect=${returnUrl}`;
                                                            return;
                                                        }
                                                        const name = product.querySelector('h3').textContent.trim();
                                                        const price = parseInt(product.querySelector('.price').textContent.replace(/[^0-9]/g, ''));
                                                        const desc = product.querySelector('.qty')?.textContent || '';
                                                        const img = product.querySelector('img');
                                                        const qtyInput = product.querySelector('input[name="quantity"]');
                                                        let qty = parseInt(qtyInput?.value) || 1;

                                                        // Add to cart (increase qty if exists)
                                                        let found = cart.find(item => item.name === name);
                                                        if (found) {
                                                            found.qty += qty;
                                                        } else {
                                                            cart.push({
                                                                name,
                                                                price,
                                                                desc,
                                                                qty
                                                            });
                                                        }
                                                        updateCartDropdown();

                                                        // Animate image to cart
                                                        const imgRect = img.getBoundingClientRect();
                                                        const cartRect = cartBtn.getBoundingClientRect();
                                                        animateToCart(img, imgRect, cartRect);
                                                    });
                                                }
                                            });
                                        };
                                    });
                                </script>

                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <meta name="base-url" content="{{ url('/') }}">
                                <!-- / product-grid -->

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
