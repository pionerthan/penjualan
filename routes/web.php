<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;

// ===================
// Halaman Utama
// ===================
Route::get('/', [ProdukController::class, 'index'])->name('home');

// ===================
// Auth Routes
// ===================
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===================
// Rute untuk Pembeli (Harus login)
// ===================
Route::middleware('auth')->group(function () {
    // Tampilkan form beli (jika dipakai, bisa dihapus kalau langsung beli dari home)
    Route::get('/beli', [ProdukController::class, 'showBeliForm'])->name('beli.form');

    // Proses pembelian langsung
    Route::post('/beli', [ProdukController::class, 'prosesBeli'])->name('beli.proses');

    // Halaman pembayaran setelah beli
    Route::get('/pembayaran/{id}', [ProdukController::class, 'pembayaran'])->name('pembayaran');

    // (Jika kamu gunakan keranjang + checkout)
    Route::get('/checkout', [ProdukController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [ProdukController::class, 'processCheckout'])->name('checkout.process');
});
