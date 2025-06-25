<!-- Kategori Section -->
<section class="py-5 overflow-hidden">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
                <h2 class="section-title mb-0">Category</h2>
                <div class="d-flex align-items-center">
                    <a href="#" class="btn-link text-decoration-none me-3">View All Categories →</a>
                    <div class="swiper-buttons">
                        <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                        <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="category-carousel swiper">
                    <div class="swiper-wrapper" id="kategoriContainer">
                        <!-- Kategori akan dimuat dari SSE -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Load Swiper -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

@section('js_content_frontend')
<script>
    // URL SSE dan route template
    const sseUrl = "{{ route('frontend.GetKategoriFrontEnd') }}";
    const routeKategoriTemplate = "{{ route('frontend.detail_kategori', ['nama_kategori' => 'KATEGORI_PLACEHOLDER']) }}";

    // Buka koneksi SSE
    const eventSource = new EventSource(sseUrl);

    // Tampilkan data kategori
    function tampilkanKategori(kategoriData) {
        const container = document.getElementById('kategoriContainer');
        container.innerHTML = '';

        kategoriData.forEach((item, index) => {
            const gambar = item.gambar_url || '/storage/' + item.gambar_kategori;
            const linkKategori = routeKategoriTemplate.replace('KATEGORI_PLACEHOLDER', encodeURIComponent(item.nama_kategori));

            const kategoriHTML = `
                <a href="${linkKategori}" class="nav-link category-item swiper-slide text-center">
                    <img src="{{ asset('${gambar}') }}" alt="${item.nama_kategori}" class="img-fluid mb-2" style="max-height: 150px;">
                    <h3 class="category-title">${item.nama_kategori}</h3>
                </a>
            `;
            container.insertAdjacentHTML('beforeend', kategoriHTML);
        });

        // Inisialisasi Swiper
        if (typeof Swiper !== 'undefined') {
            new Swiper('.category-carousel', {
                slidesPerView: 4,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.category-carousel-next',
                    prevEl: '.category-carousel-prev',
                },
                breakpoints: {
                    1200: { slidesPerView: 4 },
                    992: { slidesPerView: 3 },
                    768: { slidesPerView: 2 },
                    576: { slidesPerView: 1 }
                }
            });
        }
    }

    // Event saat data SSE masuk
    eventSource.onmessage = function(event) {
        const data = JSON.parse(event.data);
        if (data.kategori && data.kategori.length > 0) {
            console.log(`Kategori diterima: ${data.kategori.length}`);
            tampilkanKategori(data.kategori);
        } else {
            console.warn("Data kategori kosong.");
        }
    };

    // Fallback jika SSE gagal
    eventSource.onerror = function(err) {
        console.error("SSE gagal, fallback ke fetch biasa:", err);
        eventSource.close();

        fetch(sseUrl)
            .then(res => res.text())
            .then(raw => {
                const data = JSON.parse(raw.replace(/^data:\s*/, ''));
                if (data.kategori) {
                    tampilkanKategori(data.kategori);
                }
            });
    };
</script>
@endsection
