<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
            color: #333;
        }

        h2, h3 {
            color: #2c3e50;
        }

        .card {
            background-color: #fff;
            padding: 20px 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: auto;
            margin-bottom: 30px;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: scale(1.01);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f7f7f7;
        }

        .highlight {
            font-size: 20px;
            font-weight: bold;
            color: #27ae60;
            background-color: #e8f5e9;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }

        a.button {
            display: inline-block;
            margin-top: 20px;
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        a.button:hover {
            background-color: #2980b9;
        }

        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Pembayaran</h2>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <h3>Informasi Pelanggan</h3>
        <p><strong>Nama:</strong> {{ $penjualan->pelanggan->NamaPelanggan }}</p>
        <p><strong>Alamat:</strong> {{ $penjualan->pelanggan->Alamat }}</p>
        <p><strong>No. Telepon:</strong> {{ $penjualan->pelanggan->NomorTelepon }}</p>
    </div>

    <div class="card">
        <h3>Detail Pembelian</h3>
        @if($penjualan->detailPenjualans && $penjualan->detailPenjualans->count())
            <table>
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
    </div>

    <div class="card">
        <h3>Total Pembayaran</h3>
        <div class="highlight" id="totalBayar">
            Rp{{ number_format($penjualan->TotalHarga, 0, ',', '.') }}
        </div>

        <a href="{{ route('home') }}" class="button">🏠 Kembali ke Beranda</a>
    </div>

    <script>
        // Efek flash highlight total
        document.addEventListener("DOMContentLoaded", function() {
            const totalDiv = document.getElementById('totalBayar');
            totalDiv.style.backgroundColor = '#ffeaa7';

            setTimeout(() => {
                totalDiv.style.transition = 'background-color 1s ease';
                totalDiv.style.backgroundColor = '#e8f5e9';
            }, 800);
        });
    </script>

</body>
</html>
