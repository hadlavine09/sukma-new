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
                        <div class="container-fluid">
                            <div class="row mb-4">
                                <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
                                    <h2 class="section-title mb-0">Kategori {{ $kategori_toko->nama_kategori_toko }}</h2>

                                    {{-- Select Subkategori di ujung kanan --}}
                                    <div class="form-group mb-0">
                                        <select id="subKategori" class="form-select">
                                            <option selected disabled hidden>Pilih Kategori Produk</option>
                                            @foreach ($sub_kategori as $sub)
                                                <option value="{{ $sub->id }}">{{ $sub->nama_kategori_produk }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
                        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>



                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-all" role="tabpanel"
                                aria-labelledby="nav-all-tab">
                                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5"
                                    id="product-grid">
                                    <!-- Produk akan dimuat secara dinamis melalui SSE -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('js_content_frontend')
<script>
    const productGrid = document.getElementById('product-grid');
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.getElementById('search-input');
    const subKategoriSelect = document.getElementById('subKategori');

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    };

    let allProducts = [];
    let selectedSubKategori = 'all';

    const renderProducts = (products) => {
        productGrid.innerHTML = '';
        if (products.length === 0) {
            productGrid.innerHTML = '<div class="col-12 text-center"><p class="text-muted">Produk tidak ditemukan.</p></div>';
            return;
        }

        products.forEach(item => {
            const diskonBadge = item.diskon > 0 ?
                `<span class="badge bg-success position-absolute m-3">-${item.diskon}%</span>` : '';
            const tags = item.tags && item.tags.length ?
                `<div class="mt-1 small text-muted">Tags: ${item.tags.join(', ')}</div>` : '';
            const linkDetailProduk = `detail/${encodeURIComponent(item.nama_produk)}?kode=${encodeURIComponent(item.kode_produk)}`;

            const html = `
                <div class="col">
                    <div class="product-item text-decoration-none text-dark" style="cursor:pointer;">
                        <a href="{{ url('${linkDetailProduk}') }}" style="text-decoration: none;">
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
                </div>`;
            productGrid.insertAdjacentHTML('beforeend', html);
        });

        setupProductEvents();
    };

    const filterAndRenderProducts = () => {
        const keyword = searchInput.value.toLowerCase().trim();

        const filtered = allProducts.filter(item => {
            const namaProduk = item.nama_produk?.toLowerCase() || '';
            const deskripsiProduk = item.deskripsi_produk?.toLowerCase() || '';
            const namaToko = item.toko?.nama_toko?.toLowerCase() || '';
            const namaKategoriProduk = item.kategori_produk?.nama_kategori_produk?.toLowerCase() || '';
            const deskripsiKategoriProduk = item.kategori_produk?.deskripsi_kategori_produk?.toLowerCase() || '';
            const kategoriProdukId = item.kategori_produk_id || '';
            const tagMatch = item.tags?.some(tag =>
                (tag.nama_tag?.toLowerCase() || '').includes(keyword) ||
                (tag.deskripsi_tag?.toLowerCase() || '').includes(keyword)
            ) || false;

            const matchKeyword = (
                namaProduk.includes(keyword) ||
                deskripsiProduk.includes(keyword) ||
                namaToko.includes(keyword) ||
                namaKategoriProduk.includes(keyword) ||
                deskripsiKategoriProduk.includes(keyword) ||
                tagMatch
            );

            const matchSubKategori = selectedSubKategori === 'all' || kategoriProdukId == selectedSubKategori;

            return matchKeyword && matchSubKategori;
        });

        renderProducts(filtered);
    };

    // Event pencarian
    searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
        filterAndRenderProducts();
    });

    // Event perubahan subkategori
    subKategoriSelect.addEventListener('change', function () {
        selectedSubKategori = this.value;
        filterAndRenderProducts();
    });
    const kategoriTokoTarget = `{!! strtolower($kategori_toko->nama_kategori_toko) !!}`;

function fetchProduk() {
    fetch("{{ route('frontend.GetProdukFrontEnd') }}")
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                allProducts = data.produk.filter(item =>
                    item.kategori_toko &&
                    item.kategori_toko.nama_kategori_toko &&
                    item.kategori_toko.nama_kategori_toko.toLowerCase() === kategoriTokoTarget
                );
                filterAndRenderProducts();
            } else {
                console.error("Gagal ambil produk:", data.message);
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
        });
}

// Panggil sekali saat halaman dimuat
fetchProduk();

// (Opsional) Polling tiap 5 detik seperti SSE
// setInterval(fetchProduk, 5000);

// s
//     // Ambil data dari SSE
//     // const kategoriTokoTarget = `{!! strtolower($kategori_toko->nama_kategori_toko) !!}`;
//     // const evtSource = new EventSource("{{ route('frontend.GetProdukFrontEnd') }}");

//     // evtSource.onmessage = function (event) {
//     //     const data = JSON.parse(event.data);
//     //     if (data.status === 'success') {
//     //         allProducts = data.produk.filter(item =>
//     //             item.kategori_toko &&
//     //             item.kategori_toko.nama_kategori_toko &&
//     //             item.kategori_toko.nama_kategori_toko.toLowerCase() === kategoriTokoTarget
//     //         );
//     //         filterAndRenderProducts();
//     //     } else {
//     //         console.error("Gagal ambil produk:", data.message);
//     //     }
//     // };

//     // evtSource.onerror = function (err) {
//     //     console.error("SSE connection error:", err);
//     // };

    // Setup events untuk tombol +/-
    function setupProductEvents() {
        document.querySelectorAll('.product-item').forEach(product => {
            const minusBtn = product.querySelector('.quantity-left-minus');
            const plusBtn = product.querySelector('.quantity-right-plus');
            const qtyInput = product.querySelector('input[name="quantity"]');

            if (qtyInput && minusBtn && plusBtn) {
                minusBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    let currentQty = parseInt(qtyInput.value) || 1;
                    if (currentQty > 1) qtyInput.value = currentQty - 1;
                });

                plusBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    let currentQty = parseInt(qtyInput.value) || 1;
                    qtyInput.value = currentQty + 1;
                });

                qtyInput.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value === '' || parseInt(this.value) < 1) {
                        this.value = 1;
                    }
                });
            }

            const addToCartBtn = product.querySelector('.add-to-cart-btn');
            addToCartBtn.addEventListener('click', function (e) {
                e.preventDefault();
                const kodeProduk = new URL(product.querySelector('a').href).searchParams.get('kode');
                const qty = parseInt(product.querySelector('input[name="quantity"]')?.value) || 1;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                const baseUrl = document.querySelector('meta[name="base-url"]').content;
                const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

                if (!isAuthenticated) {
                    const returnUrl = encodeURIComponent(window.location.href);
                    window.location.href = `${baseUrl}/login?redirect=${returnUrl}`;
                    return;
                }

                $.ajax({
                    url: "{{ route('frontend.tambahkeranjang') }}",
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    data: {
                        kode_produk: kodeProduk,
                        quantity: qty
                    },
                    success: function (response) {
                        if (response.status === 'success' || response.status === 'exists') {
                            if (typeof loadCartData === 'function') {
                                loadCartData(true);
                            }
                        } else {
                            alert(response.message || 'Gagal menambahkan ke keranjang.');
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan saat mengirim ke server.');
                    }
                });
            });
        });
    }
</script>
@endsection

