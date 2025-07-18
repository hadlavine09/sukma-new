@php
    $role = DB::table('role_user')
        ->where('user_id', auth()->user()->id)
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->select('roles.*')
        ->first();
@endphp
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    $isToko = Auth::check() && Auth::user()->hasRole('toko');
    $imgSrc = 'https://randomuser.me/api/portraits/men/1.jpg'; // default image

    $kategori_toko = null;

    if ($isToko) {
        $toko = DB::table('tokos')
            ->where('pemilik_toko_id', Auth::user()->id)
            ->join('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
            ->select('tokos.logo_toko', 'kategori_tokos.nama_kategori_toko')
            ->first();

        if ($toko) {
            $kategori_toko = $toko->nama_kategori_toko;

            // Jika ada logo toko, ubah $imgSrc ke path storage
            if ($toko->logo_toko) {
                $imgSrc = asset('storage/' . $toko->logo_toko);
            }
        }
    }
@endphp

<div class="app-sidebar__user">
  <img class="app-sidebar__user-avatar" src="{{ $imgSrc }}" alt="User Image">
  <div>
    <p class="app-sidebar__user-name">{{ auth()->user()->username }}</p>

    @if ($kategori_toko)
        <p class="app-sidebar__user-designation">{{ $kategori_toko }}</p>
    @endif
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
    @endif
    <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-ui-checks"></i><span class="app-menu__label">Manajemen Transaksi</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
    <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{ route('transaksi.index')}}"><i class="icon bi bi-circle-fill"></i> Transaksi</a></li>
        <li><a class="treeview-item" href="{{ route('produk.index')}}"><i class="icon bi bi-circle-fill"></i> Laporan</a></li>
        <li><a class="treeview-item" href="{{ route('pengiriman.index')}}"><i class="icon bi bi-circle-fill"></i> Pengiriman</a></li>
    </ul>
    </li>

  </ul>
</aside>
