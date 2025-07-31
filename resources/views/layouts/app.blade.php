<!DOCTYPE html>
<html>
<head>
    <title>Toko Online</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Tambahkan CSS jika perlu --}}
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        input, button { padding: 6px 10px; margin-top: 4px; }
    </style>
</head>
<body>
    {{-- Header --}}
    <header>
        <h1>Toko Online</h1>
        <nav>
            <a href="{{ route('home') }}">Home</a> |
            <a href="{{ route('keranjang.index') }}">Keranjang</a> |
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
        <hr>
    </header>

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer>
        <hr>
        <p>&copy; {{ date('Y') }} Toko Online</p>
    </footer>
</body>
</html>
