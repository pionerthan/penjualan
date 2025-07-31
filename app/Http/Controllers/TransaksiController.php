<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Detailpenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    // Menampilkan halaman checkout (dari keranjang)
    public function checkout()
    {
        $keranjang = Session::get('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong.');
        }

        $produkIDs = array_keys($keranjang);
        $produks = Produk::whereIn('ProdukID', $produkIDs)->get();

        return view('auth.checkout', compact('produks', 'keranjang'));
    }

    // Proses checkout keranjang
    public function proses(Request $request)
    {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string|max:255',
            'NomorTelepon' => 'required|string|max:20',
        ]);

        $keranjang = Session::get('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong.');
        }

        $pelanggan = Pelanggan::firstOrCreate([
            'user_id' => Auth::id(),
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NomorTelepon' => $request->NomorTelepon,
        ]);

        $totalHarga = 0;
        $detail = [];
        foreach ($keranjang as $produkId => $jumlah) {
            $produk = Produk::findOrFail($produkId);

            if ($produk->Stok < $jumlah) {
                return back()->with('error', "Stok produk {$produk->NamaProduk} tidak mencukupi.");
            }

            $subtotal = $produk->Harga * $jumlah;
            $totalHarga += $subtotal;

            $detail[] = [
                'produk' => $produk,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ];
        }

        $penjualan = Penjualan::create([
            'TanggalPenjualan' => now(),
            'TotalHarga' => $totalHarga,
            'PelangganID' => $pelanggan->PelangganID,
        ]);

        foreach ($detail as $item) {
            Detailpenjualan::create([
                'PenjualanID' => $penjualan->PenjualanID,
                'ProdukID' => $item['produk']->ProdukID,
                'JumlahProduk' => $item['jumlah'],
                'Subtotal' => $item['subtotal'],
            ]);

            $item['produk']->decrement('Stok', $item['jumlah']);
        }

        Session::forget('keranjang');

        return redirect()->route('pembayaran', $penjualan->PenjualanID)
                         ->with('success', 'Transaksi berhasil. Silakan lanjut ke pembayaran.');
    }

    // Menampilkan halaman pembayaran
    public function pembayaran($id)
    {
        $penjualan = Penjualan::with([
            'pelanggan',
            'detailpenjualans.produk'
        ])->findOrFail($id);

        return view('auth.pembayaran', compact('penjualan'));
    }
}
