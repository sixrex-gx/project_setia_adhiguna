<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — TokoAdv</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Mono:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --primary: #f59e0b;
      --primary-light: #fbbf24;
      --primary-dark: #d97706;
      --bg-dark: #0a0a0a;
      --bg-card: rgba(26, 26, 26, 0.85);
      --border-subtle: rgba(255, 255, 255, 0.08);
      --text-primary: #f5f5f5;
      --text-secondary: #6b7280;
      --text-muted: #4b5563;
      --danger: #ef4444;
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #0a0a0a 0%, #141414 50%, #0f0f0f 100%);
      font-family: 'DM Sans', sans-serif;
      position: relative;
      overflow: hidden;
    }

    .bg-pattern {
      position: absolute;
      inset: 0;
      background-image: 
        radial-gradient(circle at 20% 30%, rgba(245, 158, 11, 0.06) 0%, transparent 40%),
        radial-gradient(circle at 80% 70%, rgba(245, 158, 11, 0.04) 0%, transparent 40%),
        linear-gradient(rgba(255,255,255,0.01) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.01) 1px, transparent 1px);
      background-size: 100% 100%, 100% 100%, 50px 50px, 50px 50px;
      pointer-events: none;
    }

    .bg-glow {
      position: absolute;
      width: 600px;
      height: 600px;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: radial-gradient(circle, rgba(245, 158, 11, 0.08) 0%, transparent 60%);
      animation: float 20s ease-in-out infinite;
      pointer-events: none;
    }

    @keyframes float {
      0%, 100% { transform: translate(-50%, -50%) scale(1); }
      50% { transform: translate(-50%, -50%) scale(1.1); }
    }

    .login-container {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 420px;
      padding: 20px;
    }

    .login-card {
      background: var(--bg-card);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid var(--border-subtle);
      border-radius: 14px;
      padding: 32px 28px;
      box-shadow: 
        0 25px 50px -12px rgba(0, 0, 0, 0.6),
        0 0 0 1px rgba(255, 255, 255, 0.02) inset,
        0 1px 0 rgba(255, 255, 255, 0.03) inset;
      animation: cardEnter 0.6s ease-out;
      position: relative;
      overflow: hidden;
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.3), transparent);
    }

    @keyframes cardEnter {
      from {
        opacity: 0;
        transform: translateY(20px) scale(0.98);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .header {
      text-align: center;
      margin-bottom: 32px;
      animation: fadeInUp 0.6s ease-out 0.1s both;
    }

    .logo-wrapper {
      margin-bottom: 20px;
    }

    .logo-img {
      height: 90px;
      width: auto;
      object-fit: contain;
      display: block;
      margin: 0 auto;
      filter: drop-shadow(0 4px 12px rgba(245, 158, 11, 0.2));
    }

    .brand-name {
      font-family: 'Space Mono', monospace;
      font-size: 18px;
      font-weight: 700;
      color: var(--text-primary);
      letter-spacing: 3px;
      margin-bottom: 6px;
    }

    .brand-tagline {
      color: var(--text-secondary);
      font-size: 13px;
      font-weight: 400;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .form-group {
      margin-bottom: 24px;
      position: relative;
      animation: fadeInUp 0.5s ease-out 0.2s both;
    }

    .input-wrapper {
      position: relative;
    }

    .floating-label {
      position: absolute;
      left: 48px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 15px;
      pointer-events: none;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      background: transparent;
      padding: 0 4px;
    }

    .form-group input {
      width: 100%;
      padding: 14px 48px 14px 48px;
      background: rgba(12, 12, 12, 0.6);
      border: 1px solid var(--border-subtle);
      border-radius: 10px;
      color: var(--text-primary);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      outline: none;
      transition: all 0.3s ease;
    }

    .form-group input::placeholder {
      color: transparent;
    }

    .form-group input:focus,
    .form-group input:not(:placeholder-shown) {
      border-color: var(--primary);
      background: rgba(12, 12, 12, 0.8);
      box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.08);
    }

    .form-group input:focus + .input-icon,
    .form-group:hover .input-icon {
      color: var(--primary);
    }

    .floating-label.active {
      top: 0;
      font-size: 11px;
      color: var(--primary);
      background: rgba(26, 26, 26, 1);
      left: 16px;
      padding: 0 8px;
    }

    .input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 16px;
      transition: color 0.25s ease;
      z-index: 2;
    }

    .input-icon.password-icon {
      left: 18px;
    }

    .password-toggle {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--text-muted);
      cursor: pointer;
      padding: 4px;
      transition: color 0.25s ease;
      z-index: 2;
    }

    .password-toggle:hover {
      color: var(--text-secondary);
    }

    .form-options {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 28px;
      animation: fadeInUp 0.5s ease-out 0.3s both;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
    }

    .remember-me input[type="checkbox"] {
      display: none;
    }

    .checkmark {
      width: 20px;
      height: 20px;
      border: 1px solid var(--border-subtle);
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      background: rgba(12, 12, 12, 0.6);
      position: relative;
    }

    .checkmark::after {
      content: '';
      position: absolute;
      width: 10px;
      height: 6px;
      border: 2px solid transparent;
      border-top: none;
      border-right: none;
      transform: rotate(-45deg) scale(0);
      transition: transform 0.2s ease;
      margin-top: -2px;
    }

    .remember-me input:checked + .checkmark {
      background: var(--primary);
      border-color: var(--primary);
    }

    .remember-me input:checked + .checkmark::after {
      border-color: #000;
    }

    .remember-me span {
      color: var(--text-secondary);
      font-size: 13px;
    }

    .forgot-link {
      color: var(--primary);
      font-size: 13px;
      text-decoration: none;
      transition: color 0.25s ease;
      position: relative;
    }

    .forgot-link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 1px;
      background: var(--primary);
      transition: width 0.3s ease;
    }

    .forgot-link:hover::after {
      width: 100%;
    }

    .forgot-link:hover {
      color: var(--primary-light);
    }

    .btn-login {
      width: 100%;
      padding: 12px 20px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border: none;
      border-radius: 10px;
      color: #000;
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: 14px;
      letter-spacing: 0.5px;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      animation: fadeInUp 0.5s ease-out 0.4s both;
    }

    .btn-login::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
      transition: left 0.5s ease;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
      transform: translateY(-2px);
      box-shadow: 0 12px 32px -8px rgba(245, 158, 11, 0.5);
    }

    .btn-login:hover::before {
      left: 100%;
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-login.loading {
      pointer-events: none;
      color: transparent;
    }

    .btn-login.loading::after {
      content: '';
      position: absolute;
      width: 22px;
      height: 22px;
      top: 50%;
      left: 50%;
      margin: -11px 0 0 -11px;
      border: 2px solid rgba(0, 0, 0, 0.2);
      border-top-color: #000;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .btn-text {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .error-message {
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.2);
      color: #fca5a5;
      border-radius: 12px;
      padding: 16px;
      font-size: 13px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      animation: shake 0.5s ease-in-out, fadeIn 0.3s ease-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20% { transform: translateX(-6px); }
      40% { transform: translateX(6px); }
      60% { transform: translateX(-4px); }
      80% { transform: translateX(4px); }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .error-message i {
      color: var(--danger);
      font-size: 16px;
    }

    .footer-text {
      text-align: center;
      margin-top: 28px;
      color: var(--text-muted);
      font-size: 12px;
      animation: fadeInUp 0.5s ease-out 0.5s both;
    }

    @media (max-width: 480px) {
      .login-card {
        padding: 36px 24px;
        border-radius: 20px;
      }

      .logo-img {
        height: 70px;
      }

      .brand-name {
        font-size: 16px;
      }

      .floating-label {
        left: 46px;
      }

      .form-group input {
        padding: 18px 46px 18px 46px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div class="header">
        <div class="logo-wrapper">
          <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo Setia Adhiguna" class="logo-img">
        </div>
        <div class="brand-name">TOKOADV</div>
        <div class="brand-tagline">Sistem POS ATK & Advertising</div>
      </div>

      <div class="divider"></div>

      @if($errors->any())
        <div class="error-message">
          <i class="fas fa-exclamation-circle"></i>
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}" id="loginForm">
        @csrf

        <div class="form-group">
          <div class="input-wrapper">
            <input type="email" name="email" value="{{ old('email') }}" id="email" placeholder=" " required autofocus>
            <label for="email" class="floating-label">Email</label>
            <i class="fas fa-envelope input-icon"></i>
          </div>
        </div>

        <div class="form-group">
          <div class="input-wrapper">
            <input type="password" name="password" id="password" placeholder=" " required>
            <label for="password" class="floating-label">Password</label>
            <i class="fas fa-lock input-icon password-icon"></i>
            <button type="button" class="password-toggle" onclick="togglePassword()">
              <i class="fas fa-eye" id="eye-icon"></i>
            </button>
          </div>
        </div>

        <div class="form-options">
          <label class="remember-me">
            <input type="checkbox" name="remember">
            <span class="checkmark"><i class="fas fa-check"></i></span>
            <span>Ingat saya</span>
          </label>
          <a href="#" class="forgot-link" onclick="showAdminContact(event)">Lupa password?</a>
        </div>

        <button type="submit" class="btn-login">
          <span class="btn-text">
            MASUK
            <i class="fas fa-arrow-right"></i>
          </span>
        </button>
      </form>

<div class="footer-text">
        &copy; {{ date('Y') }} Setia Adhiguna Adv. All rights reserved.
      </div>
    </div>
  </div>

  <div id="adminContactModal" class="modal-overlay">
    <div class="modal-content">
      <div class="modal-icon">
        <i class="fas fa-headset"></i>
      </div>
      <h3>Hubungi Admin</h3>
      <p>Silakan hubungi admin untuk mereset password Anda</p>
      <div class="contact-info">
        <div class="contact-item">
          <i class="fab fa-whatsapp"></i>
          <span>0821-9302-2967</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <span>admin@tokoadv.id</span>
        </div>
      </div>
      <button class="modal-close-btn" onclick="closeModal()">Tutup</button>
    </div>
  </div>

  <style>
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(5px);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }

    .modal-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .modal-content {
      background: linear-gradient(145deg, #1f1f1f, #2a2a2a);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 40px 32px;
      text-align: center;
      max-width: 360px;
      width: 90%;
      transform: scale(0.9) translateY(20px);
      transition: transform 0.3s ease;
    }

    .modal-overlay.active .modal-content {
      transform: scale(1) translateY(0);
    }

    .modal-icon {
      width: 64px;
      height: 64px;
      background: linear-gradient(135deg, #f59e0b, #d97706);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
    }

    .modal-icon i {
      font-size: 28px;
      color: #000;
    }

    .modal-content h3 {
      color: #fff;
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .modal-content p {
      color: #9ca3af;
      font-size: 14px;
      margin-bottom: 24px;
      line-height: 1.5;
    }

    .contact-info {
      background: rgba(0, 0, 0, 0.3);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 24px;
    }

    .contact-item {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      padding: 10px 0;
      color: #f5f5f5;
      font-size: 15px;
    }

    .contact-item:not(:last-child) {
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .contact-item i {
      color: #f59e0b;
      font-size: 18px;
    }

    .modal-close-btn {
      width: 100%;
      padding: 14px;
      background: transparent;
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 10px;
      color: #9ca3af;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
    }

    .modal-close-btn:hover {
      background: rgba(255, 255, 255, 0.05);
      border-color: rgba(255, 255, 255, 0.25);
      color: #fff;
    }
  </style>

  <script>
    document.querySelectorAll('.floating-label').forEach(label => {
      const inputId = label.getAttribute('for');
      const input = document.getElementById(inputId);
      
      if (input && input.value) {
        label.classList.add('active');
      }

      input.addEventListener('input', function() {
        label.classList.toggle('active', this.value.length > 0);
      });

      input.addEventListener('focus', function() {
        label.classList.add('active');
      });

      input.addEventListener('blur', function() {
        if (!this.value) {
          label.classList.remove('active');
        }
      });
    });

    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eye-icon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }

    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const btn = document.querySelector('.btn-login');
      btn.classList.add('loading');
      btn.querySelector('.btn-text').style.opacity = '0';
    });

    function showAdminContact(e) {
      e.preventDefault();
      document.getElementById('adminContactModal').classList.add('active');
    }

    function closeModal() {
      document.getElementById('adminContactModal').classList.remove('active');
    }

    document.getElementById('adminContactModal').addEventListener('click', function(e) {
      if (e.target === this) closeModal();
    });
  </script>
</body>
</html>
