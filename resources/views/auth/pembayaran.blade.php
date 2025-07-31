<!DOCTYPE html>
<html>
<head>
    <title>Halaman Pembayaran</title>
</head>
<body>
    <h2>Pembayaran</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <h3>Informasi Pelanggan</h3>
    <p><strong>Nama:</strong> {{ $penjualan->pelanggan->NamaPelanggan }}</p>
    <p><strong>Alamat:</strong> {{ $penjualan->pelanggan->Alamat }}</p>
    <p><strong>No. Telepon:</strong> {{ $penjualan->pelanggan->NomorTelepon }}</p>

    <h3>Detail Pembelian</h3>
    @if($penjualan->detailPenjualans && $penjualan->detailPenjualans->count())
        <table border="1" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan->detailPenjualans as $item)
                    <tr>
                        <td>{{ $item->produk->NamaProduk ?? 'Produk tidak ditemukan' }}</td>
                        <td>Rp{{ number_format($item->produk->Harga ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $item->JumlahProduk }}</td>
                        <td>Rp{{ number_format($item->Subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada detail pembelian yang tersedia.</p>
    @endif

    <h3>Total Pembayaran: Rp{{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</h3>

    <br><br>
    <a href="{{ route('home') }}">Kembali ke Beranda</a>
</body>
</html>
