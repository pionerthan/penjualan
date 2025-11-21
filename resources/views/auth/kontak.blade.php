@extends('layouts.app')

@section('content')
<style>
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

    .contact-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 60px 20px;
        position: relative;
        overflow: hidden;
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

    .contact-container {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 50px 40px;
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

    .contact-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .contact-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 15px;
        background: linear-gradient(45deg, #3498db, #8e44ad);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
        from { 
            filter: drop-shadow(0 0 5px rgba(52, 152, 219, 0.3));
        }
        to { 
            filter: drop-shadow(0 0 15px rgba(142, 68, 173, 0.5));
        }
    }

    .contact-header p {
        color: #5a6c7d;
        font-size: 1.1rem;
    }

    .contact-header .icon {
        font-size: 3rem;
        margin-bottom: 15px;
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group .input-icon {
        position: absolute;
        left: 15px;
        top: 48px;
        font-size: 1.2rem;
        color: #95a5a6;
        transition: all 0.3s ease;
        pointer-events: none;
        z-index: 2;
    }

    .form-group input,
    .form-group textarea {
        width: 90%;
        padding: 15px 15px 15px 45px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
        position: relative;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 150px;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3498db;
        background: white;
        box-shadow: 0 0 20px rgba(52, 152, 219, 0.2);
        transform: translateY(-2px);
    }

    .form-group input:focus + .input-icon,
    .form-group textarea:focus ~ .input-icon {
        color: #3498db;
        transform: scale(1.1);
    }

    .form-group.focused label {
        color: #3498db;
        transform: translateY(-2px);
    }

    /* Character counter for textarea */
    .char-counter {
        text-align: right;
        font-size: 0.85rem;
        color: #95a5a6;
        margin-top: 5px;
    }

    /* Success alert */
    .alert-success {
        background: linear-gradient(45deg, #00c851, #007e33);
        color: white;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        text-align: center;
        font-weight: 600;
        animation: slideIn 0.5s ease-out;
        box-shadow: 0 4px 15px rgba(0, 200, 81, 0.3);
        border: none;
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

    /* Submit button */
    .submit-btn {
        width: 100%;
        padding: 16px 30px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(45deg, #3498db, #2980b9);
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
        margin-top: 10px;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .submit-btn:hover::before {
        left: 100%;
    }

    .submit-btn:hover {
        background: linear-gradient(45deg, #2980b9, #1f5f99);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(52, 152, 219, 0.4);
    }

    .submit-btn:active {
        transform: translateY(-1px);
    }

    .submit-btn:disabled {
        background: #bdc3c7;
        cursor: not-allowed;
        transform: none;
    }

    .submit-btn .btn-icon {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    .submit-btn:hover .btn-icon {
        transform: translateX(5px);
    }

    /* Loading state */
    .submit-btn.loading {
        pointer-events: none;
    }

    .submit-btn.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Contact info section */
    .contact-info {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 12px;
        padding: 25px;
        margin-top: 30px;
        border-left: 4px solid #3498db;
    }

    .contact-info h4 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 1.2rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        color: #5a6c7d;
    }

    .info-item .icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(45deg, #3498db, #2980b9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1rem;
        color: white;
    }

    /* Input validation states */
    .form-group.error input,
    .form-group.error textarea {
        border-color: #e74c3c;
        animation: shake 0.5s ease-in-out;
    }

    .form-group.success input,
    .form-group.success textarea {
        border-color: #27ae60;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    .error-message {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 5px;
        display: none;
    }

    .form-group.error .error-message {
        display: block;
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .contact-container {
            padding: 30px 25px;
            margin: 20px 10px;
        }

        .contact-header h2 {
            font-size: 2rem;
        }

        .contact-header .icon {
            font-size: 2.5rem;
        }

        .form-group input,
        .form-group textarea {
            padding: 12px 12px 12px 40px;
        }

        .submit-btn {
            padding: 14px 25px;
            font-size: 1rem;
        }
    }

    /* Progress indicator */
    .form-progress {
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .form-progress-bar {
        height: 100%;
        background: linear-gradient(45deg, #3498db, #8e44ad);
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 2px;
    }

    /* Floating label effect */
    .form-group.has-value label,
    .form-group input:focus ~ label,
    .form-group textarea:focus ~ label {
        font-size: 0.85rem;
        color: #3498db;
    }
</style>

<div class="contact-wrapper">
    <!-- Animated background particles -->
    <div class="bg-particles" id="particles"></div>

    <div class="contact-container">
        <!-- Back Button -->
        <a href="{{ route('home') }}" class="back-btn">
            <span class="back-icon">←</span>
            <span>Kembali</span>
        </a>

        <div class="contact-header">
            <div class="icon">📧</div>
            <h2>Hubungi Kami</h2>
            <p>Kami siap membantu Anda! Kirimkan pesan dan kami akan merespons sesegera mungkin.</p>
        </div>

        <!-- Form Progress -->
        <div class="form-progress">
            <div class="form-progress-bar" id="progressBar"></div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('kontak.store') }}" method="POST" id="contactForm">
            @csrf

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <div class="input-icon">👤</div>
                <input 
                    type="text" 
                    name="nama" 
                    id="nama"
                    placeholder="Masukkan nama lengkap Anda"
                    required
                    autocomplete="name">
                <div class="error-message">Nama harus diisi</div>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <div class="input-icon">📧</div>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    placeholder="nama@email.com"
                    required
                    autocomplete="email">
                <div class="error-message">Email harus valid</div>
            </div>

            <div class="form-group">
                <label for="subjek">Subjek</label>
                <div class="input-icon">📝</div>
                <input 
                    type="text" 
                    name="subjek" 
                    id="subjek"
                    placeholder="Tentang apa pesan Anda?"
                    required>
                <div class="error-message">Subjek harus diisi</div>
            </div>

            <div class="form-group">
                <label for="pesan">Pesan</label>
                <div class="input-icon">💬</div>
                <textarea 
                    name="pesan" 
                    id="pesan"
                    rows="6"
                    placeholder="Tulis pesan Anda di sini..."
                    required
                    maxlength="1000"></textarea>
                <div class="char-counter">
                    <span id="charCount">0</span> / 1000 karakter
                </div>
                <div class="error-message">Pesan harus diisi</div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                <span class="btn-icon">✉️</span>
                <span class="btn-text">Kirim Pesan</span>
            </button>
        </form>

        <!-- Contact Info -->
        <div class="contact-info">
            <h4>📍 Informasi Kontak Lainnya</h4>
            <div class="info-item">
                <div class="icon">📧</div>
                <span>support@lumidoucemarket.com</span>
            </div>
            <div class="info-item">
                <div class="icon">📱</div>
                <span>+62 812-3456-7890</span>
            </div>
            <div class="info-item">
                <div class="icon">🏢</div>
                <span>Jl. Contoh No. 123, Bandung, Indonesia</span>
            </div>
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

    // Initialize particles on page load
    document.addEventListener('DOMContentLoaded', function() {
        createParticles();
        updateProgress();
    });

    // Form elements
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const inputs = form.querySelectorAll('input, textarea');

    // Character counter for textarea
    const pesanTextarea = document.getElementById('pesan');
    const charCount = document.getElementById('charCount');

    pesanTextarea.addEventListener('input', function() {
        charCount.textContent = this.value.length;
        
        if (this.value.length > 900) {
            charCount.style.color = '#e74c3c';
        } else {
            charCount.style.color = '#95a5a6';
        }
    });

    // Add focus effects
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
            if (this.value) {
                this.parentElement.classList.add('has-value');
            } else {
                this.parentElement.classList.remove('has-value');
            }
        });

        // Real-time validation
        input.addEventListener('input', function() {
            validateField(this);
            updateProgress();
        });
    });

    // Field validation
    function validateField(field) {
        const formGroup = field.parentElement;
        
        if (field.value.trim() === '') {
            formGroup.classList.remove('success');
            formGroup.classList.add('error');
            return false;
        } else if (field.type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value)) {
                formGroup.classList.remove('success');
                formGroup.classList.add('error');
                return false;
            }
        }
        
        formGroup.classList.remove('error');
        formGroup.classList.add('success');
        return true;
    }

    // Update progress bar
    function updateProgress() {
        const totalFields = inputs.length;
        let filledFields = 0;

        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                filledFields++;
            }
        });

        const progress = (filledFields / totalFields) * 100;
        document.getElementById('progressBar').style.width = progress + '%';
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });

        if (!isValid) {
            // Shake the form
            document.querySelector('.contact-container').style.animation = 'shake 0.5s ease-in-out';
            setTimeout(() => {
                document.querySelector('.contact-container').style.animation = '';
            }, 500);
            return;
        }

        // Show loading state
        submitBtn.classList.add('loading');
        submitBtn.querySelector('.btn-text').textContent = 'Mengirim...';
        submitBtn.disabled = true;

        // Submit the form
        this.submit();
    });

    // Add smooth scroll behavior
    document.documentElement.style.scrollBehavior = 'smooth';

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + Enter to submit
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            form.dispatchEvent(new Event('submit'));
        }
    });

    // Auto-save to localStorage (optional)
    let saveTimeout;
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                localStorage.setItem('contact_' + this.name, this.value);
            }, 1000);
        });

        // Load saved data
        const savedValue = localStorage.getItem('contact_' + input.name);
        if (savedValue) {
            input.value = savedValue;
            input.parentElement.classList.add('has-value');
            if (input.name === 'pesan') {
                charCount.textContent = savedValue.length;
            }
        }
    });

    // Clear saved data on successful submit
    form.addEventListener('submit', function() {
        inputs.forEach(input => {
            localStorage.removeItem('contact_' + input.name);
        });
    });

    // Add animation when scrolling into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideUp 0.6s ease-out';
            }
        });
    }, { threshold: 0.1 });

    observer.observe(document.querySelector('.contact-container'));
</script>

@endsection