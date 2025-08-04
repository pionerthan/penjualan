<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Selamat Datang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated background particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 60px; height: 60px; left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { width: 100px; height: 100px; left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { width: 40px; height: 40px; left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { width: 70px; height: 70px; left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { width: 90px; height: 90px; left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { width: 50px; height: 50px; left: 70%; animation-delay: 0.5s; }
        .particle:nth-child(8) { width: 110px; height: 110px; left: 80%; animation-delay: 1.5s; }

        @keyframes float {
            0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            color: white;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-group input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .form-group .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 20px;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            font-size: 20px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: white;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 15px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(238, 90, 36, 0.4);
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.3);
        }

        .divider span {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            padding: 0 20px;
            font-size: 14px;
        }

        .register-link {
            text-align: center;
        }

        .register-link a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 10px 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .register-link a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
        }

        .forgot-password {
            text-align: center;
            margin-top: 15px;
        }

        .forgot-password a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: white;
            text-decoration: underline;
        }

        /* Loading animation */
        .loading {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
                padding: 30px 25px;
            }
            
            .login-header h2 {
                font-size: 1.8rem;
            }
        }

        /* Success animation */
        @keyframes success {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .success {
            animation: success 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Animated background particles -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="login-container">
        <div class="login-header">
            <h2>Selamat Datang</h2>
            <p>Masuk ke akun pembeli Anda</p>
        </div>

        <form method="POST" action="/login" id="loginForm">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Alamat Email" required>
                <div class="input-icon">📧</div>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Kata Sandi" required id="passwordInput">
                <div class="password-toggle" onclick="togglePassword()">👁️</div>
            </div>

            <button type="submit" class="login-btn" id="loginBtn">
                <div class="loading" id="loading"></div>
                <span id="btnText">Masuk</span>
            </button>
        </form>

        <div class="forgot-password">
            <a href="/forgot-password">Lupa kata sandi?</a>
        </div>

        <div class="divider">
            <span>atau</span>
        </div>

        <div class="register-link">
            <a href="/register">✨ Belum punya akun? Daftar Sekarang</a>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }

        // Form submission with loading animation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginBtn = document.getElementById('loginBtn');
            const loading = document.getElementById('loading');
            const btnText = document.getElementById('btnText');
            
            // Show loading animation
            loading.style.display = 'inline-block';
            btnText.textContent = 'Sedang Masuk...';
            loginBtn.style.pointerEvents = 'none';
            
            // Form akan disubmit secara normal ke Laravel
            // Loading animation akan berhenti saat halaman redirect/reload
        });

        // Add floating animation to form inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Add particles click effect
        document.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'BUTTON' && e.target.tagName !== 'A') {
                createRipple(e.pageX, e.pageY);
            }
        });

        function createRipple(x, y) {
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.style.width = '10px';
            ripple.style.height = '10px';
            ripple.style.background = 'rgba(255, 255, 255, 0.3)';
            ripple.style.borderRadius = '50%';
            ripple.style.transform = 'translate(-50%, -50%)';
            ripple.style.animation = 'rippleEffect 0.6s ease-out';
            ripple.style.pointerEvents = 'none';
            ripple.style.zIndex = '5';
            
            document.body.appendChild(ripple);
            
            setTimeout(() => {
                document.body.removeChild(ripple);
            }, 600);
        }

        // Add ripple effect animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes rippleEffect {
                0% {
                    transform: translate(-50%, -50%) scale(0);
                    opacity: 1;
                }
                100% {
                    transform: translate(-50%, -50%) scale(10);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Add typing effect for placeholder (optional enhancement)
        function addTypingEffect() {
            const inputs = document.querySelectorAll('input[placeholder]');
            
            inputs.forEach(input => {
                const originalPlaceholder = input.placeholder;
                input.placeholder = '';
                
                let i = 0;
                const typeInterval = setInterval(() => {
                    input.placeholder += originalPlaceholder.charAt(i);
                    i++;
                    if (i > originalPlaceholder.length - 1) {
                        clearInterval(typeInterval);
                    }
                }, 100);
            });
        }

        // Initialize typing effect after page load
        window.addEventListener('load', () => {
            setTimeout(addTypingEffect, 500);
        });
    </script>
</body>
</html>