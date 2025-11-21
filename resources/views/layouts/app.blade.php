<!DOCTYPE html>
<html>
<head>
    <title>Toko Online</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 CSS (WAJIB untuk modal) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        nav a { margin-right: 8px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        input, button { padding: 6px 10px; margin-top: 4px; }
    </style>
</head>
<body>
    {{-- Header --}}
    <header class="mb-3">
        <h1>Lumidouce</h1>

        <nav>
            <a href="{{ route('home') }}">Home</a> |
            <a href="{{ route('keranjang.index') }}">Keranjang</a> |
            
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Logout</button>
            </form>
        </nav>

        <hr>
    </header>

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-5">
        <hr>
        <p>&copy; {{ date('Y') }} Toko Online</p>
    </footer>

    {{-- Bootstrap 5 JS (WAJIB agar modal muncul pop-up) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Tempat script tambahan --}}
    @yield('scripts')
</body>
</html>