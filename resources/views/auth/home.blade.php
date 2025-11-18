<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛍️ Modern Supermarket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #5e4ba2ff 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background particles */
        .bg-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .container {
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            margin: 20px 60px; /* Increased horizontal margin */
            padding: 40px 60px; /* Increased horizontal padding */
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 2.5rem;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3), 0 0 10px rgba(255, 255, 255, 0.3); }
            to { text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3), 0 0 20px rgba(255, 255, 255, 0.6); }
        }

        .auth-area {
            color: white;
            font-weight: 500;
        }

        .auth-area a, .auth-area button {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .auth-area a:hover, .auth-area button:hover {
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.8);
        }

        .auth-area button {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: inherit;
        }

        .success-message {
            background: linear-gradient(45deg, #00c851, #007e33);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
            animation: slideIn 0.5s ease-out;
            box-shadow: 0 4px 15px rgba(0, 200, 81, 0.3);
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .produk-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Slightly smaller min width */
            gap: 20px; /* Reduced gap */
            margin: 30px 40px; /* Added horizontal margin to grid */
            padding: 0 20px; /* Added padding to grid */
        }

        .produk-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px; /* Slightly smaller border radius */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); /* Reduced shadow */
            padding: 20px; /* Reduced padding */
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 320px; /* Added max width */
            margin: 0 auto; /* Center the cards */
        }

        .produk-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .produk-card:hover::before {
            left: 100%;
        }

        .produk-card:hover {
            transform: translateY(-8px) scale(1.02); /* Reduced hover effect */
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15); /* Reduced shadow */
        }

        .produk-card img {
            max-width: 100%;
            max-height: 150px; /* Reduced image height */
            object-fit: cover;
            margin-bottom: 12px; /* Reduced margin */
            border-radius: 12px; /* Reduced border radius */
            transition: transform 0.3s ease;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1); /* Reduced shadow */
        }

        .produk-card:hover img {
            transform: scale(1.03); /* Reduced scale effect */
        }

        .produk-card h3 {
            margin: 12px 0 8px; /* Reduced margins */
            font-size: 1.2rem; /* Reduced font size */
            color: #2c3e50;
            font-weight: 700;
            background: linear-gradient(45deg, #3498db, #8e44ad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .price-tag {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 6px 12px; /* Reduced padding */
            border-radius: 20px; /* Reduced border radius */
            font-size: 1rem; /* Reduced font size */
            font-weight: bold;
            display: inline-block;
            margin: 8px 0; /* Reduced margin */
            box-shadow: 0 3px 12px rgba(255, 107, 107, 0.3); /* Reduced shadow */
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 3px 12px rgba(255, 107, 107, 0.3); }
            50% { box-shadow: 0 3px 20px rgba(255, 107, 107, 0.6); }
            100% { box-shadow: 0 3px 12px rgba(255, 107, 107, 0.3); }
        }

        .stock-info {
            background: linear-gradient(45deg, #74b9ff, #0984e3);
            color: white;
            padding: 4px 10px; /* Reduced padding */
            border-radius: 12px; /* Reduced border radius */
            font-size: 0.85rem; /* Reduced font size */
            display: inline-block;
            margin: 4px 0; /* Reduced margin */
        }

        .form-section {
            margin-top: 15px; /* Reduced margin */
            padding-top: 15px; /* Reduced padding */
            border-top: 2px solid #ecf0f1;
        }

        .produk-card input,
        .produk-card select {
            margin: 6px 0; /* Reduced margin */
            padding: 10px; /* Reduced padding */
            width: 100%;
            border: 2px solid #ddd;
            border-radius: 10px; /* Reduced border radius */
            font-size: 0.9rem; /* Reduced font size */
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .produk-card input:focus,
        .produk-card select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 12px rgba(52, 152, 219, 0.3); /* Reduced shadow */
            transform: translateY(-1px); /* Reduced transform */
        }

        .btn {
            margin: 6px 0; /* Reduced margin */
            padding: 10px 16px; /* Reduced padding */
            width: 100%;
            border: none;
            border-radius: 10px; /* Reduced border radius */
            font-size: 0.9rem; /* Reduced font size */
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px; /* Reduced letter spacing */
        }

        .btn-primary {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            box-shadow: 0 3px 12px rgba(52, 152, 219, 0.3); /* Reduced shadow */
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #2980b9, #1f5f99);
            transform: translateY(-2px); /* Reduced transform */
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5); /* Reduced shadow */
        }

        .btn-secondary {
            background: linear-gradient(45deg, #f39c12, #e67e22);
            color: white;
            box-shadow: 0 3px 12px rgba(243, 156, 18, 0.3); /* Reduced shadow */
        }

        .btn-secondary:hover {
            background: linear-gradient(45deg, #e67e22, #d35400);
            transform: translateY(-2px); /* Reduced transform */
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.5); /* Reduced shadow */
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .footer-actions {
            margin: 40px 40px 20px; /* Added horizontal margin */
            text-align: center;
            padding: 25px 40px; /* Added horizontal padding */
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .footer-actions a {
            display: inline-block;
            margin: 10px 15px;
            padding: 12px 25px; /* Reduced padding */
            background: linear-gradient(45deg, #6c5ce7, #a29bfe);
            color: white;
            text-decoration: none;
            border-radius: 20px; /* Reduced border radius */
            font-weight: bold;
            font-size: 1rem; /* Reduced font size */
            transition: all 0.3s ease;
            box-shadow: 0 3px 12px rgba(108, 92, 231, 0.3); /* Reduced shadow */
        }

        .footer-actions a:hover {
            transform: translateY(-3px); /* Reduced transform */
            box-shadow: 0 6px 20px rgba(108, 92, 231, 0.5); /* Reduced shadow */
            background: linear-gradient(45deg, #5f3dc4, #6c5ce7);
        }

        .login-prompt {
            background: linear-gradient(45deg, #fd79a8, #e84393);
            color: white;
            padding: 12px; /* Reduced padding */
            border-radius: 12px; /* Reduced border radius */
            text-align: center;
            font-weight: bold;
            font-size: 0.9rem; /* Reduced font size */
            box-shadow: 0 3px 12px rgba(253, 121, 168, 0.3); /* Reduced shadow */
        }

        .login-prompt a {
            color: #fff;
            text-decoration: none;
            border-bottom: 2px solid #fff;
            transition: all 0.3s ease;
        }

        .login-prompt a:hover {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 16px; /* Reduced size */
            height: 16px; /* Reduced size */
            border: 2px solid rgba(255, 255, 255, 0.3); /* Reduced border */
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive design */
        @media (max-width: 1200px) {
            .container {
                margin: 20px 40px; /* Reduced margin for large screens */
                padding: 30px 40px; /* Reduced padding for large screens */
            }
            
            .produk-grid {
                margin: 20px 20px; /* Reduced margin */
                padding: 0 10px; /* Reduced padding */
            }
            
            .footer-actions {
                margin: 30px 20px 20px; /* Reduced margin */
                padding: 20px 30px; /* Reduced padding */
            }
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px 20px; /* Further reduced for tablets */
                padding: 20px 25px; /* Further reduced padding */
            }
            
            .header h2 {
                font-size: 2rem;
            }
            
            .produk-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Smaller min width for mobile */
                gap: 15px; /* Reduced gap */
                margin: 20px 10px; /* Reduced margin */
                padding: 0 5px; /* Reduced padding */
            }
            
            .produk-card {
                max-width: none; /* Remove max width on mobile */
                padding: 15px; /* Further reduced padding */
            }
            
            .footer-actions {
                margin: 20px 10px; /* Reduced margin */
                padding: 20px 15px; /* Reduced padding */
            }
            
            .footer-actions a {
                display: block;
                margin: 8px 0; /* Reduced margin */
                padding: 10px 20px; /* Reduced padding */
            }
        }

        @media (max-width: 480px) {
            .container {
                margin: 10px; /* Minimal margin for small screens */
                padding: 15px 20px; /* Minimal padding */
            }
            
            .produk-grid {
                grid-template-columns: 1fr; /* Single column */
                margin: 15px 5px; /* Minimal margin */
                padding: 0; /* No padding */
            }
            
            .produk-card {
                padding: 12px; /* Minimal padding */
            }
        }

        /* Quantity selector styling */
        .quantity-selector {
            position: relative;
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 10px; /* Reduced border radius */
            overflow: hidden;
            margin: 8px 0; /* Reduced margin */
        }

        .quantity-btn {
            background: #3498db;
            color: white;
            border: none;
            width: 35px; /* Reduced size */
            height: 35px; /* Reduced size */
            cursor: pointer;
            font-size: 1.1rem; /* Reduced font size */
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .quantity-btn:hover {
            background: #2980b9;
        }

        .quantity-input {
            flex: 1;
            text-align: center;
            border: none !important;
            background: transparent;
            font-weight: bold;
            margin: 0 !important;
            font-size: 0.9rem; /* Reduced font size */
        }
    </style>
</head>
<body>
    <!-- Animated background particles -->
    <div class="bg-particles" id="particles"></div>

    <div class="container">
        <div class="header">
            <h2>🛍️ Lumidouce Market</h2>
            <div class="auth-area">
                @auth
                    <span>Halo, {{ auth()->user()->name }} |</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a> |
                    <a href="{{ route('register') }}">Daftar</a>
                @endauth
            </div>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

 <form method="GET" style="margin: 20px 40px; padding:20px; 
    background: rgba(255,255,255,0.15); border-radius: 15px; backdrop-filter:blur(8px);">

    <h3 style="color:white; margin-bottom:10px;">🔍 Filter Produk</h3>

    <div style="display:flex; gap:15px; flex-wrap:wrap;">

        <input type="text" name="search" placeholder="Cari nama..."
            value="{{ request('search') }}"
            style="flex:1; padding:10px; border-radius:10px; border:none;">

        <select name="kategori" style="padding:10px; border-radius:10px; border:none;">
            <option value="">Semua Kategori</option>
            <option value="makanan" {{ request('kategori')=='makanan'?'selected':'' }}>Makanan</option>
            <option value="minuman" {{ request('kategori')=='minuman'?'selected':'' }}>Minuman</option>
            <option value="elektronik" {{ request('kategori')=='elektronik'?'selected':'' }}>Elektronik</option>
            <option value="lainnya" {{ request('kategori')=='lainnya'?'selected':'' }}>Lainnya</option>
        </select>

        <input type="number" name="min" placeholder="Min Harga"
            value="{{ request('min') }}"
            style="width:150px; padding:10px; border-radius:10px; border:none;">

        <input type="number" name="max" placeholder="Max Harga"
            value="{{ request('max') }}"
            style="width:150px; padding:10px; border-radius:10px; border:none;">

        <select name="sort" style="padding:10px; border-radius:10px; border:none;">
            <option value="">Urutkan</option>
            <option value="termurah" {{ request('sort')=='termurah'?'selected':'' }}>Termurah</option>
            <option value="termahal" {{ request('sort')=='termahal'?'selected':'' }}>Termahal</option>
        </select>

        <select name="stock" style="padding:10px; border-radius:10px; border:none;">
            <option value="">Stok</option>
            <option value="1" {{ request('stock')=='1'?'selected':'' }}>Tersedia</option>
        </select>

        <button class="btn btn-primary" style="padding:10px 20px;">
            Terapkan
        </button>
    </div>
</form>



        <div class="produk-grid">
            @foreach($produk as $p)
                <div class="produk-card" data-product-id="{{ $p->ProdukID }}">
                    <img src="{{ $p->FotoURL ?? 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                         alt="Foto {{ $p->NamaProduk }}" 
                         loading="lazy">
                    
                    <h3>{{ $p->NamaProduk }}</h3>
                    
                    <div class="price-tag">
                        💵 Rp{{ number_format($p->Harga) }}
                    </div>
                    
                    <div class="stock-info">
                        📦 Stok: {{ $p->Stok }}
                    </div>

                    @auth
                        <div class="form-section">
                            {{-- Form beli langsung --}}
                            <form method="POST" action="{{ route('beli.proses') }}" class="purchase-form">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $p->ProdukID }}">
                                
                                <div class="quantity-selector">
                                    <button type="button" class="quantity-btn" onclick="decreaseQuantity({{ $p->ProdukID }})">-</button>
                                    <input type="number" 
                                           name="jumlah" 
                                           id="qty_{{ $p->ProdukID }}"
                                           class="quantity-input"
                                           value="1" 
                                           min="1" 
                                           max="{{ $p->Stok }}" 
                                           required>
                                    <button type="button" class="quantity-btn" onclick="increaseQuantity({{ $p->ProdukID }}, {{ $p->Stok }})">+</button>
                                </div>

                                @if(isset($pelanggans) && $pelanggans->count() > 0)
                                    <select onchange="isiDataPelanggan(this, '{{ $p->ProdukID }}')" class="customer-select">
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

                                <input type="text" 
                                       name="NamaPelanggan" 
                                       id="nama_{{ $p->ProdukID }}" 
                                       placeholder="Nama Pelanggan" 
                                       required>
                                
                                <input type="text" 
                                       name="Alamat" 
                                       id="alamat_{{ $p->ProdukID }}" 
                                       placeholder="Alamat" 
                                       required>
                                
                                <input type="text" 
                                       name="NomorTelepon" 
                                       id="telepon_{{ $p->ProdukID }}" 
                                       placeholder="No. Telepon" 
                                       required>
                                
                                <button type="submit" class="btn btn-primary">
                                    🛒 Beli Langsung
                                </button>
                            </form>

                            {{-- Form tambah ke keranjang --}}
                            <form method="POST" action="{{ route('keranjang.tambah') }}" class="cart-form">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $p->ProdukID }}">
                                
                                <div class="quantity-selector">
                                    <button type="button" class="quantity-btn" onclick="decreaseCartQuantity({{ $p->ProdukID }})">-</button>
                                    <input type="number" 
                                           name="jumlah" 
                                           id="cart_qty_{{ $p->ProdukID }}"
                                           class="quantity-input"
                                           value="1" 
                                           min="1" 
                                           max="{{ $p->Stok }}" 
                                           required>
                                    <button type="button" class="quantity-btn" onclick="increaseCartQuantity({{ $p->ProdukID }}, {{ $p->Stok }})">+</button>
                                </div>
                                
                                <button type="submit" class="btn btn-secondary">
                                    🧺 Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="login-prompt">
                            <a href="{{ route('login') }}">Login untuk berbelanja</a>
                        </div>
                    @endauth
                </div>
            @endforeach
        </div>

        @auth
            <div class="footer-actions">
                <a href="{{ route('keranjang.index') }}">
                    🛒 Lihat Keranjang
                </a>
                <a href="{{ route('checkout') }}">
                    🧾 Checkout Sekarang
                </a>
            </div>
        @endauth
    </div>

    <script>
        // Create animated background particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                
                const size = Math.random() * 10 + 5;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
                
                particlesContainer.appendChild(particle);
            }
        }

        // Initialize particles on page load
        document.addEventListener('DOMContentLoaded', createParticles);

        // Quantity controls for purchase form
        function increaseQuantity(productId, maxStock) {
            const input = document.getElementById('qty_' + productId);
            const currentValue = parseInt(input.value);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
                animateButton(input);
            }
        }

        function decreaseQuantity(productId) {
            const input = document.getElementById('qty_' + productId);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                animateButton(input);
            }
        }

        // Quantity controls for cart form
        function increaseCartQuantity(productId, maxStock) {
            const input = document.getElementById('cart_qty_' + productId);
            const currentValue = parseInt(input.value);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
                animateButton(input);
            }
        }

        function decreaseCartQuantity(productId) {
            const input = document.getElementById('cart_qty_' + productId);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                animateButton(input);
            }
        }

        // Animate button feedback
        function animateButton(element) {
            element.style.transform = 'scale(1.1)';
            setTimeout(() => {
                element.style.transform = 'scale(1)';
            }, 150);
        }

        // Customer data auto-fill
        function isiDataPelanggan(select, produkId) {
            const selected = select.options[select.selectedIndex];
            const nama = selected.value;
            const alamat = selected.getAttribute('data-alamat');
            const telepon = selected.getAttribute('data-telepon');

            const namaField = document.getElementById('nama_' + produkId);
            const alamatField = document.getElementById('alamat_' + produkId);
            const teleponField = document.getElementById('telepon_' + produkId);

            if (namaField) namaField.value = nama || '';
            if (alamatField) alamatField.value = alamat || '';
            if (teleponField) teleponField.value = telepon || '';

            // Add animation to show fields are filled
            [namaField, alamatField, teleponField].forEach(field => {
                if (field && field.value) {
                    field.style.background = 'linear-gradient(45deg, #00b894, #00cec9)';
                    field.style.color = 'white';
                    setTimeout(() => {
                        field.style.background = 'rgba(255, 255, 255, 0.9)';
                        field.style.color = 'black';
                    }, 1000);
                }
            });
        }

        // Form submission with loading state
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="loading"></span> Processing...';
                    submitBtn.disabled = true;
                    
                    // Re-enable after 3 seconds (fallback)
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 3000);
                }
            });
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';

        // Add parallax effect to header
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const header = document.querySelector('.header h2');
            if (header) {
                header.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Add intersection observer for card animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'slideIn 0.6s ease-out forwards';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.produk-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px)';
            observer.observe(card);
        });

        // Add slide-in animation for cards
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>