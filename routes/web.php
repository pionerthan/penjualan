<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ProfileController;

// Halaman umum
Route::get('/', [ProdukController::class, 'index'])->name('home');

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pembeli (auth wajib)
Route::middleware('auth')->group(function () {

    // Beli langsung (per produk)
    Route::get('/beli', [ProdukController::class, 'showBeliForm'])->name('beli.form');
    Route::post('/beli', [ProdukController::class, 'prosesBeli'])->name('beli.proses');

    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::put('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::post('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::delete('/keranjang/kosongkan', [KeranjangController::class, 'kosongkan'])->name('keranjang.kosongkan');

    // Checkout & pembayaran
    Route::get('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [TransaksiController::class, 'proses'])->name('checkout.proses');
    Route::get('/pembayaran/{id}', [TransaksiController::class, 'pembayaran'])->name('pembayaran');

    // web.php
    Route::get('/pelanggan/cari', [TransaksiController::class, 'cariPelanggan'])->name('pelanggan.cari');
    Route::post('/voucher/cek', [VoucherController::class, 'cek'])->name('voucher.cek');

    Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
    Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

    Route::get('/produk/{id}', [ProdukController::class, 'detail'])->name('produk.detail');

    Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');
    Route::get('/promo/{id}', [PromoController::class, 'show'])->name('promo.show'); // promo detail
    Route::post('/promo/claim', [PromoController::class, 'claimVoucher'])->name('promo.claim');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    

});
