@extends('layouts.app')

@section('content')
<style>
    .checkout-container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 10px;
        font-family: 'Segoe UI', sans-serif;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    h2, h3 {
        text-align: center;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
    }

    table th, table td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: center;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin: 5px 0 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        background-color: #28a745;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        display: block;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #218838;
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .alert-success { background-color: #d4edda; color: #155724; }
    .alert-error   { background-color: #f8d7da; color: #721c24; }
</style>

<div class="checkout-container">
    <h2>🛒 Checkout Keranjang</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($produks as $produk)
                @php
                    $jumlah = $keranjang[$produk->ProdukID];
                    $subtotal = $produk->Harga * $jumlah;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $produk->NamaProduk }}</td>
                    <td>Rp{{ number_format($produk->Harga) }}</td>
                    <td>{{ $jumlah }}</td>
                    <td>Rp{{ number_format($subtotal) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>Rp{{ number_format($total) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <h3>📋 Data Pelanggan</h3>
    <form method="POST" action="{{ route('checkout.proses') }}">
        @csrf
        <label>Nama Pelanggan:</label>
        <input type="text" name="NamaPelanggan" id="nama_pelanggan" placeholder="Masukkan nama..." required>

        <label>Alamat:</label>
        <input type="text" name="Alamat" id="alamat" placeholder="Alamat pelanggan" required>

        <label>Nomor Telepon:</label>
        <input type="text" name="NomorTelepon" id="no_telp" placeholder="08xxxxxxxxxx" required>

        <button type="submit">✅ Checkout Sekarang</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let timer = null;

    $('#nama_pelanggan').on('input', function () {
        clearTimeout(timer);
        const nama = $(this).val().trim();

        if (nama.length > 0) {
            timer = setTimeout(() => {
                $.ajax({
                    url: "{{ route('pelanggan.cari') }}",
                    method: "GET",
                    data: { nama: nama },
                    success: function (res) {
                        if (res && res.Alamat && res.NomorTelepon) {
                            $('#alamat').val(res.Alamat);
                            $('#no_telp').val(res.NomorTelepon);
                        } else {
                            $('#alamat').val('');
                            $('#no_telp').val('');
                        }
                    },
                    error: function () {
                        alert("❌ Gagal mencari data pelanggan. Coba lagi.");
                    }
                });
            }, 500);
        } else {
            $('#alamat').val('');
            $('#no_telp').val('');
        }
    });
</script>
@endsection
