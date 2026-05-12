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
      --primary-glow: rgba(245, 158, 11, 0.15);
      --bg-dark: #0a0a0a;
      --bg-card: rgba(20, 20, 20, 0.75);
      --border-subtle: rgba(255, 255, 255, 0.06);
      --border-active: rgba(245, 158, 11, 0.4);
      --text-primary: #f5f5f5;
      --text-secondary: #a0a0a0;
      --text-muted: #555;
      --danger: #ef4444;
      --radius: 16px;
      --radius-sm: 10px;
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #070707 0%, #111 50%, #090909 100%);
      font-family: 'DM Sans', sans-serif;
      position: relative;
      overflow: hidden;
    }

    .blob-container {
      position: absolute;
      inset: 0;
      overflow: hidden;
      pointer-events: none;
    }

    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.35;
      animation: blobMorph var(--duration) ease-in-out infinite alternate;
    }

    .blob:nth-child(1) {
      --duration: 18s;
      width: 520px;
      height: 520px;
      top: -10%;
      left: -5%;
      background: radial-gradient(circle, rgba(245, 158, 11, 0.5), rgba(217, 119, 6, 0.2));
      animation-delay: 0s;
    }

    .blob:nth-child(2) {
      --duration: 22s;
      width: 450px;
      height: 450px;
      bottom: -15%;
      right: -8%;
      background: radial-gradient(circle, rgba(251, 191, 36, 0.35), rgba(245, 158, 11, 0.1));
      animation-delay: -4s;
    }

    .blob:nth-child(3) {
      --duration: 20s;
      width: 350px;
      height: 350px;
      top: 40%;
      left: 55%;
      background: radial-gradient(circle, rgba(245, 158, 11, 0.25), rgba(251, 191, 36, 0.05));
      animation-delay: -9s;
    }

    .blob:nth-child(4) {
      --duration: 25s;
      width: 300px;
      height: 300px;
      top: 15%;
      right: 5%;
      background: radial-gradient(circle, rgba(217, 119, 6, 0.3), transparent);
      animation-delay: -14s;
    }

    .blob:nth-child(5) {
      --duration: 16s;
      width: 400px;
      height: 400px;
      bottom: 5%;
      left: 10%;
      background: radial-gradient(circle, rgba(245, 158, 11, 0.2), transparent);
      animation-delay: -7s;
    }

    @keyframes blobMorph {
      0% {
        border-radius: 50%;
        transform: translate(0, 0) scale(1);
      }
      25% {
        border-radius: 40% 60% 60% 40% / 50% 40% 60% 50%;
      }
      50% {
        border-radius: 60% 40% 40% 60% / 40% 60% 50% 60%;
        transform: translate(40px, -30px) scale(1.08);
      }
      75% {
        border-radius: 50% 50% 40% 60% / 50% 40% 60% 50%;
        transform: translate(-20px, 40px) scale(0.95);
      }
      100% {
        border-radius: 50%;
        transform: translate(0, 0) scale(1);
      }
    }

    .grid-overlay {
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.012) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.012) 1px, transparent 1px);
      background-size: 60px 60px;
      pointer-events: none;
    }

    .vignette {
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at center, transparent 30%, rgba(0, 0, 0, 0.5) 100%);
      pointer-events: none;
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
      backdrop-filter: blur(32px);
      -webkit-backdrop-filter: blur(32px);
      border: 1px solid var(--border-subtle);
      border-radius: var(--radius);
      padding: 36px 32px;
      box-shadow:
        0 30px 60px -15px rgba(0, 0, 0, 0.8),
        0 0 0 1px rgba(255, 255, 255, 0.015) inset,
        0 1px 0 rgba(255, 255, 255, 0.03) inset;
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
      background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.25), transparent);
    }

    .login-card::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.1), transparent);
    }

    .card-corner {
      position: absolute;
      width: 40px;
      height: 40px;
      border-color: rgba(245, 158, 11, 0.15);
      border-style: solid;
      border-width: 0;
      pointer-events: none;
    }

    .card-corner.tl { top: 12px; left: 12px; border-top-width: 1px; border-left-width: 1px; border-radius: 4px 0 0 0; }
    .card-corner.tr { top: 12px; right: 12px; border-top-width: 1px; border-right-width: 1px; border-radius: 0 4px 0 0; }
    .card-corner.bl { bottom: 12px; left: 12px; border-bottom-width: 1px; border-left-width: 1px; border-radius: 0 0 0 4px; }
    .card-corner.br { bottom: 12px; right: 12px; border-bottom-width: 1px; border-right-width: 1px; border-radius: 0 0 4px 0; }

    .header {
      text-align: center;
      margin-bottom: 28px;
    }

    .logo-wrapper {
      margin-bottom: 18px;
      position: relative;
      display: inline-block;
    }

    .logo-wrapper::after {
      content: '';
      position: absolute;
      inset: -8px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(245, 158, 11, 0.08), transparent 70%);
      animation: logoGlow 3s ease-in-out infinite;
    }

    @keyframes logoGlow {
      0%, 100% { opacity: 0.5; transform: scale(1); }
      50% { opacity: 1; transform: scale(1.05); }
    }

    .logo-img {
      height: 80px;
      width: auto;
      object-fit: contain;
      display: block;
      margin: 0 auto;
      position: relative;
      z-index: 1;
      filter: drop-shadow(0 4px 16px rgba(245, 158, 11, 0.15));
    }

    .brand-name {
      font-family: 'Space Mono', monospace;
      font-size: 16px;
      font-weight: 700;
      color: var(--text-primary);
      letter-spacing: 4px;
      margin-bottom: 6px;
    }

    .brand-tagline {
      color: var(--text-secondary);
      font-size: 12px;
      font-weight: 400;
      letter-spacing: 0.3px;
    }

    .divider {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 24px;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
    }

    .divider-dot {
      width: 4px;
      height: 4px;
      background: var(--primary);
      border-radius: 50%;
      opacity: 0.4;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .input-wrapper {
      position: relative;
    }

    .floating-label {
      position: absolute;
      left: 44px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 14px;
      pointer-events: none;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: transparent;
      padding: 0 6px;
      z-index: 1;
    }

    .form-group input {
      width: 100%;
      padding: 14px 44px 14px 44px;
      background: rgba(10, 10, 10, 0.5);
      border: 1px solid var(--border-subtle);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      outline: none;
      transition: all 0.3s ease;
    }

    .form-group input::placeholder {
      color: transparent;
    }

    .input-line {
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--primary), var(--primary-light));
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      transform: translateX(-50%);
      border-radius: 2px;
    }

    .form-group input:focus ~ .input-line {
      width: calc(100% - 28px);
    }

    .form-group input:focus,
    .form-group input:not(:placeholder-shown) {
      border-color: var(--border-active);
      background: rgba(10, 10, 10, 0.7);
      box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.05);
    }

    .form-group input:focus + .input-icon,
    .form-group:hover .input-icon {
      color: var(--primary);
    }

    .floating-label.active {
      top: 0;
      font-size: 11px;
      font-weight: 500;
      color: var(--primary);
      background: rgba(20, 20, 20, 1);
      left: 14px;
      padding: 0 8px;
    }

    .input-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 15px;
      transition: color 0.3s ease;
      z-index: 2;
    }

    .password-toggle {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--text-muted);
      cursor: pointer;
      padding: 6px;
      transition: all 0.3s ease;
      z-index: 2;
      border-radius: 8px;
    }

    .password-toggle:hover {
      color: var(--primary);
      background: rgba(245, 158, 11, 0.08);
    }

    .form-options {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      user-select: none;
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
      background: rgba(10, 10, 10, 0.5);
      position: relative;
      flex-shrink: 0;
    }

    .checkmark i {
      font-size: 10px;
      color: #000;
      opacity: 0;
      transform: scale(0);
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .remember-me input:checked + .checkmark {
      background: var(--primary);
      border-color: var(--primary);
      box-shadow: 0 0 12px rgba(245, 158, 11, 0.25);
    }

    .remember-me input:checked + .checkmark i {
      opacity: 1;
      transform: scale(1);
    }

    .remember-me span {
      color: var(--text-secondary);
      font-size: 13px;
    }

    .forgot-link {
      color: var(--primary);
      font-size: 13px;
      text-decoration: none;
      transition: all 0.3s ease;
      position: relative;
      font-weight: 500;
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
      padding: 13px 20px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border: none;
      border-radius: var(--radius-sm);
      color: #000;
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: 14px;
      letter-spacing: 1px;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      text-transform: uppercase;
    }

    .btn-login::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.6s ease;
    }

    .btn-login::after {
      content: '';
      position: absolute;
      inset: -2px;
      border-radius: calc(var(--radius-sm) + 2px);
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      z-index: -1;
      opacity: 0;
      transition: opacity 0.3s ease;
      filter: blur(12px);
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 32px -8px rgba(245, 158, 11, 0.4);
    }

    .btn-login:hover::before {
      left: 100%;
    }

    .btn-login:hover::after {
      opacity: 0.6;
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-login.loading {
      pointer-events: none;
      color: transparent;
    }

    .btn-login.loading::after {
      opacity: 0;
    }

    .btn-login.loading .spinner {
      position: absolute;
      top: 50%;
      left: 50%;
      margin: -11px 0 0 -11px;
      opacity: 1;
    }

    .spinner {
      display: inline-block;
      width: 22px;
      height: 22px;
      border: 2px solid rgba(0, 0, 0, 0.15);
      border-top-color: #000;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .btn-text {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: opacity 0.2s ease;
    }

    .btn-text i {
      transition: transform 0.3s ease;
    }

    .btn-login:hover .btn-text i {
      transform: translateX(4px);
    }

    .error-message {
      background: rgba(239, 68, 68, 0.08);
      border: 1px solid rgba(239, 68, 68, 0.15);
      color: #fca5a5;
      border-radius: var(--radius-sm);
      padding: 14px 16px;
      font-size: 13px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      animation: shake 0.5s ease-in-out, fadeIn 0.3s ease-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20% { transform: translateX(-5px); }
      40% { transform: translateX(5px); }
      60% { transform: translateX(-3px); }
      80% { transform: translateX(3px); }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .error-message i {
      color: var(--danger);
      font-size: 15px;
      flex-shrink: 0;
    }

    .footer-text {
      text-align: center;
      margin-top: 24px;
      color: var(--text-muted);
      font-size: 11px;
      letter-spacing: 0.2px;
    }

    .fade-in-up {
      opacity: 0;
      transform: translateY(12px);
    }

    @media (max-width: 480px) {
      .login-card {
        padding: 28px 20px;
        border-radius: 14px;
      }

      .logo-img {
        height: 65px;
      }

      .brand-name {
        font-size: 14px;
      }

      .floating-label {
        left: 42px;
        font-size: 13px;
      }

      .form-group input {
        padding: 13px 42px 13px 42px;
      }

      .card-corner { display: none; }
    }

    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.35s ease;
    }

    .modal-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .modal-content {
      background: linear-gradient(145deg, #1a1a1a, #222);
      border: 1px solid rgba(255, 255, 255, 0.06);
      border-radius: var(--radius);
      padding: 36px 28px;
      text-align: center;
      max-width: 340px;
      width: 90%;
      transform: scale(0.92) translateY(20px);
      transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.6);
    }

    .modal-overlay.active .modal-content {
      transform: scale(1) translateY(0);
    }

    .modal-icon {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 18px;
      box-shadow: 0 8px 24px rgba(245, 158, 11, 0.25);
    }

    .modal-icon i {
      font-size: 26px;
      color: #000;
    }

    .modal-content h3 {
      color: #fff;
      font-size: 19px;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .modal-content p {
      color: #999;
      font-size: 14px;
      margin-bottom: 22px;
      line-height: 1.5;
    }

    .contact-info {
      background: rgba(0, 0, 0, 0.25);
      border-radius: var(--radius-sm);
      padding: 14px;
      margin-bottom: 22px;
      border: 1px solid rgba(255, 255, 255, 0.03);
    }

    .contact-item {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      padding: 9px 0;
      color: #eee;
      font-size: 14px;
    }

    .contact-item:not(:last-child) {
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .contact-item i {
      color: var(--primary);
      font-size: 17px;
      width: 20px;
      text-align: center;
    }

    .modal-close-btn {
      width: 100%;
      padding: 12px;
      background: transparent;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-sm);
      color: #999;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
    }

    .modal-close-btn:hover {
      background: rgba(255, 255, 255, 0.04);
      border-color: rgba(255, 255, 255, 0.2);
      color: #fff;
    }
  </style>
</head>
<body>
  <div class="blob-container">
    <div class="blob"></div>
    <div class="blob"></div>
    <div class="blob"></div>
    <div class="blob"></div>
    <div class="blob"></div>
  </div>
  <div class="grid-overlay"></div>
  <div class="vignette"></div>

  <div class="login-container">
    <div class="login-card">
      <div class="card-corner tl"></div>
      <div class="card-corner tr"></div>
      <div class="card-corner bl"></div>
      <div class="card-corner br"></div>

      <div class="header">
        <div class="logo-wrapper">
          <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo Setia Adhiguna" class="logo-img">
        </div>
        <div class="brand-name">TOKOADV</div>
        <div class="brand-tagline">Sistem POS ATK & Advertising</div>
      </div>

      <div class="divider">
        <div class="divider-dot"></div>
      </div>

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
            <span class="input-line"></span>
            <label for="email" class="floating-label">Email</label>
            <i class="fas fa-envelope input-icon"></i>
          </div>
        </div>

        <div class="form-group">
          <div class="input-wrapper">
            <input type="password" name="password" id="password" placeholder=" " required>
            <span class="input-line"></span>
            <label for="password" class="floating-label">Password</label>
            <i class="fas fa-lock input-icon"></i>
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
          <div class="spinner" style="display:none"></div>
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
      btn.querySelector('.btn-text').style.display = 'none';
      btn.querySelector('.spinner').style.display = 'inline-block';
    });

    function showAdminContact(e) {
      e.preventDefault();
      document.getElementById('adminContactModal').classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeModal() {
      document.getElementById('adminContactModal').classList.remove('active');
      document.body.style.overflow = '';
    }

    document.getElementById('adminContactModal').addEventListener('click', function(e) {
      if (e.target === this) closeModal();
    });

    document.addEventListener('DOMContentLoaded', function() {
      const els = document.querySelectorAll('.header, .divider, .form-group, .form-options, .btn-login, .error-message, .footer-text');
      els.forEach((el, i) => {
        el.classList.add('fade-in-up');
        el.style.animation = `fadeInUp 0.5s ease-out ${0.1 + i * 0.08}s forwards`;
      });
    });

    const style = document.createElement('style');
    style.textContent = `
      @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
      }
    `;
    document.head.appendChild(style);
  </script>
</body>
</html>
