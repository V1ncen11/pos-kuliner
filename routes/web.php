<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Utama — Redirect ke Order
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $mejaTerisi = \App\Models\Pesanan::whereIn('status', ['menunggu_verifikasi', 'belum_bayar', 'diproses'])
        ->pluck('nomor_meja')
        ->toArray();
    return view('welcome', compact('mejaTerisi'));
})->name('home');

/*
|--------------------------------------------------------------------------
| PELANGGAN — Routes (Tanpa Auth)
|--------------------------------------------------------------------------
*/
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::post('/order/menu', [OrderController::class, 'menu'])->name('order.menu');
Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::get('/order/sukses/{kode}', [OrderController::class, 'sukses'])->name('order.sukses');

/*
|--------------------------------------------------------------------------
| AUTH — Login Admin
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN — Routes (Auth + Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard & Laporan
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan.index');
        
        // QR Code Meja
        Route::get('/qr-meja', [DashboardController::class, 'qrMeja'])->name('qr.meja');

        // Kasir (POS)
        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
        Route::post('/pos', [PosController::class, 'store'])->name('pos.store');

        // Pesanan
        Route::get('/pesanan', [DashboardController::class, 'pesanan'])->name('pesanan.index');
        Route::get('/pesanan/{id}', [DashboardController::class, 'detailPesanan'])->name('pesanan.detail');
        Route::get('/pesanan/{id}/cetak', [DashboardController::class, 'cetakStruk'])->name('pesanan.cetak');
        Route::patch('/pesanan/{id}/status', [DashboardController::class, 'updateStatus'])->name('pesanan.updateStatus');

        // Menu CRUD
        Route::resource('/menu', MenuController::class);
        Route::patch('/menu/{menu}/toggle', [MenuController::class, 'toggleTersedia'])->name('menu.toggle');

        // Notifikasi Pesanan Baru (Polling)
        Route::get('/notifications/check', [DashboardController::class, 'checkNewOrders'])->name('notifications.check');
    });
