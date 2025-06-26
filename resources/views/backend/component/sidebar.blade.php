@php
    $role = DB::table('role_user')
        ->where('user_id', auth()->user()->id)
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->select('roles.*')
        ->first();
@endphp
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
    <div>
      <p class="app-sidebar__user-name">{{ auth()->user()->username }}</p>
      <p class="app-sidebar__user-designation">Frontend Developer</p>
    </div>
  </div>
  <ul class="app-menu">
    <li><a class="app-menu__item active" href="{{ route('dashboard')}}"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
    @if ($role && $role->id == 1)
        <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-laptop"></i><span class="app-menu__label">User Management</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
        <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{ route('user.index')}}"><i class="icon bi bi-circle-fill"></i> User</a></li>
            <li><a class="treeview-item" href="{{ route('role.index') }}" target="_blank" rel="noopener"><i class="icon bi bi-circle-fill"></i> Role</a></li>
            <li><a class="treeview-item" href="{{ route('permission.index')}}"><i class="icon bi bi-circle-fill"></i> Permissions</a></li>
            <li><a class="treeview-item" href="{{ route('hakakses.index')}}"><i class="icon bi bi-circle-fill"></i> Hakakses</a></li>
        </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-laptop"></i><span class="app-menu__label">Manajemen Toko</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
        <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{ route('kategori_toko.index')}}"><i class="icon bi bi-circle-fill"></i> Kategori Toko</a></li>
            <li><a class="treeview-item" href="{{ route('izin_toko.index')}}"><i class="icon bi bi-circle-fill"></i> Pendaftaran Toko</a></li>
            <li><a class="treeview-item" href="{{ route('toko.index')}}"><i class="icon bi bi-circle-fill"></i> Toko</a></li>
        </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-ui-checks"></i><span class="app-menu__label">Manajemen Produk</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
        <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{ route('kategori_produk.index')}}"><i class="icon bi bi-circle-fill"></i> Kategori Produk</a></li>
            <li><a class="treeview-item" href="{{ route('tag.index')}}"><i class="icon bi bi-circle-fill"></i> Tag</a></li>
        </ul>
        </li>
    @endif
    @if ($role && $role->id == 2)
        <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-ui-checks"></i><span class="app-menu__label">Manajemen Produk</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
        <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{ route('kategori_produk.index')}}"><i class="icon bi bi-circle-fill"></i> Kategori Produk</a></li>
            <li><a class="treeview-item" href="{{ route('tag.index')}}"><i class="icon bi bi-circle-fill"></i> Tag</a></li>
            <li><a class="treeview-item" href="{{ route('produk.index')}}"><i class="icon bi bi-circle-fill"></i> Produk</a></li>
        </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-ui-checks"></i><span class="app-menu__label">Manajemen Transaksi</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
        <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{ route('cart.index')}}"><i class="icon bi bi-circle-fill"></i> Keranjang</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Checkout</a></li>
            <li><a class="treeview-item" href="{{ route('produk.index')}}"><i class="icon bi bi-circle-fill"></i> Transaksi</a></li>
        </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-ui-checks"></i><span class="app-menu__label">Manajemen Material</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
        <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{ route('material.index')}}"><i class="icon bi bi-circle-fill"></i> Material</a></li>
            <li><a class="treeview-item" href="{{ route('supplier.index')}}"><i class="icon bi bi-circle-fill"></i> Supplier</a></li>
            <li><a class="treeview-item" href="{{ route('transaksi_material.index')}}"><i class="icon bi bi-circle-fill"></i> Transaksi</a></li>
        </ul>
        </li>
    @endif

  </ul>
</aside>
