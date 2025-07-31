<!DOCTYPE html>
<html>
<head>
    <title>Produk Supermarket</title>
</head>
<body>

    <h2>Produk Supermarket</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @auth
        <p>Halo, {{ auth()->user()->name }} |
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit">Logout</button>
        </form>
        </p>
    @else
        <a href="{{ route('login') }}">Login</a> | <a href="{{ route('register') }}">Daftar</a>
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
            <td>Rp{{ number_format($p->Harga) }}</td>
            <td>{{ $p->Stok }}</td>
            <td>
                @auth
                <form method="POST" action="{{ route('beli.proses') }}">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $p->ProdukID }}">
                    <input type="number" name="jumlah" value="1" min="1" max="{{ $p->Stok }}" required>

                    <br>

                    {{-- Pilih pelanggan lama --}}
                    @if(isset($pelanggans) && $pelanggans->count() > 0)
                        <select onchange="isiDataPelanggan(this, '{{ $p->ProdukID }}')">
                            <option value="">-- Pilih Pelanggan Lama --</option>
                            @foreach($pelanggans as $pelanggan)
                                <option 
                                    value="{{ $pelanggan->NamaPelanggan }}"
                                    data-alamat="{{ $pelanggan->Alamat }}"
                                    data-telepon="{{ $pelanggan->NomorTelepon }}">
                                    {{ $pelanggan->NamaPelanggan }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    {{-- Input pelanggan --}}
                    <input type="text" name="NamaPelanggan" id="nama_{{ $p->ProdukID }}" placeholder="Nama Pelanggan" required>
                    <input type="text" name="Alamat" id="alamat_{{ $p->ProdukID }}" placeholder="Alamat" required>
                    <input type="text" name="NomorTelepon" id="telepon_{{ $p->ProdukID }}" placeholder="Nomor Telepon" required>

                    <br>
                    <button type="submit">Beli</button>
                </form>
                @else
                    <a href="{{ route('login') }}">Login dulu</a>
                @endauth
            </td>
        </tr>
        @endforeach
    </table>

    <br>
    @auth
        <a href="{{ route('checkout') }}">🛒 Lanjut ke Checkout</a>
    @endauth

    <script>
    function isiDataPelanggan(select, produkId) {
        const selected = select.options[select.selectedIndex];
        const nama = selected.value;
        const alamat = selected.getAttribute('data-alamat');
        const telepon = selected.getAttribute('data-telepon');

        document.getElementById('nama_' + produkId).value = nama || '';
        document.getElementById('alamat_' + produkId).value = alamat || '';
        document.getElementById('telepon_' + produkId).value = telepon || '';
    }
    </script>

</body>
</html>
