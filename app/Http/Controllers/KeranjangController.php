<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    // Tampilkan isi keranjang
    public function index()
    {
        $keranjang = Session::get('keranjang', []);
        $produkIDs = array_keys($keranjang);
        $produks = Produk::whereIn('ProdukID', $produkIDs)->get();

        return view('auth.keranjang', compact('produks', 'keranjang'));
    }

    // Tambah ke keranjang
    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,ProdukID',
            'jumlah' => 'required|integer|min:1',
        ]);

        $keranjang = Session::get('keranjang', []);
        $produkId = $request->produk_id;
        $jumlahBaru = $request->jumlah;

        if (isset($keranjang[$produkId])) {
            $keranjang[$produkId] += $jumlahBaru;
        } else {
            $keranjang[$produkId] = $jumlahBaru;
        }

        Session::put('keranjang', $keranjang);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Hapus produk dari keranjang
    public function hapus($produkId)
    {
        $keranjang = Session::get('keranjang', []);

        if (isset($keranjang[$produkId])) {
            unset($keranjang[$produkId]);
            Session::put('keranjang', $keranjang);
        }

        return redirect()->route('keranjang.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    // Kosongkan seluruh keranjang
    public function kosongkan()
    {
        Session::forget('keranjang');
        return redirect()->route('keranjang.index')->with('success', 'Keranjang dikosongkan.');
    }
}
