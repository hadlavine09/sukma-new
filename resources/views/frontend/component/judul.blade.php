<style>
        .split-hero {
            display: flex;
            min-height: 500px;
            box-shadow: 0 15px 8px rgba(0, 0, 0, 0.1);
        }

        .left-side {
            flex: 1;
            background-color: #f5f6ef;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-side {
            flex: 1;
            padding: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom right, #80a78a 0%, #6FA36F 30%, #2d5727 100%);
        }


        .left-side h1 {
            font-size: 2.5rem;
            color: #1b4d3e;
            margin-bottom: 1rem;
        }

        .left-side p {
            font-size: 1rem;
            color: #444;
            margin-bottom: 1.5rem;
        }

        .cta-btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #3c9d40;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            max-width: fit-content;
        }

        .right-side img {
            max-width: 100%;
            height: auto;
            border-radius: 1rem;
        }
    </style>
    <section class="split-hero">
        <div class="left-side">
            <h1>SUKMA<br>(Sukamukti Market)</h1>
            <p>SUKMA adalah marketplace berbasis website yang menghadirkan kemudahan bagi masyarakat Sukamukti untuk menjual dan membeli produk lokal secara online. Temukan berbagai produk unggulan dari pelaku UMKM, dukung ekonomi desa, dan rasakan pengalaman belanja yang aman, mudah, dan terpercaya di Sukamukti Market.</p>
            <a href="#produk" class="cta-btn">Jelajahi Marketplace</a>
        </div>
        <div class="right-side">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('assets_frontend/images/hero-img-1.png') }}" class="d-block w-100 smooth-img" alt="Eco Products 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('logo/umkm1.jpeg') }}" class="d-block w-100 smooth-img" alt="Eco Products 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('logo/umkm2.jpeg') }}" class="d-block w-100 smooth-img" alt="Eco Products 3">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tambahkan Bootstrap CSS & JS jika belum ada -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            /* Custom smooth fade for carousel images with elegant in/out animation */
            .carousel .carousel-item {
                opacity: 0;
                transform: scale(0.98) translateY(20px);
                transition:
                    opacity 1s cubic-bezier(0.4,0,0.2,1),
                    transform 1s cubic-bezier(0.4,0,0.2,1);
                position: absolute;
                width: 100%;
                left: 0;
                top: 0;
                z-index: 1;
            }
            .carousel .carousel-item.active,
            .carousel .carousel-item-next.carousel-item-left,
            .carousel .carousel-item-prev.carousel-item-right {
                opacity: 1;
                transform: scale(1) translateY(0);
                position: relative;
                z-index: 2;
            }
            .carousel-inner {
                position: relative;
                width: 100%;
                overflow: hidden;
                min-height: 350px;
            }
        </style>
        <script>
            // Optional: force reflow for smooth fade on slide
            document.addEventListener('DOMContentLoaded', function () {
                var carousel = document.getElementById('heroCarousel');
                if (carousel) {
                    carousel.addEventListener('slide.bs.carousel', function (e) {
                        var items = carousel.querySelectorAll('.carousel-item');
                        items.forEach(function(item) {
                            item.style.transition = 'none';
                            void item.offsetWidth; // force reflow
                            item.style.transition = '';
                        });
                    });
                }
            });
        </script>
    </section>
