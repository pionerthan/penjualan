<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    // Menampilkan isi keranjang
    public function index()
    {
        $keranjang = Session::get('keranjang', []);
        $produkIDs = array_keys($keranjang);

        $produks = Produk::whereIn('ProdukID', $produkIDs)->get();

        return view('auth.keranjang', compact('produks', 'keranjang'));
    }

    // Menambahkan produk ke keranjang
    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,ProdukID',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produkId = $request->produk_id;
        $jumlah = $request->jumlah;

        $produk = Produk::dinfOrFail($produkID);

        if ($produk->status !== 'active') {
            return back()->with('error', 'Produk ini tidak tersedia untuk dibeli.');
        }

        $keranjang = Session::get('keranjang', []);

        if (isset($keranjang[$produkId])) {
            $keranjang[$produkId] += $jumlah;
        } else {
            $keranjang[$produkId] = $jumlah;
        }

        Session::put('keranjang', $keranjang);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Menghapus satu produk dari keranjang
    public function hapus($id)
{
    $keranjang = session()->get('keranjang', []);

    if (isset($keranjang[$id])) {
        unset($keranjang[$id]);
        session(['keranjang' => $keranjang]);
    }

    return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
}


    // Mengosongkan seluruh isi keranjang
    public function kosongkan()
    {
        Session::forget('keranjang');

        return redirect()->route('keranjang.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
