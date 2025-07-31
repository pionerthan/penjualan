@extends('layouts.app') {{-- Ganti jika kamu pakai layout lain --}}

@section('content')
<div class="container">
    <h2 class="mb-4">Keranjang Belanja</h2>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if(count($keranjang) === 0)
        <p>Keranjang kamu masih kosong.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($produks as $produk)
                    @php
                        $jumlah = $keranjang[$produk->ProdukID];
                        $subtotal = $produk->Harga * $jumlah;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $produk->NamaProduk }}</td>
                        <td>Rp {{ number_format($produk->Harga, 0, ',', '.') }}</td>
                        <td>{{ $jumlah }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('keranjang.hapus', $produk->ProdukID) }}" onclick="return confirm('Hapus produk ini dari keranjang?')">Hapus</a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <br>
        <a href="{{ route('keranjang.kosongkan') }}" onclick="return confirm('Yakin ingin mengosongkan keranjang?')">🗑 Kosongkan Keranjang</a>

        <hr>

        <h3>Isi Data Pelanggan untuk Checkout</h3>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div>
                <label>Nama Pelanggan:</label>
                <input type="text" name="NamaPelanggan" required>
            </div>
            <div>
                <label>Alamat:</label>
                <input type="text" name="Alamat" required>
            </div>
            <div>
                <label>Nomor Telepon:</label>
                <input type="text" name="NomorTelepon" required>
            </div>
            <br>
            <button type="submit">🛒 Checkout Sekarang</button>
        </form>
    @endif
</div>
@endsection
