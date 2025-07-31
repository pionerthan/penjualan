<h2>Checkout Keranjang</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
@endif

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
    </tr>
    @php $total = 0; @endphp
    @foreach($keranjang as $item)
        @php $subtotal = $item['harga'] * $item['jumlah']; $total += $subtotal; @endphp
        <tr>
            <td>{{ $item['nama'] }}</td>
            <td>Rp{{ number_format($item['harga']) }}</td>
            <td>{{ $item['jumlah'] }}</td>
            <td>Rp{{ number_format($subtotal) }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3"><strong>Total</strong></td>
        <td><strong>Rp{{ number_format($total) }}</strong></td>
    </tr>
</table>

<h3>Data Pelanggan</h3>
<form method="POST" action="{{ route('checkout.proses') }}">
    @csrf
    <input type="text" name="NamaPelanggan" placeholder="Nama Pelanggan" required><br>
    <input type="text" name="Alamat" placeholder="Alamat" required><br>
    <input type="text" name="NomorTelepon" placeholder="Nomor Telepon" required><br><br>

    <button type="submit">Proses Checkout</button>
</form>
