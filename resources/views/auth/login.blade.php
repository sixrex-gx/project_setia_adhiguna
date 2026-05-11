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

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(145deg, #0a0a0a, #1a1a1a);
      font-family: 'DM Sans', sans-serif;
      position: relative;
      overflow: hidden;
    }

    body::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(245, 158, 11, 0.03) 0%, transparent 50%);
      animation: pulse 8s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.1); opacity: 1; }
    }

    .login-container {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 420px;
      padding: 20px;
    }

    .login-card {
      background: rgba(26, 26, 26, 0.8);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 20px;
      padding: 48px 40px;
      box-shadow: 
        0 25px 50px -12px rgba(0, 0, 0, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.05);
    }

    .header {
      text-align: center;
      margin-bottom: 36px;
    }

    .logo-wrapper {
      margin-bottom: 20px;
    }

    .logo-img {
      height: 110px;
      width: auto;
      object-fit: contain;
      display: block;
      margin: 0 auto;
    }

    .brand-name {
      font-family: 'Space Mono', monospace;
      font-size: 20px;
      font-weight: 700;
      color: #fff;
      letter-spacing: 2px;
      margin-bottom: 8px;
    }

    .brand-tagline {
      color: #6b7280;
      font-size: 13px;
      font-weight: 400;
    }

    .divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.3), transparent);
      margin: 24px 0;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #4b5563;
      font-size: 16px;
      transition: color 0.3s;
      z-index: 2;
    }

    .form-group input {
      width: 100%;
      padding: 14px 48px 14px 48px;
      background: rgba(15, 15, 15, 0.6);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 12px;
      color: #f5f5f5;
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      outline: none;
      transition: all 0.3s;
    }

    .form-group input::placeholder {
      color: #4b5563;
    }

    .form-group input:focus {
      border-color: #f59e0b;
      background: rgba(15, 15, 15, 0.8);
      box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .form-group input:focus + .input-icon,
    .form-group:hover .input-icon {
      color: #f59e0b;
    }

    .password-toggle {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #4b5563;
      cursor: pointer;
      padding: 4px;
      transition: color 0.3s;
      z-index: 2;
    }

    .password-toggle:hover {
      color: #9ca3af;
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
      gap: 8px;
      cursor: pointer;
    }

    .remember-me input[type="checkbox"] {
      display: none;
    }

    .checkmark {
      width: 18px;
      height: 18px;
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s;
      background: rgba(15, 15, 15, 0.6);
    }

    .checkmark i {
      font-size: 10px;
      color: #f59e0b;
      opacity: 0;
      transform: scale(0);
      transition: all 0.2s;
    }

    .remember-me input:checked + .checkmark {
      background: rgba(245, 158, 11, 0.15);
      border-color: #f59e0b;
    }

    .remember-me input:checked + .checkmark i {
      opacity: 1;
      transform: scale(1);
    }

    .remember-me span {
      color: #6b7280;
      font-size: 13px;
    }

    .forgot-link {
      color: #f59e0b;
      font-size: 13px;
      text-decoration: none;
      transition: color 0.3s;
    }

    .forgot-link:hover {
      color: #fbbf24;
    }

    .btn-login {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      border: none;
      border-radius: 12px;
      color: #000;
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: 15px;
      letter-spacing: 0.5px;
      cursor: pointer;
      transition: all 0.3s;
      position: relative;
      overflow: hidden;
    }

    .btn-login::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      transform: translateY(-2px);
      box-shadow: 0 10px 30px -10px rgba(245, 158, 11, 0.5);
    }

    .btn-login:hover::before {
      left: 100%;
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-text {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .error-message {
      background: rgba(127, 29, 29, 0.4);
      border: 1px solid rgba(239, 68, 68, 0.2);
      color: #fca5a5;
      border-radius: 10px;
      padding: 14px 16px;
      font-size: 13px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }

    .error-message i {
      color: #ef4444;
    }

    .footer-text {
      text-align: center;
      margin-top: 28px;
      color: #4b5563;
      font-size: 12px;
    }

    @media (max-width: 480px) {
      .login-card {
        padding: 32px 24px;
        border-radius: 16px;
      }

      .logo-img {
        height: 60px;
      }

      .brand-name {
        font-size: 18px;
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

      <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
          <div class="input-wrapper">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
            <i class="fas fa-envelope input-icon"></i>
          </div>
        </div>

        <div class="form-group">
          <div class="input-wrapper">
            <input type="password" name="password" id="password" placeholder="Password" required>
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
        </button>
      </form>

<div class="footer-text">
        &copy; {{ date('Y') }} TokoAdv. All rights reserved.
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
