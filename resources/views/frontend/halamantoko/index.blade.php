<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Shopee Seller Centre - Dashboard Clone</title>
    <link rel="stylesheet" href="{{ asset('assets_frontend/css/toko.css') }}">
</head>

<body>
    <div class="app-container" role="main">
        <!-- Header -->
        <header>
            <div class="logo" aria-label="Shopee logo and application name">
                <a href="{{ url('/') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="120"
                        height="108" viewBox="0 0 200 108">
                        <image id="logosukma" x="58" y="15" width="127" height="79"
                            xlink:href="data:img/png;base64,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" />
                    </svg>
                </a>
                Sukma Seller Centre
            </div>
            <div class="header-right" role="region" aria-label="Header action icons and user menu">

                <div class="profile-dropdown-wrapper" style="margin-left: 0.5rem;">
                    @auth
                        @php
                            $emailInitial = strtoupper(substr(Auth::user()->email, 0, 1));
                        @endphp
                        <div class="profile-dropdown-wrapper">
                            <div class="profile-btn" onclick="toggleDropdown(event)">
                                {{ $emailInitial }}
                            </div>
                            <div class="profile-trigger" onclick="toggleDropdown(event)">
                                <span class="profile-name">{{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-chevron-down-icon lucide-chevron-down">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                            <div id="dropdown" class="profile-dropdown">
                                <a href="{{ url('/profile') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-2 text-gray-600"
                                        fill="none" height="24" width="24" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A4.992 4.992 0 0112 15a4.992 4.992 0 016.879 2.804M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                                    </svg>
                                    Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="inline-block w-5 h-5 mr-2 text-gray-600" fill="none" height="24"
                                            width="24" viewBox="0 0 24 24" stroke="currentColor">
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
                </div>

                <script>
                    function toggleDropdown(event) {
                        event.stopPropagation();
                        var dropdown = document.getElementById("dropdown");
                        dropdown.classList.toggle("show");
                    }

                    document.addEventListener('click', function(event) {
                        var profileBtn = document.querySelector('.profile-btn');
                        var profileTrigger = document.querySelector('.profile-trigger');
                        var dropdown = document.getElementById('dropdown');
                        if (
                            !profileBtn.contains(event.target) &&
                            !profileTrigger.contains(event.target) &&
                            !dropdown.contains(event.target)
                        ) {
                            dropdown.classList.remove('show');
                        }
                    });
                </script>

            </div>
        </header>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar" aria-label="Main navigation sidebar">
            <nav>
                <div class="menu-section">
                    <ul>
                        <li class="has-submenu expanded" tabindex="0" aria-expanded="true"
                            aria-controls="submenu-pesanan">
                            Pesanan
                            <i class="arrow"></i>
                            <ul class="submenu" id="submenu-pesanan" role="menu">
                                <li role="menuitem" tabindex="-1"><a href="">Pesanan
                                        Saya</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Pengiriman
                                        Massal</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Serah
                                        Terima Pesanan</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Pengembalian/Pembatalan</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Pengaturan Pengiriman</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="menu-section">
                    <ul>
                        <li class="has-submenu expanded" tabindex="0" aria-expanded="true"
                            aria-controls="submenu-produk">
                            Produk
                            <i class="arrow"></i>
                            <ul class="submenu" id="submenu-produk" role="menu">
                                <li role="menuitem" tabindex="-1"><a href="">Produk
                                        Saya</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Tambah
                                        Produk Baru</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Manajemen
                                        Merek</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="menu-section">
                    <ul>
                        <li class="has-submenu expanded" tabindex="0" aria-expanded="true"
                            aria-controls="submenu-pusatpromosi">
                            Pusat Promosi
                            <i class="arrow"></i>
                            <ul class="submenu" id="submenu-pusatpromosi" role="menu">
                                <li role="menuitem" tabindex="-1"><a href="">Pusat
                                        Promosi</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Garansi
                                        Harga Terbaik</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Iklan
                                        Shopee</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Affiliate Marketing Solution</a>
                                </li>
                                <li role="menuitem" tabindex="-1"><a href="">Live &
                                        Video</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Diskon</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Flash
                                        Sale Toko Saya</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Voucher
                                        Toko Saya</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Promosi</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="menu-section">
                    <ul>
                        <li class="has-submenu expanded" tabindex="0" aria-expanded="true"
                            aria-controls="submenu-pembeli">
                            Layanan Pembeli
                            <i class="arrow"></i>
                            <ul class="submenu" id="submenu-pembeli" role="menu">
                                <li role="menuitem" tabindex="-1"><a href="">Manajemen
                                        Chat</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Asisten AI
                                        Chat</a></li>
                                <li role="menuitem" tabindex="-1"><a href="">Penilaian Toko</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

        </aside>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const arrows = document.querySelectorAll("aside.sidebar .arrow");

                arrows.forEach(arrow => {
                    arrow.addEventListener("click", function(e) {
                        e.stopPropagation(); // Hindari klik propagate ke <li>
                        const li = this.closest("li.has-submenu");
                        li.classList.toggle("expanded");
                    });
                });
            });
        </script>

        <div class="container">
            <!-- Main Content -->
            <main class="main-content">
                <!-- Yang Perlu Dilakukan -->
                <div class="card wide">
                    <h3>Yang Perlu Dilakukan</h3>
                    <div class="action-row">
                        <a href="/portal/shipment" class="to-do-box-item">
                            <p class="item-title">0</p>
                            <p class="item-desc">Pengiriman Perlu Diproses</p>
                        </a>
                        <a href="/portal/shipment" class="to-do-box-item">
                            <p class="item-title">0</p>
                            <p class="item-desc">Pengiriman Telah Diproses</p>
                        </a>
                        <a href="/portal/sale/returnrefundcancel" class="to-do-box-item">
                            <p class="item-title">0</p>
                            <p class="item-desc">Pengembalian/Pembatalan</p>
                        </a>
                        <a href="/portal/product/list/banned/action" class="to-do-box-item">
                            <p class="item-title">0</p>
                            <p class="item-desc">Produk Diblokir/Diturunkan</p>
                        </a>
                        <a href="/portal/marketing/realtime-bidding/list" class="to-do-box-item">
                            <p class="item-title">6</p>
                            <p class="item-desc">Nom. Program Garansi</p>
                        </a>
                    </div>
                </div>


                <!-- Performa Toko -->
                <div class="card wide">
                    <div class="flex-between">
                        <h4>Performa Toko</h4>
                        <a href="#">Lainnya</a>
                    </div>
                    <div class="stats-row">
                        <div>Penjualan<br><strong>Rp0</strong><br><small>0,00%</small></div>
                        <div>Total Pengunjung<br><strong>1</strong></div>
                        <div>Jumlah Produk Diklik<br><strong>1</strong></div>
                        <div>Pesanan<br><strong>0</strong><br><small>0,00%</small></div>
                        <div>Tingkat Konversi<br><strong>0%</strong><br><small>0,00%</small></div>
                    </div>
                </div>

                <!-- Program Garansi Harga Terbaik -->
                <div class="card wide">
                    <div class="flex-between">
                        <h4>Program Garansi Harga Terbaik</h4>
                        <a href="#">Buka Program</a>
                    </div>
                    <div class="summary-row">
                        <span>Performa 7 Hari Terakhir</span>
                        <span>Jumlah Dilihat <strong>677.89x</strong></span>
                        <span>Pesanan <strong>349x</strong></span>
                        <span>Penjualan <strong>57.45x</strong></span>
                    </div>
                    <div class="product-slider">
                        <div class="product-card">
                            <img src="https://via.placeholder.com/80" alt="">
                            <div>
                                <strong>Basreng Paket Bundling</strong><br>
                                Harga: Rp34.500<br>
                                Harga Terbaik: Rp25.499<br>
                                Stok: <strong>Tidak ada batas</strong>
                            </div>
                        </div>
                        <div class="product-card">
                            <img src="https://via.placeholder.com/80" alt="">
                            <div>
                                <strong>Basreng Paket Bundling</strong><br>
                                Harga: Rp34.500<br>
                                Harga Terbaik: Rp35.000<br>
                                Stok: <strong>Tidak ada batas</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid bawah -->
                <div class="grid-bottom">
                    <div class="card">
                        <h4>Iklan Shopee</h4>
                        <p>Promosikan Produk</p>
                        <button>Buat Sekarang</button>
                    </div>
                    <div class="card">
                        <h4>Affiliate Marketing</h4>
                        <p>Penjualan: Rp67RB</p>
                        <button>Coba Sekarang</button>
                    </div>
                    <div class="card">
                        <h4>Livestream</h4>
                        <p>Buat Livestream sekarang dan tingkatkan konversi!</p>
                        <button>Buat Livestream</button>
                    </div>
                    <div class="card">
                        <h4>Promosi</h4>
                        <ul style="font-size: 13px;">
                            <li>Program Garansi Harga Terbaik</li>
                            <li>8.8 Grand Fashion Sale</li>
                            <li>Promo XTRA Free Trial</li>
                        </ul>
                    </div>
                </div>
            </main>

            <!-- Right Sidebar -->
            <aside class="rightbar" aria-label="Secondary information and news">
                <div class="card">
                    <h4>Performa Toko</h4>
                    <p style="color: green;">Baik</p>
                    <p>1 kriteria belum memenuhi target</p>
                </div>

                <div class="card">
                    <h4>Berita</h4>
                    <p>🔥 Voucher Udah Siap di Live-mu!</p>
                    <p style="font-size: 12px; color: #666;">14 Juli 2025</p>
                    <hr style="margin: 10px 0;">
                    <p>🔥 Biar Nggak Salah Pilih Affiliate!</p>
                    <p style="font-size: 12px; color: #666;">14 Juli 2025</p>
                </div>

                <div class="card">
                    <h4>Misi Penjual</h4>
                    <p>✅ Kamu telah menyelesaikan 1 misi</p>
                    <a href="#" style="font-size: 13px; color: #007bff;">Cek hadiah kamu.</a>
                    <hr style="margin: 10px 0;">
                    <p>🎯 Shopee Live pertama (&gt;30 menit)</p>
                    <p style="font-size: 13px; color: #555;">🎁 Dapatkan 3000 Koin Penjual</p>
                </div>
            </aside>
        </div>

        <!-- Sidebar Panel Kanan -->
        <div class="sidebar-panel">
            <div class="icon-item">
                <div class="badge">99+</div>
                <!-- Bell Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-bell-icon lucide-bell">
                    <path d="M10.268 21a2 2 0 0 0 3.464 0" />
                    <path
                        d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
                </svg>
            </div>

            <div class="icon-item">
                <!-- Headset Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-headset-icon lucide-headset">
                    <path
                        d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z" />
                    <path d="M21 16v2a4 4 0 0 1-4 4h-5" />
                </svg>
            </div>

            <div class="icon-item">
                <div class="badge">1</div>
                <!-- Chat Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-message-square-more-icon lucide-message-square-more">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    <path d="M8 10h.01" />
                    <path d="M12 10h.01" />
                    <path d="M16 10h.01" />
                </svg>
            </div>
        </div>


    </div>

</body>

</html>
