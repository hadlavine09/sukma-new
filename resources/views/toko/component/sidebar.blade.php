<!-- Sidebar menu Admin Toko -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/2.jpg" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">{{ Auth::user()->username }}</p>
            <p class="app-sidebar__user-designation">Admin Toko</p>
        </div>
    </div>

    <ul class="app-menu">
        <li>
            <a class="app-menu__item active" href="/admin-toko/dashboard">
                <i class="app-menu__icon bi bi-speedometer"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon bi bi-shop"></i>
                <span class="app-menu__label">Toko Saya</span>
                <i class="treeview-indicator bi bi-chevron-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="/admin-toko/produk"><i class="icon bi bi-circle-fill"></i> Produk</a>
                </li>
                <li><a class="treeview-item" href="/admin-toko/kategori"><i class="icon bi bi-circle-fill"></i> Kategori
                        Produk</a></li>
                <li><a class="treeview-item" href="/admin-toko/tag"><i class="icon bi bi-circle-fill"></i> Tag
                        Produk</a></li>
            </ul>
        </li>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon bi bi-bag-check"></i>
                <span class="app-menu__label">Transaksi</span>
                <i class="treeview-indicator bi bi-chevron-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="/admin-toko/pesanan"><i class="icon bi bi-circle-fill"></i> Pesanan
                        Masuk</a></li>
                <li><a class="treeview-item" href="/admin-toko/transaksi"><i class="icon bi bi-circle-fill"></i> Riwayat
                        Transaksi</a></li>
                <li><a class="treeview-item" href="/admin-toko/pengiriman"><i class="icon bi bi-circle-fill"></i>
                        Pengiriman</a></li>
            </ul>
        </li>

        <li>
            <a class="app-menu__item" href="/admin-toko/laporan">
                <i class="app-menu__icon bi bi-bar-chart"></i>
                <span class="app-menu__label">Laporan Penjualan</span>
            </a>
        </li>

        <li>
            <a class="app-menu__item" href="/admin-toko/pengaturan">
                <i class="app-menu__icon bi bi-gear"></i>
                <span class="app-menu__label">Pengaturan</span>
            </a>
        </li>
    </ul>
</aside>
