<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - {{ $produk->NamaProduk }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #5e4ba2 100%);
            margin: 0;
            padding: 0;
            color: white;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(8px);
        }

        .produk-wrapper {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .produk-wrapper img {
            width: 350px;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        .info-box {
            flex: 1;
            min-width: 300px;
        }

        h1 {
            margin-bottom: 10px;
            font-size: 2rem;
        }

        .price {
            margin: 10px 0;
            font-size: 1.5rem;
            color: #ffd700;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background: #3498db;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .btn:hover {
            background: #1f78b4;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background: #e17055;
            border-radius: 10px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container">

    <a class="back-btn" href="{{ route('home') }}">⟵ Kembali</a>

    <div class="produk-wrapper">
        <img src="{{ $produk->FotoURL ?? 'https://via.placeholder.com/350x300?text=No+Image' }}" alt="Foto Produk">

        <div class="info-box">
            <h1>{{ $produk->NamaProduk }}</h1>

            <div class="price">
                💵 Rp{{ number_format($produk->Harga) }}
            </div>

            <p><strong>Brand:</strong> {{ $produk->Brand ?? '-' }}</p>
            <p><strong>Stok:</strong> {{ $produk->Stok }}</p>

            <p style="margin-top:20px;">
                <strong>Deskripsi:</strong><br>
                {{ $produk->Deskripsi ?? 'Tidak ada deskripsi.' }}
            </p>

            @auth
            <a href="{{ route('home') }}#produk-{{ $produk->ProdukID }}" class="btn">
                🛒 Beli Sekarang
            </a>
            @else
            <a href="{{ route('login') }}" class="btn">
                Login untuk berbelanja
            </a>
            @endauth

        </div>
    </div>

</div>

</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
