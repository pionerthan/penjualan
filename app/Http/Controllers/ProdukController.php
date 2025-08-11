<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Detailpenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    // Menampilkan halaman utama produk untuk pembeli
    public function index()
    {
        if (auth()->check() && auth()->user()->role === 'kasir') {
            abort(403, 'Halaman hanya untuk pembeli');
        }

        $produk = Produk::where('status', 'active')->get();
        $pelanggans = Pelanggan::where('user_id', Auth::id())->get();

        return view('auth.home', compact('produk', 'pelanggans'));
    }

    // Menampilkan form beli satu produk
    public function showBeliForm(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);
        return view('beli', compact('produk'));
    }

    // Proses beli satu produk langsung
    public function prosesBeli(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,ProdukID',
            'jumlah' => 'required|integer|min:1',
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string|max:255',
            'NomorTelepon' => 'required|string|max:20',
        ]);

        $produk = Produk::where('ProdukID', $request->produk_id)->firstOrFail();

        // Cek stok
        if ($request->jumlah > $produk->Stok) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        // Cari atau buat pelanggan baru
        $pelanggan = Pelanggan::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'NamaPelanggan' => $request->NamaPelanggan,
                'Alamat' => $request->Alamat,
                'NomorTelepon' => $request->NomorTelepon,
            ]
        );

        $subtotal = $produk->Harga * $request->jumlah;

        // Simpan penjualan
        $penjualan = Penjualan::create([
            'TanggalPenjualan' => now(),
            'TotalHarga' => $subtotal,
            'PelangganID' => $pelanggan->PelangganID,
        ]);

        // Simpan detail penjualan
        Detailpenjualan::create([
            'PenjualanID' => $penjualan->PenjualanID,
            'ProdukID' => $produk->ProdukID,
            'JumlahProduk' => $request->jumlah,
            'Subtotal' => $subtotal,
        ]);

        // Kurangi stok
        $produk->decrement('Stok', $request->jumlah);

        return redirect()
            ->route('pembayaran', $penjualan->PenjualanID)
            ->with('success', 'Pembelian berhasil. Silakan lanjut ke pembayaran.');
    }

    // Menampilkan halaman pembayaran
    public function pembayaran($id)
    {
        $penjualan = Penjualan::with([
            'pelanggan',
            'detailpenjualans.produk' // <- Pastikan nama relasi di model Penjualan benar
        ])->where('PenjualanID', $id)->firstOrFail();

        return view('auth.pembayaran', compact('penjualan'));
    }
}
