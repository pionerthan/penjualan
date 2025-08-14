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
    public function checkout()
    {
        $keranjang = Session::get('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong.');
        }

        $produkIDs = array_keys($keranjang);
        $produks = Produk::whereIn('ProdukID', $produkIDs)->get();

        foreach ($produks as $produk) {
            if ($produk->status !== 'active') {
                return redirect()->route('keranjang.index')
                    ->with('error', "Produk {$produk->NamaProduk} tidak tersedia untuk dibeli.");
            }
        }

        return view('auth.checkout', compact('produks', 'keranjang'));
    }

    /**
     * Memproses transaksi dari keranjang.
     */
    public function proses(Request $request)
    {
        // Validasi input pelanggan
        $request->validate([
            'NamaPelanggan'   => 'required|string|max:255',
            'Alamat'          => 'required|string|max:255',
            'NomorTelepon'    => 'required|string|max:20',
        ]);

        $keranjang = Session::get('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong.');
        }

        // Simpan atau ambil data pelanggan
        $pelanggan = Pelanggan::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'NamaPelanggan' => $request->NamaPelanggan,
            ],
            [
                'Alamat' => $request->Alamat,
                'NomorTelepon' => $request->NomorTelepon,
            ]
        );

        $totalHarga = 0;
        $detail = [];

        // Validasi stok & hitung total
        foreach ($keranjang as $produkId => $jumlah) {
            $produk = Produk::findOrFail($produkId);

            if ($produk->Stok < $jumlah) {
                return back()->with('error', "Stok produk '{$produk->NamaProduk}' tidak mencukupi.");
            }

            $subtotal = $produk->Harga * $jumlah;
            $totalHarga += $subtotal;

            $detail[] = [
                'produk' => $produk,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ];
        }

        // Simpan penjualan
        $penjualan = Penjualan::create([
            'TanggalPenjualan' => now(),
            'TotalHarga' => $totalHarga,
            'PelangganID' => $pelanggan->PelangganID,
        ]);

        // Simpan detail penjualan & update stok
        foreach ($detail as $item) {
            Detailpenjualan::create([
                'PenjualanID'   => $penjualan->PenjualanID,
                'ProdukID'      => $item['produk']->ProdukID,
                'JumlahProduk'  => $item['jumlah'],
                'Subtotal'      => $item['subtotal'],
            ]);

            $item['produk']->decrement('Stok', $item['jumlah']);
        }

        // Kosongkan keranjang
        Session::forget('keranjang');

        return redirect()
            ->route('pembayaran', $penjualan->PenjualanID)
            ->with('success', 'Transaksi berhasil. Silakan lanjut ke halaman pembayaran.');
    }

    /**
     * Tampilkan halaman pembayaran setelah checkout.
     */
    public function pembayaran($id)
    {
        $penjualan = Penjualan::with(['pelanggan', 'detailpenjualans.produk'])
                        ->findOrFail($id);

        return view('auth.pembayaran', compact('penjualan'));
    }

    public function cariPelanggan(Request $request)
{
    $pelanggan = Pelanggan::where('NamaPelanggan', $request->nama)->first();

    if ($pelanggan) {
        return response()->json([
            'Alamat' => $pelanggan->Alamat,
            'NomorTelepon' => $pelanggan->NomorTelepon,
        ]);
    }

    return response()->json(null);
}
}