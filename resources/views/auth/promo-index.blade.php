@extends('layouts.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

    .promo-wrapper {
        position: relative;
        z-index: 1;
        padding: 60px 20px;
        min-height: 100vh;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Back button */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        border-radius: 10px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 30px;
        font-size: 0.95rem;
        backdrop-filter: blur(10px);
    }

    .back-btn:hover {
        background: white;
        color: #3498db;
        transform: translateX(-5px);
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
    }

    .back-icon {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .back-btn:hover .back-icon {
        transform: translateX(-3px);
    }

    /* Promo Header Banner */
    .promo-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 35px;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        gap: 30px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: slideIn 0.6s ease-out;
        overflow: hidden;
        position: relative;
    }

    .promo-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.1), transparent);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .promo-header img {
        height: 160px;
        width: 280px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .promo-header img:hover {
        transform: scale(1.05) rotate(2deg);
    }

    .promo-header-content h2 {
        font-size: 2.2rem;
        margin-bottom: 12px;
        background: linear-gradient(45deg, #e74c3c, #f39c12);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    .promo-header-content p {
        color: #5a6c7d;
        font-size: 1.1rem;
        line-height: 1.5;
    }

    /* Section Title */
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: white;
        text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title::before {
        content: '';
        width: 5px;
        height: 35px;
        background: linear-gradient(180deg, #e74c3c, #f39c12);
        border-radius: 3px;
    }

    /* Promo Cards */
    .promo-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .promo-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #e74c3c, #f39c12);
    }

    .promo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
    }

    .promo-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
    }

    .promo-info h3 {
        font-size: 1.6rem;
        color: #2c3e50;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .flash-badge {
        display: inline-block;
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-left: 10px;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.9; }
    }

    .promo-description {
        color: #5a6c7d;
        font-size: 1rem;
        line-height: 1.6;
        margin: 8px 0;
    }

    .promo-actions {
        text-align: right;
    }

    .countdown {
        font-weight: 700;
        color: #e74c3c;
        font-size: 1.3rem;
        margin-bottom: 15px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        align-items: center;
    }

    .countdown-item {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        padding: 8px 12px;
        border-radius: 10px;
        min-width: 50px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
    }

    .countdown-label {
        font-size: 0.7rem;
        opacity: 0.9;
        display: block;
        margin-top: 2px;
    }

    .btn-view-detail {
        background: linear-gradient(45deg, #3498db, #2980b9);
        color: white;
        padding: 12px 25px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }

    .btn-view-detail:hover {
        background: linear-gradient(45deg, #2980b9, #1f5f99);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(52, 152, 219, 0.5);
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .product-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        text-align: center;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
    }

    .product-card img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 15px;
        transition: transform 0.3s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card h4 {
        font-size: 1.1rem;
        color: #2c3e50;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        background: linear-gradient(45deg, #27ae60, #2ecc71);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 12px;
    }

    .btn-view-product {
        background: linear-gradient(45deg, #27ae60, #2ecc71);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-view-product:hover {
        background: linear-gradient(45deg, #229954, #27ae60);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
    }

    /* Voucher Grid */
    .voucher-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .voucher-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .voucher-card::before {
        content: '🎟️';
        position: absolute;
        top: -10px;
        right: -10px;
        font-size: 5rem;
        opacity: 0.1;
        transform: rotate(15deg);
    }

    .voucher-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
    }

    .voucher-code {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 12px;
        background: linear-gradient(45deg, #f39c12, #e67e22);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .voucher-status {
        color: #5a6c7d;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .voucher-status.available {
        color: #27ae60;
        font-weight: 600;
    }

    .voucher-status.claimed {
        color: #e74c3c;
        font-weight: 600;
    }

    .btn-claim {
        width: 100%;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-claim.available {
        background: linear-gradient(45deg, #3498db, #2980b9);
        color: white;
    }

    .btn-claim.available:hover {
        background: linear-gradient(45deg, #2980b9, #1f5f99);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    }

    .btn-claim.claimed {
        background: #bdc3c7;
        color: white;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .promo-header {
            flex-direction: column;
            text-align: center;
            padding: 25px;
        }

        .promo-header img {
            width: 100%;
            height: auto;
        }

        .promo-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .promo-actions {
            text-align: left;
            width: 100%;
        }

        .countdown {
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        .section-title {
            font-size: 1.6rem;
        }

        .product-grid,
        .voucher-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
        }
    }
</style>

<div class="promo-wrapper">
    <!-- Animated background particles -->
    <div class="bg-particles" id="particles"></div>

    <div class="container">
        <!-- Back Button -->
        <a href="{{ route('home') }}" class="back-btn">
            <span class="back-icon">←</span>
            <span>Kembali</span>
        </a>

        <!-- Promo Header Banner -->
        <div class="promo-header">
            <img src="https://via.placeholder.com/280x160?text=Promo+Spesial" alt="Promo Banner">
            <div class="promo-header-content">
                <h2>🎉 Promo & Flash Sale</h2>
                <p>Nikmati promo terbatas, diskon real-time, dan voucher spesial untuk pengalaman belanja yang lebih hemat!</p>
            </div>
        </div>

        <!-- List Promo -->
        <h3 class="section-title">🔥 Promo Aktif</h3>

        @foreach($promotions as $promo)
        <div class="promo-card">
            <div class="promo-content">
                <div class="promo-info">
                    <h3>
                        {{ $promo->name }}
                        @if($promo->type == 'flash')
                            <span class="flash-badge">⚡ Flash Sale</span>
                        @endif
                    </h3>
                    <p class="promo-description">{!! $promo->description !!}</p>
                </div>

                <div class="promo-actions">
                    <div id="countdown-{{ $promo->id }}" class="countdown"></div>
                    <a href="{{ route('promo.show', $promo->id) }}" class="btn-view-detail">
                        👁️ Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        <script>
            (function(){
                var end = new Date("{{ \Carbon\Carbon::parse($promo->end_at)->toIso8601String() }}").getTime();
                var el = document.getElementById("countdown-{{ $promo->id }}");
                if (!el) return;

                var timer = setInterval(function(){
                    var now = new Date().getTime();
                    var distance = end - now;

                    if (distance < 0) {
                        el.innerHTML = '<span class="countdown-item">⏰ Selesai</span>';
                        clearInterval(timer);
                        return;
                    }

                    var h = Math.floor((distance%(1000*60*60*24))/(1000*60*60));
                    var m = Math.floor((distance%(1000*60*60))/(1000*60));
                    var s = Math.floor((distance%(1000*60))/1000);
                    
                    el.innerHTML = 
                        '<div class="countdown-item">' + h + '<span class="countdown-label">Jam</span></div>' +
                        '<div class="countdown-item">' + m + '<span class="countdown-label">Menit</span></div>' +
                        '<div class="countdown-item">' + s + '<span class="countdown-label">Detik</span></div>';
                }, 1000);
            })();
        </script>
        @endforeach

        <!-- Rekomendasi Produk -->
        <h3 class="section-title" style="margin-top: 50px;">⭐ Rekomendasi Produk</h3>

        <div class="product-grid">
            @foreach($recommended as $prod)
            <div class="product-card">
                <img src="{{ $prod->FotoURL ?? 'https://via.placeholder.com/220x140?text=No+Image' }}" 
                     alt="{{ $prod->NamaProduk }}">
                <h4>{{ $prod->NamaProduk }}</h4>
                <div class="product-price">💰 Rp{{ number_format($prod->Harga, 0, ',', '.') }}</div>
                <a href="{{ route('produk.detail', $prod->ProdukID) }}" class="btn-view-product">
                    🛒 Lihat Produk
                </a>
            </div>
            @endforeach
        </div>

        <!-- Voucher Claim -->
        <h3 class="section-title" style="margin-top: 50px;">🎟️ Voucher Tersedia</h3>

        <div class="voucher-grid">
            @foreach($vouchers as $v)
            <div class="voucher-card">
                <div class="voucher-code">📋 {{ $v->kode_voucher }}</div>
                <div class="voucher-status {{ $v->claimed ? 'claimed' : 'available' }}">
                    {{ $v->claimed ? '❌ Sudah Diklaim' : '✅ Tersedia' }}
                </div>

                <form method="POST" action="{{ route('promo.claim') }}">
                    @csrf
                    <input type="hidden" name="voucher_id" value="{{ $v->id }}">
                    <button class="btn-claim {{ $v->claimed ? 'claimed' : 'available' }}" 
                            {{ $v->claimed ? 'disabled' : '' }}>
                        {{ $v->claimed ? '🚫 Tidak Tersedia' : '🎁 Klaim Voucher' }}
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
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

    document.addEventListener('DOMContentLoaded', createParticles);

    // Add smooth scroll
    document.documentElement.style.scrollBehavior = 'smooth';

    // Animate cards on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideIn 0.6s ease-out forwards';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.promo-card, .product-card, .voucher-card').forEach(card => {
        observer.observe(card);
    });
</script>

@endsection