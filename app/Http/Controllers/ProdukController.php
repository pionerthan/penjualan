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
    public function index()
    {
        if (auth()->check() && auth()->user()->role === 'kasir') {
            abort(403, 'Halaman hanya untuk pembeli');
        }

        $produk = Produk::all();
        return view('auth.home', compact('produk'));
    }

    public function showBeliForm(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);
        return view('beli', compact('produk'));
    }

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

        if ($request->jumlah > $produk->Stok) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        // Simpan atau update pelanggan berdasarkan user_id dan nama
        $pelanggan = Pelanggan::where('user_id', Auth::id())
                              ->where('NamaPelanggan', $request->NamaPelanggan)
                              ->first();

        if (!$pelanggan) {
            $pelanggan = Pelanggan::create([
                'user_id' => Auth::id(),
                'NamaPelanggan' => $request->NamaPelanggan,
                'Alamat' => $request->Alamat,
                'NomorTelepon' => $request->NomorTelepon,
            ]);
        } else {
            $pelanggan->update([
                'Alamat' => $request->Alamat,
                'NomorTelepon' => $request->NomorTelepon,
            ]);
        }

        $subtotal = $produk->Harga * $request->jumlah;

        $penjualan = Penjualan::create([
            'TanggalPenjualan' => now(),
            'TotalHarga' => $subtotal,
            'PelangganID' => $pelanggan->PelangganID,
        ]);

        Detailpenjualan::create([
            'PenjualanID' => $penjualan->PenjualanID,
            'ProdukID' => $produk->ProdukID,
            'JumlahProduk' => $request->jumlah,
            'Subtotal' => $subtotal,
        ]);

        $produk->decrement('Stok', $request->jumlah);

        return redirect()->route('pembayaran', $penjualan->PenjualanID)
                         ->with('success', 'Pembelian berhasil. Silakan lanjut ke pembayaran.');
    }

    public function pembayaran($id)
    {
        $penjualan = Penjualan::with([
            'pelanggan',
            'detailpenjualan.produk'
        ])->where('PenjualanID', $id)->firstOrFail();

        return view('auth.pembayaran', compact('penjualan'));
    }
}
