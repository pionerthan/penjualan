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
            margin: 20px;
            padding: 30px;
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
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .produk-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 25px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .produk-card img {
            max-width: 100%;
            max-height: 180px;
            object-fit: cover;
            margin-bottom: 15px;
            border-radius: 15px;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .produk-card:hover img {
            transform: scale(1.05);
        }

        .produk-card h3 {
            margin: 15px 0 10px;
            font-size: 1.4rem;
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
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: bold;
            display: inline-block;
            margin: 10px 0;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3); }
            50% { box-shadow: 0 4px 25px rgba(255, 107, 107, 0.6); }
            100% { box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3); }
        }

        .stock-info {
            background: linear-gradient(45deg, #74b9ff, #0984e3);
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.9rem;
            display: inline-block;
            margin: 5px 0;
        }

        .form-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #ecf0f1;
        }

        .produk-card input,
        .produk-card select {
            margin: 8px 0;
            padding: 12px;
            width: 100%;
            border: 2px solid #ddd;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .produk-card input:focus,
        .produk-card select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.3);
            transform: translateY(-2px);
        }

        .btn {
            margin: 8px 0;
            padding: 12px 20px;
            width: 100%;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #2980b9, #1f5f99);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.5);
        }

        .btn-secondary {
            background: linear-gradient(45deg, #f39c12, #e67e22);
            color: white;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(45deg, #e67e22, #d35400);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(243, 156, 18, 0.5);
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
            margin-top: 50px;
            text-align: center;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .footer-actions a {
            display: inline-block;
            margin: 10px 15px;
            padding: 15px 30px;
            background: linear-gradient(45deg, #6c5ce7, #a29bfe);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
        }

        .footer-actions a:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.5);
            background: linear-gradient(45deg, #5f3dc4, #6c5ce7);
        }

        .login-prompt {
            background: linear-gradient(45deg, #fd79a8, #e84393);
            color: white;
            padding: 15px;
            border-radius: 15px;
            text-align: center;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(253, 121, 168, 0.3);
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
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                padding: 20px;
            }
            
            .header h2 {
                font-size: 2rem;
            }
            
            .produk-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
            }
            
            .footer-actions a {
                display: block;
                margin: 10px 0;
            }
        }

        /* Quantity selector styling */
        .quantity-selector {
            position: relative;
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 12px;
            overflow: hidden;
            margin: 10px 0;
        }

        .quantity-btn {
            background: #3498db;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            cursor: pointer;
            font-size: 1.2rem;
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
        }
    </style>
</head>
<body>
    <!-- Animated background particles -->
    <div class="bg-particles" id="particles"></div>

    <div class="container">
        <div class="header">
            <h2>🛍️ Modern Supermarket</h2>
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