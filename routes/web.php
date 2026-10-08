<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes — Penjualan Toko
|--------------------------------------------------------------------------
*/

// ============================================================
// ROOT — redirect ke login
// ============================================================
Route::get('/', fn() => redirect('/login'));


// ============================================================
// AUTHENTIKASI
// ============================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


// ============================================================
// ONLINE SHOP (PUBLIC — tanpa login)
// ============================================================
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/product/{produk}', [ShopController::class, 'show'])->name('product');
    Route::get('/track', [ShopController::class, 'track'])->name('track');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/success/{kode}', [CheckoutController::class, 'success'])->name('success');
});


// ============================================================
// PANEL ADMIN / STAF (BUTUH LOGIN)
// ============================================================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ============ PRODUK ============
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/cari', [ProdukController::class, 'cari'])->name('produk.cari');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // ============ TRANSAKSI OFFLINE ============
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaksi}/struk', [TransaksiController::class, 'struk'])->name('transaksi.struk');

    // ============ LAPORAN ============
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'pdf'])->name('laporan.pdf');

    // ============ ORDER ONLINE ============
    // Semua role (admin, kasir, pemilik) boleh LIHAT
    Route::get('/orders', [TransaksiController::class, 'orders'])->name('transaksi.orders');
    Route::get('/orders/{transaksi}', [TransaksiController::class, 'orderDetail'])->name('transaksi.order_detail');

    // Hanya admin & kasir boleh UBAH STATUS
    Route::middleware('role:admin,kasir')->group(function () {
        Route::post('/orders/{transaksi}/status', [TransaksiController::class, 'updateOrderStatus'])->name('transaksi.update_status');
    });

    // ============ ADMIN ONLY ============
    Route::middleware('role:admin')->group(function () {

        // User
        Route::resource('user', UserController::class);
        Route::post('/user/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('user.reset-password');

        // Kategori
        Route::resource('kategori', KategoriController::class);

        // Log aktivitas
        Route::get('/log', [LogController::class, 'index'])->name('log.index');
        Route::get('/log/backup', [LogController::class, 'backup'])->name('log.backup');
        Route::post('/log/bersihkan', [LogController::class, 'bersihkan'])->name('log.bersihkan');
        Route::delete('/log/{log}', [LogController::class, 'destroy'])->name('log.destroy');
    });
});