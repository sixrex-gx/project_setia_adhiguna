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
  --bg-card: rgba(18, 18, 18, 0.7);
  --border-subtle: rgba(255, 255, 255, 0.06);
  --border-active: rgba(245, 158, 11, 0.5);
  --text-primary: #f5f5f5;
  --text-secondary: #a0a0a0;
  --text-muted: #555;
  --danger: #ef4444;
  --radius: 16px;
  --radius-sm: 10px;
  --ease-spring: cubic-bezier(0.16, 1, 0.3, 1);
}

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #050505 0%, #0f0f0f 50%, #080808 100%);
      font-family: 'DM Sans', sans-serif;
      position: relative;
      overflow: hidden;
    }

    .stars {
      position: absolute;
      inset: 0;
      pointer-events: none;
      overflow: hidden;
    }

.stars::before,
.stars::after {
  content: '';
  position: absolute;
  width: 3px;
  height: 3px;
  border-radius: 50%;
  background: transparent;
  animation: twinkle 4s ease-in-out infinite alternate;
}

.stars::after {
  width: 2px;
  height: 2px;
}

/* Tambahkan pseudo-element ketiga untuk variasi bintang */
.stars::before,
.stars::after {
  box-shadow: inherit;
  animation-delay: 0s;
}

/* Tambahkan elemen tambahan dengan pseudo-element menggunakan :before dan :after dari elemen lain */
.stars {
  position: absolute;
  inset: 0;
  pointer-events: none;
  overflow: hidden;
}

/* Kita akan menggunakan elemen tambahan untuk variasi bintang lebih */
.stars::before {
  animation-delay: 0s;
}

.stars::after {
  animation-delay: 1.5s;
  width: 2px;
  height: 2px;
}

/* Untuk variasi ketiga, kita bisa menggunakan animation delay berbeda */

.stars::before {
  box-shadow:
    10px 20px 0 0 rgba(255,255,255,0.9), 80px 60px 0 0 rgba(255,255,255,0.6),
    160px 120px 0 0 rgba(255,255,255,0.8), 240px 40px 0 0 rgba(255,255,255,0.5),
    320px 180px 0 0 rgba(255,255,255,0.9), 400px 90px 0 0 rgba(255,255,255,0.6),
    480px 200px 0 0 rgba(255,255,255,0.5), 560px 50px 0 0 rgba(245,158,11,0.7),
    640px 150px 0 0 rgba(255,255,255,0.7), 720px 80px 0 0 rgba(255,255,255,0.9),
    800px 220px 0 0 rgba(255,255,255,0.5), 50px 280px 0 0 rgba(245,158,11,0.6),
    180px 340px 0 0 rgba(255,255,255,0.7), 300px 400px 0 0 rgba(255,255,255,0.9),
    420px 260px 0 0 rgba(255,255,255,0.5), 540px 380px 0 0 rgba(245,158,11,0.7),
    660px 300px 0 0 rgba(255,255,255,0.6), 780px 360px 0 0 rgba(255,255,255,0.5),
    100px 440px 0 0 rgba(255,255,255,0.8), 220px 500px 0 0 rgba(255,255,255,0.6),
    380px 460px 0 0 rgba(245,158,11,0.9), 500px 540px 0 0 rgba(255,255,255,0.5),
    620px 480px 0 0 rgba(255,255,255,0.7), 740px 520px 0 0 rgba(255,255,255,0.6),
    70px 580px 0 0 rgba(255,255,255,0.5), 200px 620px 0 0 rgba(245,158,11,0.8),
    350px 560px 0 0 rgba(255,255,255,0.7), 470px 640px 0 0 rgba(255,255,255,0.9),
    600px 600px 0 0 rgba(255,255,255,0.5), 700px 660px 0 0 rgba(255,255,255,0.6),
    130px 700px 0 0 rgba(245,158,11,0.7), 260px 740px 0 0 rgba(255,255,255,0.5),
    430px 680px 0 0 rgba(255,255,255,0.9), 550px 760px 0 0 rgba(255,255,255,0.6),
    670px 720px 0 0 rgba(255,255,255,0.5), 790px 780px 0 0 rgba(245,158,11,0.7);
  animation-delay: 0s;
  filter: blur(0.3px);
  animation-name: twinkle;
}

.stars::after {
  width: 2px;
  height: 2px;
  box-shadow:
    40px 100px 0 0 rgba(255,255,255,0.5), 120px 30px 0 0 rgba(245,158,11,0.7),
    200px 170px 0 0 rgba(255,255,255,0.6), 280px 80px 0 0 rgba(255,255,255,0.9),
    360px 210px 0 0 rgba(255,255,255,0.5), 440px 130px 0 0 rgba(255,255,255,0.7),
    520px 250px 0 0 rgba(245,158,11,0.6), 600px 40px 0 0 rgba(255,255,255,0.5),
    680px 190px 0 0 rgba(255,255,255,0.8), 760px 110px 0 0 rgba(255,255,255,0.6),
    30px 330px 0 0 rgba(255,255,255,0.9), 150px 290px 0 0 rgba(255,255,255,0.5),
    270px 430px 0 0 rgba(245,158,11,0.7), 390px 350px 0 0 rgba(255,255,255,0.6),
    510px 490px 0 0 rgba(255,255,255,0.5), 630px 410px 0 0 rgba(255,255,255,0.9),
    750px 530px 0 0 rgba(255,255,255,0.6), 90px 610px 0 0 rgba(245,158,11,0.7),
    210px 570px 0 0 rgba(255,255,255,0.5), 330px 670px 0 0 rgba(255,255,255,0.6),
    450px 590px 0 0 rgba(255,255,255,0.9), 570px 710px 0 0 rgba(255,255,255,0.7),
    690px 650px 0 0 rgba(255,255,255,0.5), 770px 730px 0 0 rgba(245,158,11,0.6),
    60px 790px 0 0 rgba(255,255,255,0.8), 180px 750px 0 0 rgba(255,255,255,0.5),
    340px 810px 0 0 rgba(255,255,255,0.6), 460px 770px 0 0 rgba(255,255,255,0.9),
    580px 830px 0 0 rgba(245,158,11,0.5), 700px 790px 0 0 rgba(255,255,255,0.7),
    110px 130px 0 0 rgba(255,255,255,0.5), 230px 230px 0 0 rgba(255,255,255,0.6),
    370px 50px 0 0 rgba(245,158,11,0.8), 490px 310px 0 0 rgba(255,255,255,0.5),
    650px 160px 0 0 rgba(255,255,255,0.6), 730px 440px 0 0 rgba(255,255,255,0.9),
    50px 490px 0 0 rgba(255,255,255,0.5), 170px 390px 0 0 rgba(245,158,11,0.7),
    310px 510px 0 0 rgba(255,255,255,0.6), 410px 710px 0 0 rgba(255,255,255,0.5),
    530px 230px 0 0 rgba(255,255,255,0.8), 630px 550px 0 0 rgba(255,255,255,0.6);
  animation-delay: 1.5s;
  filter: blur(0.2px);
  animation-name: twinkle;
}

/* Tambahkan lapisan bintang ketiga untuk kedalaman */
.stars::before {
  animation-delay: 0s;
}

.stars::after {
  animation-delay: 1.5s;
}

/* Tambahkan pseudo-element tambahan untuk variasi */
.stars::before,
.stars::after {
  box-shadow: inherit;
}

@keyframes twinkle {
  0% { opacity: 0.1; transform: scale(0.3) rotate(0deg); }
  20% { opacity: 0.4; transform: scale(0.6) rotate(30deg); }
  40% { opacity: 0.6; transform: scale(0.8) rotate(60deg); }
  60% { opacity: 0.8; transform: scale(1.0) rotate(90deg); }
  80% { opacity: 0.6; transform: scale(0.8) rotate(120deg); }
  100% { opacity: 0.2; transform: scale(0.4) rotate(150deg); }
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
      will-change: transform;
    }

    .blob-container .blob:first-child {
      width: 520px;
      height: 520px;
      top: -10%;
      left: -6%;
      background: radial-gradient(circle at 30% 30%, rgba(245, 158, 11, 0.35), transparent 70%);
      animation: floatBlob1 18s ease-in-out infinite;
    }

    .blob-container .blob:nth-child(2) {
      width: 440px;
      height: 440px;
      bottom: -14%;
      right: -10%;
      background: radial-gradient(circle at 70% 70%, rgba(251, 191, 36, 0.25), transparent 70%);
      animation: floatBlob2 22s ease-in-out infinite;
    }

    .blob-container .blob:nth-child(3) {
      width: 320px;
      height: 320px;
      top: 38%;
      left: 52%;
      background: radial-gradient(circle at 50% 50%, rgba(245, 158, 11, 0.15), transparent 70%);
      animation: floatBlob3 16s ease-in-out infinite;
    }

    @keyframes floatBlob1 {
      0%, 100% { transform: translate(0, 0) scale(1); }
      33% { transform: translate(40px, -30px) scale(1.05); }
      66% { transform: translate(-20px, 20px) scale(0.95); }
    }

    @keyframes floatBlob2 {
      0%, 100% { transform: translate(0, 0) scale(1); }
      33% { transform: translate(-30px, 40px) scale(0.95); }
      66% { transform: translate(20px, -20px) scale(1.05); }
    }

    @keyframes floatBlob3 {
      0%, 100% { transform: translate(0, 0) scale(1); }
      50% { transform: translate(25px, 25px) scale(1.08); }
    }

    .grid-overlay {
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.01) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.01) 1px, transparent 1px);
      background-size: 60px 60px;
      pointer-events: none;
    }

    .vignette {
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at center, transparent 25%, rgba(0, 0, 0, 0.6) 100%);
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
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid var(--border-subtle);
      border-radius: var(--radius);
      padding: 36px 32px;
      box-shadow:
        0 40px 80px -20px rgba(0, 0, 0, 0.8),
        0 0 0 1px rgba(255, 255, 255, 0.02) inset,
        0 1px 0 rgba(255, 255, 255, 0.03) inset;
      position: relative;
      overflow: hidden;
      opacity: 0;
      transform: scale(0.93) translateY(30px);
      animation: cardEntrance 0.8s var(--ease-spring) 0.1s forwards;
    }

    @keyframes cardEntrance {
      to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -50%;
      width: 200%;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.3), transparent);
      animation: borderShimmer 6s ease-in-out infinite;
    }

    @keyframes borderShimmer {
      0%, 100% { transform: translateX(-30%); }
      50% { transform: translateX(30%); }
    }

    .login-card::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: -50%;
      width: 200%;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.12), transparent);
      animation: borderShimmer 6s ease-in-out 3s infinite;
    }

    .login-card:hover {
      border-color: rgba(245, 158, 11, 0.08);
      box-shadow:
        0 40px 80px -20px rgba(0, 0, 0, 0.8),
        0 0 0 1px rgba(245, 158, 11, 0.03) inset,
        0 1px 0 rgba(255, 255, 255, 0.03) inset;
      transition: all 0.6s ease;
    }

    .card-corner {
      position: absolute;
      width: 40px;
      height: 40px;
      border-color: rgba(245, 158, 11, 0.12);
      border-style: solid;
      border-width: 0;
      pointer-events: none;
      transition: border-color 0.5s ease;
    }

    .login-card:hover .card-corner {
      border-color: rgba(245, 158, 11, 0.25);
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
      inset: -10px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(245, 158, 11, 0.1), transparent 70%);
      animation: logoPulse 4s ease-in-out infinite;
    }

    @keyframes logoPulse {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.15); opacity: 1; }
    }

    .logo-img {
      height: 80px;
      width: auto;
      object-fit: contain;
      display: block;
      margin: 0 auto;
      position: relative;
      z-index: 1;
      filter: drop-shadow(0 4px 20px rgba(245, 158, 11, 0.2));
      transition: filter 0.4s ease;
    }

    .logo-wrapper:hover .logo-img {
      filter: drop-shadow(0 6px 28px rgba(245, 158, 11, 0.35));
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
      transition: all 0.35s var(--ease-spring);
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
      transition: all 0.35s var(--ease-spring);
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
      transition: all 0.45s var(--ease-spring);
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
      box-shadow:
        0 0 0 4px rgba(245, 158, 11, 0.08),
        0 0 24px rgba(245, 158, 11, 0.04);
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
      background: rgba(18, 18, 18, 1);
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
      transition: color 0.35s var(--ease-spring);
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
      transition: all 0.3s var(--ease-spring);
      z-index: 2;
      border-radius: 8px;
    }

    .password-toggle:hover {
      color: var(--primary);
      background: rgba(245, 158, 11, 0.1);
    }

    .password-toggle:active {
      transform: translateY(-50%) scale(0.9);
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
      transition: all 0.3s var(--ease-spring);
      background: rgba(10, 10, 10, 0.5);
      position: relative;
      flex-shrink: 0;
    }

    .remember-me:hover .checkmark {
      border-color: rgba(245, 158, 11, 0.3);
    }

    .checkmark i {
      font-size: 10px;
      color: #000;
      opacity: 0;
      transform: scale(0);
      transition: all 0.25s var(--ease-spring);
    }

    .remember-me input:checked + .checkmark {
      background: var(--primary);
      border-color: var(--primary);
      box-shadow: 0 0 16px rgba(245, 158, 11, 0.3);
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
      transition: all 0.3s var(--ease-spring);
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
      transition: width 0.3s var(--ease-spring);
    }

    .forgot-link:hover::after {
      width: 100%;
    }

    .forgot-link:hover {
      color: var(--primary-light);
    }

    .btn-login {
      width: 100%;
      padding: 14px 20px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border: none;
      border-radius: var(--radius-sm);
      color: #000;
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: 14px;
      letter-spacing: 1px;
      cursor: pointer;
      transition: all 0.35s var(--ease-spring);
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
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
      transition: left 0.8s var(--ease-spring);
    }

    .btn-login::after {
      content: '';
      position: absolute;
      inset: -2px;
      border-radius: calc(var(--radius-sm) + 2px);
      background: linear-gradient(135deg, var(--primary-light), var(--primary), var(--primary-dark));
      z-index: -1;
      opacity: 0;
      transition: opacity 0.35s ease;
    }

    .btn-login:hover {
      transform: translateY(-2px) scale(1.01);
      box-shadow:
        0 16px 40px -8px rgba(245, 158, 11, 0.45),
        0 0 0 1px rgba(245, 158, 11, 0.1);
    }

    .btn-login:hover::before {
      left: 100%;
    }

    .btn-login:hover::after {
      opacity: 0.8;
    }

    .btn-login:active {
      transform: translateY(0) scale(0.98);
      box-shadow: 0 8px 20px -5px rgba(245, 158, 11, 0.3);
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
      transition: transform 0.35s var(--ease-spring);
    }

    .btn-login:hover .btn-text i {
      transform: translateX(5px);
    }

    .btn-login:active .btn-text i {
      transform: translateX(8px);
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
      animation: shake 0.5s var(--ease-spring), fadeIn 0.3s ease-out;
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
      transform: translateY(14px);
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

    @media (min-width: 481px) and (max-width: 768px) {
      .login-card {
        padding: 32px 28px;
      }
    }

    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.4s ease;
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
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
      transition: transform 0.5s var(--ease-spring);
      box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.6);
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
      animation: modalIconPulse 2s ease-in-out infinite;
    }

    @keyframes modalIconPulse {
      0%, 100% { box-shadow: 0 8px 24px rgba(245, 158, 11, 0.25); }
      50% { box-shadow: 0 8px 32px rgba(245, 158, 11, 0.4); }
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
      transition: color 0.3s ease;
    }

    .contact-item:hover {
      color: var(--primary-light);
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
      transition: all 0.3s var(--ease-spring);
    }

    .modal-close-btn:hover {
      background: rgba(255, 255, 255, 0.04);
      border-color: rgba(245, 158, 11, 0.3);
      color: #fff;
    }

    .modal-close-btn:active {
      transform: scale(0.97);
    }
  </style>
</head>
<body>
  <div class="stars"></div>
  <div class="blob-container">
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
            <input type="text" name="email" value="{{ old('email') }}" id="email" placeholder=" " required autofocus maxlength="16">
            <span class="input-line"></span>
            <label for="email" class="floating-label">Email</label>
            <i class="fas fa-envelope input-icon"></i>
          </div>
        </div>

        <div class="form-group">
          <div class="input-wrapper">
            <input type="password" name="password" id="password" placeholder=" " required minlength="8" maxlength="8" oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')">
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
      const email = document.getElementById('email');
      const password = document.getElementById('password');

      if (email.value.length > 16) {
        e.preventDefault();
        alert('Email maksimal 16 karakter.');
        return;
      }

      if (password.value.length !== 8 || !/^[a-zA-Z0-9]+$/.test(password.value)) {
        e.preventDefault();
        alert('Password harus 8 karakter kombinasi huruf dan angka.');
        return;
      }

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
        el.style.animation = `fadeInUp 0.6s var(--ease-spring) ${0.15 + i * 0.08}s forwards`;
      });
    });

    const style = document.createElement('style');
    style.textContent = `
      @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
      }
    `;
    document.head.appendChild(style);
  </script>
</body>
</html>