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
    public function index(Request $request)
{
    if (auth()->check() && auth()->user()->role === 'kasir') {
        abort(403, 'Halaman hanya untuk pembeli');
    }

    $produk = Produk::query()
        ->where('status', 'active')

        // FILTER NAMA
        ->when($request->search, function ($q) use ($request) {
            $q->where('NamaProduk', 'like', '%' . $request->search . '%');
        })

        // FILTER HARGA MIN
        ->when($request->min, function ($q) use ($request) {
            $q->where('Harga', '>=', $request->min);
        })

        // FILTER HARGA MAX
        ->when($request->max, function ($q) use ($request) {
            $q->where('Harga', '<=', $request->max);
        })

        // FILTER KATEGORI
        ->when($request->kategori, function ($q) use ($request) {
            $q->where('kategori', $request->kategori);
        })

        // FILTER STOK TERSEDIA
        ->when($request->stock == "1", function ($q) {
            $q->where('Stok', '>', 0);
        })

        // SORTING
        ->when($request->sort, function ($q) use ($request) {
            if ($request->sort == "termurah") {
                $q->orderBy('Harga', 'asc');
            } elseif ($request->sort == "termahal") {
                $q->orderBy('Harga', 'desc');
            }
        })

        ->get();

    // Pelanggan tetap
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

    public function detail($id)
    {
        $produk = Produk::findOrFail($id);
        return view('auth.detail-produk', compact('produk'));
    }

}
