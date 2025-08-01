@extends('layouts.app') {{-- Ganti jika kamu pakai layout lain --}}

@section('content')
<style>
    .container {
        max-width: 900px;
        margin: auto;
        background: #ffffff;
        padding: 20px 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 8px;
    }

    h2, h3 {
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    thead {
        background-color: #f2f2f2;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    tbody tr:hover {
        background-color: #f9f9f9;
    }

    img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
    }

    a, button {
        text-decoration: none;
        background-color: #3498db;
        color: #fff;
        padding: 8px 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    a:hover, button:hover {
        background-color: #2980b9;
    }

    .danger {
        background-color: #e74c3c;
    }

    .danger:hover {
        background-color: #c0392b;
    }

    form input[type="text"] {
        width: 100%;
        padding: 8px 10px;
        margin-top: 6px;
        margin-bottom: 15px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    label {
        font-weight: bold;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .actions {
        display: flex;
        gap: 10px;
    }
</style>

<div class="container">
    <h2>🛒 Keranjang Belanja</h2>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if(count($keranjang) === 0)
        <p>Keranjang kamu masih kosong.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
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
                        <td><img src="{{ $produk->Foto }}" alt="{{ $produk->NamaProduk }}"></td>
                        <td>{{ $produk->NamaProduk }}</td>
                        <td>Rp {{ number_format($produk->Harga, 0, ',', '.') }}</td>
                        <td>{{ $jumlah }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td class="actions">
                            <form action="{{ route('keranjang.hapus', $produk->ProdukID) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?')" style="display:inline;">
    @csrf
    <button type="submit" class="danger">Hapus</button>
</form>

                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4"><strong>Total</strong></td>
                    <td colspan="2"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="actions" style="margin-bottom: 30px;">
            <a href="{{ route('keranjang.kosongkan') }}" class="danger"
               onclick="return confirm('Yakin ingin mengosongkan keranjang?')">🗑 Kosongkan Keranjang</a>
        </div>

        <hr>
        <h3>🧾 Isi Data Pelanggan untuk Checkout</h3>

        <form action="{{ route('checkout.proses') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="NamaPelanggan">Nama Pelanggan:</label>
                <input type="text" name="NamaPelanggan" id="NamaPelanggan" required>
            </div>
            <div class="form-group">
                <label for="Alamat">Alamat:</label>
                <input type="text" name="Alamat" id="Alamat" required>
            </div>
            <div class="form-group">
                <label for="NomorTelepon">Nomor Telepon:</label>
                <input type="text" name="NomorTelepon" id="NomorTelepon" required>
            </div>

            <button type="submit">✅ Checkout Sekarang</button>
        </form>
    @endif
</div>
@endsection
