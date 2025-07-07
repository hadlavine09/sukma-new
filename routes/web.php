<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiMaterial;
use App\Http\Controllers\IzinTokoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UmkmAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\DetailProdukController;
use App\Http\Controllers\KategoriTokoController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\UserManagement\RoleController;
use App\Http\Controllers\UserManagement\UserController;
use App\Http\Controllers\UserManagement\HakAksesController;
use App\Http\Controllers\UserManagement\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Route::get('/redirectTo', [LoginController::class, 'redirectTo'])->name('redirectTo');
    Route::get('registertoko', [RegisterController::class, 'showRegisterToko'])->name('registertoko');
    Route::get('loginToko', [LoginController::class, 'showLoginToko'])->name('LoginToko');
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register2');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/register-action', [RegisterController::class, 'register'])->name('register.post');
    Route::post('/login-toko', [LoginController::class, 'logintoko'])->name('logintoko.post');
    Route::post('/register-toko', [RegisterController::class, 'registertoko'])->name('register.toko');
});

Route::get('lang/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'id'])) {
        session(['locale' => $lang]);
        app()->setLocale($lang);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/daftar-umkm', [UmkmAuthController::class, 'index'])->name('umkm.register');
Route::get('/alur-umkm', [UmkmAuthController::class, 'alur'])->name('umkm.alur');

Route::get('/', function () {
    return view('frontend.produk');
});

// Routes yang hanya bisa diakses oleh user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Routes untuk admin dan superadmin
    Route::middleware('role:toko|superadmin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/aksesDashboard', [DashboardController::class, 'aksesDashboard'])->name('aksesDashboard');
    });
    Route::middleware('role:toko')->group(function () {
        // Route::get('/dashboard-toko', [IzinTokoController::class, 'dashboard_toko'])->name('dashboardtoko');
        Route::get('/verifikasi-toko', [IzinTokoController::class, 'verifikasi_toko'])->name('verifikasitoko');
        Route::post('/verifikasi-toko/{step}', [IzinTokoController::class, 'verifikasi_toko_store'])->name('verifikasitokostore');
        Route::get('/verifikasi-toko/wait', [IzinTokoController::class, 'waitPage'])->name('verifikasi_toko.wait');
    });

    // Routes yang hanya untuk role "user"
    Route::middleware('role:user')->group(function () {
        Route::get('/Home', function () {
            return view('frontend.produk');
        });
        Route::get('/kategori/{nama_kategori_toko}', [KategoriProdukController::class, 'detail_kategori_toko'])->name('frontend.detail_kategori_toko');
        Route::get('/kategori/{nama_kategori_toko}/{nama_kategori_produk}', [KategoriProdukController::class, 'detail_kategori_produk'])->name('frontend.detail_kategori_produk');
        Route::get('/detail/{nama_produk}', [DetailProdukController::class, 'detailproduk'])->name('frontend.detailproduk');
        Route::post('tambahkeranjang', [CartController::class, 'tambahkeranjang'])->name('frontend.tambahkeranjang');
        Route::get('keranjang', [CartController::class, 'keranjang'])->name('frontend.keranjang');
        Route::get('keranjang_down', [CartController::class, 'keranjang_dropdown'])->name('frontend.keranjang_down');
        Route::post('prepare-checkout', [CartController::class, 'prepareCheckout'])->name('frontend.prepareCheckout');
        Route::get('checkout/{kode}', [CartController::class, 'checkout'])->name('frontend.checkout');
        // Rute untuk menyimpan alamat yang dipilih
        Route::post('/checkout/simpan-alamat', [CartController::class, 'simpanAlamat'])->name('checkout.simpanAlamat');
        Route::post('/checkout/pilih-alamat', [CartController::class, 'pilihAlamat'])->name('checkout.pilihAlamat');
        Route::post('/checkout/pilih-voucher', [CartController::class, 'pilihVoucher'])->name('checkout.pilihVoucher');

        Route::get('checkoutstore', [CartController::class, 'checkoutstore'])->name('frontend.checkoutstore');
        Route::post('cartupdate', [CartController::class, 'cartupdate'])->name('frontend.cartupdate');
        Route::delete('keranjang/destroy/{id}', [CartController::class, 'destroy'])->name('frontend.cartdestroy');

        Route::prefix('profile')->group(function () {
            Route::get('/', function () {
                return view('frontend.profile.profile');
            })->name('profile.index');

            Route::get('/get-users', [ProfileController::class, 'getUsers'])->name('profile.getUsers');

            // Menu sidebar lainnya
            Route::get('/bank-kartu', [ProfileController::class, 'bankKartu'])->name('profile.bank-kartu');
            Route::get('/alamat', [ProfileController::class, 'alamat'])->name('profile.alamat');
            Route::get('/ubah-password', [ProfileController::class, 'ubahPassword'])->name('profile.ubah-password');
            Route::get('/notifikasi-setting', [ProfileController::class, 'notifikasiSetting'])->name('profile.notifikasi-setting');
            Route::get('/privasi-setting', [ProfileController::class, 'privasiSetting'])->name('profile.privasi-setting');

            Route::get('/pesanan', [ProfileController::class, 'pesanan'])->name('profile.pesanan');
            Route::get('/pesanan/{id}', [ProfileController::class, 'detailPesanan'])->name('profile.pesanan.detail');
            Route::get('/notifikasi', [ProfileController::class, 'notifikasi'])->name('profile.notifikasi');
            Route::get('/voucher', [ProfileController::class, 'voucher'])->name('profile.voucher');
            Route::get('/koin', [ProfileController::class, 'koin'])->name('profile.koin');
        });
    });

    // Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::prefix('UserManagement')->group(function () {
    Route::prefix('User')->group(function () {
        Route::get('index', [UserController::class, 'index'])->name('user.index');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::get('edit', [UserController::class, 'edit'])->name('user.edit');
        Route::get('show', [UserController::class, 'show'])->name('user.show');
    });

    Route::prefix('Role')->group(function () {
        Route::get('index', [RoleController::class, 'index'])->name('role.index');
        Route::get('create', [RoleController::class, 'create'])->name('role.create');
        Route::get('edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::get('show', [RoleController::class, 'show'])->name('role.show');
    });

    Route::prefix('Permission')->group(function () {
        Route::get('index', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::get('show/{id}', [PermissionController::class, 'show'])->name('permission.show');
        Route::post('destroy', [PermissionController::class, 'destroy'])->name('permission.destroy');
        Route::put('update/{id}', [PermissionController::class, 'update'])->name('permission.update');
    });

    Route::prefix('Hakakses')->group(function () {
        Route::get('index', [HakAksesController::class, 'index'])->name('hakakses.index');
        Route::get('create', [HakAksesController::class, 'create'])->name('hakakses.create');
        Route::post('store', [HakAksesController::class, 'store'])->name('hakakses.store');
        Route::put('update/{id}', [HakAksesController::class, 'update'])->name('hakakses.update');
        Route::post('destroy', [HakAksesController::class, 'destroy'])->name('hakakses.destroy');
        Route::get('edit/{id}', [HakAksesController::class, 'edit'])->name('hakakses.edit');
        Route::get('show/{id}', [HakAksesController::class, 'show'])->name('hakakses.show');
    });
});

Route::prefix('manajemen-toko')->group(function () {
    Route::prefix('kategori-toko')->group(function () {
        Route::get('/', [KategoriTokoController::class, 'index'])->name('kategori_toko.index');
        Route::get('create', [KategoriTokoController::class, 'create'])->name('kategori_toko.create');
        Route::post('store', [KategoriTokoController::class, 'store'])->name('kategori_toko.store');
        Route::get('edit/{id}', [KategoriTokoController::class, 'edit'])->name('kategori_toko.edit');
        Route::get('show', [KategoriTokoController::class, 'show'])->name('kategori_toko.show');
        Route::put('update/{id}', [KategoriTokoController::class, 'update'])->name('kategori_toko.update');
        Route::post('destroy', [KategoriTokoController::class, 'destroy'])->name('kategori_toko.destroy');
    });
    Route::prefix('tag')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('tag.index');
        Route::get('create', [TagController::class, 'create'])->name('tag.create');
        Route::post('store', [TagController::class, 'store'])->name('tag.store');
        Route::put('update/{id}', [TagController::class, 'update'])->name('tag.update');
        Route::post('destroy', [TagController::class, 'destroy'])->name('tag.destroy');
        Route::get('edit/{id}', [TagController::class, 'edit'])->name('tag.edit');
        Route::get('show/{id}', [TagController::class, 'show'])->name('tag.show');
    });
    Route::prefix('kategori-produk')->group(function () {
        Route::get('/', [KategoriProdukController::class, 'index'])->name('kategori_produk.index');
        Route::get('create', [KategoriProdukController::class, 'create'])->name('kategori_produk.create');
        Route::post('store', [KategoriProdukController::class, 'store'])->name('kategori_produk.store');
        Route::put('update/{id}', [KategoriProdukController::class, 'update'])->name('kategori_produk.update');
        Route::post('destroy', [KategoriProdukController::class, 'destroy'])->name('kategori_produk.destroy');
        Route::get('edit/{id}', [KategoriProdukController::class, 'edit'])->name('kategori_produk.edit');
        Route::get('show/{id}', [KategoriProdukController::class, 'show'])->name('kategori_produk.show');
    });
    Route::prefix('daftar-toko')->group(function () {
        Route::get('/', [IzinTokoController::class, 'index'])->name('izin_toko.index');
        Route::get('create', [IzinTokoController::class, 'create'])->name('izin_toko.create');
        Route::post('store', [IzinTokoController::class, 'store'])->name('izin_toko.store');
        Route::get('edit/{id}', [IzinTokoController::class, 'edit'])->name('izin_toko.edit');
        Route::get('show/{id}', [IzinTokoController::class, 'show'])->name('izin_toko.show');
        Route::put('update/{id}', [IzinTokoController::class, 'update'])->name('izin_toko.update');
        Route::post('destroy', [IzinTokoController::class, 'destroy'])->name('izin_toko.destroy');
        Route::post('destroy', [IzinTokoController::class, 'destroy'])->name('izin_toko.verifikasi');

        Route::post('izinkan', [IzinTokoController::class, 'izinkan'])->name('izin_toko.izinkan');
        Route::post('tidak_izinkan', [IzinTokoController::class, 'tidak_izinkan'])->name('izin_toko.tidak_izinkan');
    });
    Route::prefix('toko')->group(function () {
        Route::get('/', [TokoController::class, 'index'])->name('toko.index');
        Route::get('create', [TokoController::class, 'create'])->name('toko.create');
        Route::post('store', [TokoController::class, 'store'])->name('toko.store');
        Route::get('edit/{id}', [TokoController::class, 'edit'])->name('toko.edit');
        Route::get('show/{kode_toko}', [TokoController::class, 'show'])->name('toko.show');
        Route::put('update/{id}', [TokoController::class, 'update'])->name('toko.update');
        Route::post('destroy', [TokoController::class, 'destroy'])->name('toko.destroy');
    });
});

Route::prefix('manajemen-produk')->group(function () {
    Route::prefix('produk')->group(function () {
        Route::post('/produk/tagkategori', [ProdukController::class, 'tagkategori'])->name('produk.tagkategori');

        Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('store', [ProdukController::class, 'store'])->name('produk.store');
        Route::put('update/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::post('destroy', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::get('show/{id}', [ProdukController::class, 'show'])->name('produk.show');
    });
    Route::prefix('supplier')->group(function () {
        Route::get('index', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::put('update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::post('destroy', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::get('show/{id}', [SupplierController::class, 'show'])->name('supplier.show');
    });
});

Route::prefix('Manajemen-Material')->group(function () {
    Route::prefix('Material')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('material.index');
        Route::get('create', [MaterialController::class, 'create'])->name('material.create');
        Route::post('store', [MaterialController::class, 'store'])->name('material.store');
        Route::put('update/{id}', [MaterialController::class, 'update'])->name('material.update');
        Route::post('destroy', [MaterialController::class, 'destroy'])->name('material.destroy');
        Route::get('edit/{id}', [MaterialController::class, 'edit'])->name('material.edit');
        Route::get('show/{id}', [MaterialController::class, 'show'])->name('material.show');
    });
    Route::prefix('supplier')->group(function () {
        Route::get('index', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::put('update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::post('destroy', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::get('show/{id}', [SupplierController::class, 'show'])->name('supplier.show');
    });
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiMaterial::class, 'index'])->name('transaksi_material.index');
        Route::get('create', [TransaksiMaterial::class, 'create'])->name('transaksi_material.create');
        Route::post('store', [TransaksiMaterial::class, 'store'])->name('transaksi_material.store');
        Route::put('update/{id}', [TransaksiMaterial::class, 'update'])->name('transaksi_material.update');
        Route::post('destroy', [TransaksiMaterial::class, 'destroy'])->name('transaksi_material.destroy');
        Route::get('edit/{id}', [TransaksiMaterial::class, 'edit'])->name('transaksi_material.edit');
        Route::get('show/{id}', [TransaksiMaterial::class, 'show'])->name('transaksi_material.show');
    });
});
Route::prefix('Manajemen-Transaksi')->group(function () {
    Route::prefix('Cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::get('create', [CartController::class, 'create'])->name('cart.create');
        // Route::get('checkout/{selected}', [CartController::class, 'checkout'])->name('cart.checkout');
        // Route::get('checkoutstore', [CartController::class, 'checkoutstore'])->name('cart.checkoutstore');
        Route::post('store', [CartController::class, 'store'])->name('cart.store');
        Route::put('update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    });
    Route::prefix('supplier')->group(function () {
        Route::get('index', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::put('update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::post('destroy', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::get('show/{id}', [SupplierController::class, 'show'])->name('supplier.show');
    });
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiMaterial::class, 'index'])->name('transaksi_material.index');
        Route::get('create', [TransaksiMaterial::class, 'create'])->name('transaksi_material.create');
        Route::post('store', [TransaksiMaterial::class, 'store'])->name('transaksi_material.store');
        Route::put('update/{id}', [TransaksiMaterial::class, 'update'])->name('transaksi_material.update');
        Route::post('destroy', [TransaksiMaterial::class, 'destroy'])->name('transaksi_material.destroy');
        Route::get('edit/{id}', [TransaksiMaterial::class, 'edit'])->name('transaksi_material.edit');
        Route::get('show/{id}', [TransaksiMaterial::class, 'show'])->name('transaksi_material.show');
    });
});
Route::prefix('FrontEnd')->group(function () {
    Route::get('GetTagFrontEnd', [ProdukController::class, 'GetTagFrontEnd'])->name('frontend.GetTagFrontEnd');
    Route::get('GetTagFrontEnd', [ProdukController::class, 'GetTagFrontEnd'])->name('frontend.GetTagFrontEnd');
    Route::get('GetKategoriTokoFrontEnd', [ProdukController::class, 'GetKategoriTokoFrontEnd'])->name('frontend.GetKategoriTokoFrontEnd');
    Route::get('GetKategoriProdukFrontEnd', [ProdukController::class, 'GetKategoriProdukFrontEnd'])->name('frontend.GetKategoriProdukFrontEnd');
    Route::get('GetProdukFrontEnd', [ProdukController::class, 'GetProdukFrontEnd'])->name('frontend.GetProdukFrontEnd');
    Route::get('GetSreachProdukFrontEnd', [ProdukController::class, 'GetSreachProdukFrontEnd'])->name('frontend.GetSreachProdukFrontEnd');
    Route::get('GetKeranjangFrontEnd', [ProdukController::class, 'GetKeranjangFrontEnd'])->name('frontend.GetKeranjangFrontEnd');
    Route::get('GetProdukDetailKategoriFrontEnd', [ProdukController::class, 'GetProdukDetailKategoriFrontEnd'])->name('frontend.GetProdukDetailKategoriFrontEnd');
    Route::get('GetDetailProdukFrontEnd', [ProdukController::class, 'GetDetailProdukFrontEnd'])->name('frontend.GetDetailProdukFrontEnd');
    Route::get('AddToCartFrontEnd', [ProdukController::class, 'AddToCartFrontEnd'])->name('frontend.AddToCartFrontEnd');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
