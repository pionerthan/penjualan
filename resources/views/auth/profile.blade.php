@extends('layouts.app')

@section('content')
<<<<<<< HEAD
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

    .profile-wrapper {
        position: relative;
        z-index: 1;
        padding: 60px 20px;
        min-height: 100vh;
    }

    .profile-container {
        max-width: 900px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 50px 45px;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Back button */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(52, 152, 219, 0.1);
        border: 2px solid #3498db;
        border-radius: 10px;
        color: #3498db;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 30px;
        font-size: 0.95rem;
    }

    .back-btn:hover {
        background: #3498db;
        color: white;
        transform: translateX(-5px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .back-icon {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .back-btn:hover .back-icon {
        transform: translateX(-3px);
    }

    h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        background: linear-gradient(45deg, #3498db, #8e44ad);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Profile Header */
    .profile-header {
        display: flex;
        align-items: center;
        gap: 30px;
        margin-bottom: 40px;
        padding: 30px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 20px;
        border-left: 5px solid #3498db;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .avatar-container {
        position: relative;
    }

    .profile-avatar {
        width: 130px;
        height: 130px;
        border-radius: 20px;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05) rotate(2deg);
    }

    .profile-info h2 {
        font-size: 2rem;
        color: #2c3e50;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .profile-info p {
        font-size: 1.1rem;
        color: #5a6c7d;
        margin: 0;
    }

    .profile-badge {
        display: inline-block;
        margin-top: 10px;
        padding: 6px 15px;
        background: linear-gradient(45deg, #3498db, #2980b9);
        color: white;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Divider */
    .divider {
        margin: 35px 0;
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, #3498db, transparent);
    }

    /* Section Title */
    .section-title {
        font-size: 1.8rem;
        color: #2c3e50;
        margin-bottom: 25px;
        font-weight: 700;
        background: linear-gradient(45deg, #3498db, #8e44ad);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-card {
        background: white;
        padding: 20px;
        border-radius: 16px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #3498db, #8e44ad);
        transition: width 0.3s ease;
    }

    .info-card:hover {
        border-color: #3498db;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(52, 152, 219, 0.2);
    }

    .info-card:hover::before {
        width: 100%;
        opacity: 0.05;
    }

    .info-label {
        font-weight: 600;
        color: #5a6c7d;
        font-size: 0.9rem;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1.1rem;
        color: #2c3e50;
        font-weight: 600;
    }

    /* Purchase History */
    .purchase-list {
        list-style: none;
        padding: 0;
    }

    .purchase-item {
        background: white;
        margin-bottom: 15px;
        padding: 20px;
        border-radius: 16px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .purchase-item:hover {
        border-color: #3498db;
        transform: translateX(5px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.15);
    }

    .purchase-date {
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.05rem;
    }

    .purchase-price {
        color: #27ae60;
        font-weight: 700;
        font-size: 1.15rem;
    }

    .purchase-items {
        color: #5a6c7d;
        font-size: 0.9rem;
        font-style: italic;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #5a6c7d;
        font-size: 1.1rem;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    .btn {
        padding: 14px 30px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(45deg, #3498db, #2980b9);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #2980b9, #1f5f99);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(52, 152, 219, 0.4);
    }

    .btn-danger {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
    }

    .btn-danger:hover {
        background: linear-gradient(45deg, #c0392b, #a93226);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(231, 76, 60, 0.4);
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 20px 25px;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.5rem;
    }

    .modal-body {
        padding: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-control {
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 15px rgba(52, 152, 219, 0.2);
    }

    .avatar-preview {
        width: 100px;
        border-radius: 12px;
        margin-top: 12px;
        border: 3px solid #e9ecef;
        transition: transform 0.3s ease;
    }

    .avatar-preview:hover {
        transform: scale(1.05);
    }

    .modal-footer {
        padding: 20px 25px;
        border-top: 2px solid #e9ecef;
    }

    .btn-secondary {
        background: #95a5a6;
        color: white;
    }

    .btn-secondary:hover {
        background: #7f8c8d;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-container {
            padding: 30px 25px;
        }

        .profile-header {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
        }

        h1 {
            font-size: 2rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .purchase-item {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="profile-wrapper">
    <!-- Animated background particles -->
    <div class="bg-particles" id="particles"></div>

    <div class="profile-container">
        <!-- Back Button -->
        <a href="{{ route('home') }}" class="back-btn">
            <span class="back-icon">←</span>
            <span>Kembali</span>
        </a>

        <h1>👤 Profil Saya</h1>

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="avatar-container">
                @if ($user->avatar)
                    <img src="{{ asset($user->avatar) }}" alt="Avatar" class="profile-avatar">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3498db&color=fff&size=200" 
                         alt="Avatar" 
                         class="profile-avatar">
                @endif
            </div>

            <div class="profile-info">
                <h2>{{ $user->name }}</h2>
                <p>📧 {{ $user->email }}</p>
                <span class="profile-badge">{{ $user->role }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Account Information -->
        <h3 class="section-title">📋 Informasi Akun</h3>

        <div class="info-grid">
            <div class="info-card">
                <div class="info-label">👤 Nama Lengkap</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>

            <div class="info-card">
                <div class="info-label">📧 Email</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>

            <div class="info-card">
                <div class="info-label">🎭 Role</div>
                <div class="info-value">{{ $user->role }}</div>
            </div>

            <div class="info-card">
                <div class="info-label">📅 Bergabung Sejak</div>
                <div class="info-value">{{ $user->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Purchase History -->
        @if($riwayat->isNotEmpty())
            <div class="divider"></div>

            <h3 class="section-title">🛍️ Riwayat Pembelian</h3>

            <ul class="purchase-list">
                @foreach($riwayat as $item)
                    <li class="purchase-item">
                        <div>
                            <div class="purchase-date">
                                📅 {{ \Carbon\Carbon::parse($item->TanggalPenjualan)->format('d M Y H:i') }}
                            </div>
                            <div class="purchase-items">
                                📦 {{ $item->detailpenjualans->count() }} item(s)
                            </div>
                        </div>
                        <div class="purchase-price">
                            💰 Rp{{ number_format($item->TotalHarga, 0, ',', '.') }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="divider"></div>
            <h3 class="section-title">🛍️ Riwayat Pembelian</h3>
            <div class="empty-state">
                <div class="empty-state-icon">🛒</div>
                <p>Belum ada riwayat pembelian.</p>
            </div>
        @endif

        <div class="divider"></div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="#" 
               data-bs-toggle="modal" 
               data-bs-target="#editProfileModal" 
               class="btn btn-primary">
                ✏️ Edit Profil
            </a>

            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="btn btn-danger">
                🚪 Logout
            </a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">✏️ Edit Profil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
=======
<div style="
    max-width: 720px;
    margin: 40px auto;
    background: #fff;
    padding: 28px;
    border-radius: 14px;
    box-shadow: 0 6px 14px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', sans-serif;
">

    <h1 style="margin-bottom: 20px; font-size: 26px;">Profil Saya</h1>

    {{-- Header --}}
    <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 28px;">
        @if ($user->avatar)
            <img src="{{ asset($user->avatar) }}"
                 alt="Avatar"
                 style="width: 110px; height: 110px; border-radius: 12px; object-fit: cover;">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff"
                 alt="Avatar"
                 style="width: 110px; height: 110px; border-radius: 12px; object-fit: cover;">
        @endif

        <div>
            <h2 style="margin: 0; font-size: 22px;">{{ $user->name }}</h2>
            <p style="margin: 6px 0 0; color: #555;">{{ $user->email }}</p>
        </div>
    </div>

    <hr style="margin: 25px 0; border-color: #eee;">

    {{-- Informasi Akun --}}
    <h3 style="margin-bottom: 12px; font-size: 20px;">Informasi Akun</h3>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">

        <div>
            <p style="margin: 0; font-weight: 600;">Nama</p>
            <p style="margin: 4px 0 0; color: #444;">{{ $user->name }}</p>
        </div>

        <div>
            <p style="margin: 0; font-weight: 600;">Email</p>
            <p style="margin: 4px 0 0; color: #444;">{{ $user->email }}</p>
        </div>

        <div>
            <p style="margin: 0; font-weight: 600;">Role</p>
            <p style="margin: 4px 0 0; color: #444;">{{ $user->role }}</p>
        </div>

        <div>
            <p style="margin: 0; font-weight: 600;">Tanggal Bergabung</p>
            <p style="margin: 4px 0 0; color: #444;">
                {{ $user->created_at->format('d M Y') }}
            </p>
        </div>

    </div>

    <hr style="margin: 25px 0; border-color: #eee;">

    {{-- Tombol Aksi --}}
    <div style="display: flex; gap: 14px;">
        <a href="#"
           data-bs-toggle="modal" 
           data-bs-target="#editProfileModal"
           style="
                background: #007bff;
                color: #fff;
                padding: 10px 18px;
                border-radius: 10px;
                text-decoration: none;
                font-weight: 600;
           ">
            Edit Profil
        </a>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           style="
                background: #dc3545;
                color: #fff;
                padding: 10px 18px;
                border-radius: 10px;
                text-decoration: none;
                font-weight: 600;
           ">
            Logout
        </a>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

</div>

{{-- Modal Edit Profil --}}
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="border-radius: 14px;">

            <div class="modal-header">
                <h5 class="modal-title">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

<<<<<<< HEAD
                <div class="modal-body">
                    <!-- Foto Profil -->
                    <div class="mb-4">
                        <label class="form-label">📷 Foto Profil</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">

                        @if ($user->avatar)
                            <img src="{{ asset($user->avatar) }}" class="avatar-preview" alt="Current Avatar">
                        @endif
                    </div>

                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="form-label">👤 Nama Lengkap</label>
                        <input type="text" 
                               name="name" 
                               value="{{ $user->name }}" 
                               class="form-control" 
                               placeholder="Masukkan nama lengkap"
                               required>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="form-label">🔒 Password Baru (opsional)</label>
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               placeholder="Kosongkan jika tidak ingin mengubah">
                        <small style="color: #5a6c7d; margin-top: 5px; display: block;">
                            Minimal 8 karakter jika ingin mengubah password
                        </small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                        ❌ Batal
                    </button>
                    <button class="btn btn-primary" type="submit">
                        ✅ Simpan Perubahan
                    </button>
                </div>
            </form>
=======
                <div class="modal-body" style="padding: 22px;">

                    {{-- Foto Profil --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;">Foto Profil</label>
                        <input type="file" name="avatar" class="form-control">

                        @if ($user->avatar)
                            <img src="{{ asset($user->avatar) }}"
                                 style="width:90px;border-radius:10px;margin-top:10px;">
                        @endif
                    </div>

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;">Password Baru (opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak mengubah">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>

            </form>

>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
        </div>
    </div>
</div>

<<<<<<< HEAD
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

    // Preview avatar before upload
    document.querySelector('input[name="avatar"]')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const existingPreview = document.querySelector('.avatar-preview');
                if (existingPreview) {
                    existingPreview.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'avatar-preview';
                    img.alt = 'Preview';
                    document.querySelector('input[name="avatar"]').parentElement.appendChild(img);
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Add smooth scroll
    document.documentElement.style.scrollBehavior = 'smooth';

    // Animate cards on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideIn 0.5s ease-out forwards';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.info-card, .purchase-item').forEach(card => {
        observer.observe(card);
    });
</script>

@endsection
=======
@endsection
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
