<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;

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
// Rute untuk Pembeli (Wajib Login)
// ===================
Route::middleware('auth')->group(function () {

    // ===================
    // Pembelian Langsung
    // ===================
    Route::get('/beli', [ProdukController::class, 'showBeliForm'])->name('beli.form');
    Route::post('/beli', [ProdukController::class, 'prosesBeli'])->name('beli.proses');

    // ===================
    // Keranjang
    // ===================
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::put('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');

    // ===================
    // Checkout & Transaksi
    // ===================
    Route::get('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [TransaksiController::class, 'proses'])->name('checkout.proses');

    // ===================
    // Pembayaran
    // ===================
    Route::get('/pembayaran/{id}', [TransaksiController::class, 'pembayaran'])->name('pembayaran');
});
