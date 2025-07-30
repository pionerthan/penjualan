<h2>Produk Supermarket</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@auth
    <p>Halo, {{ auth()->user()->name }} |
       <form method="POST" action="/logout" style="display:inline">
            @csrf
            <button type="submit">Logout</button>
       </form>
    </p>
@else
    <a href="/login">Login</a> | <a href="/register">Daftar</a>
@endauth

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>
    @foreach($produk as $p)
        <tr>
            <td>{{ $p->NamaProduk }}</td>
            <td>Rp{{ number_format($p->Harga, 0, ',', '.') }}</td>
            <td>{{ $p->Stok }}</td>
            <td>
                @auth
                    <form method="POST" action="{{ route('beli.proses') }}">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $p->ProdukID }}">
                        <input type="number" name="jumlah" value="1" min="1" max="{{ $p->Stok }}" required>

                        <input type="text" name="NamaPelanggan" placeholder="Nama Pelanggan" required>
                        <input type="text" name="Alamat" placeholder="Alamat" required>
                        <input type="text" name="NomorTelepon" placeholder="Nomor Telepon" required>

                        <button type="submit">Beli</button>
                    </form>
                @else
                    <a href="/login">Login dulu</a>
                @endauth
            </td>
        </tr>
    @endforeach
</table>

<a href="{{ route('checkout') }}">Lanjut ke Checkout</a>
