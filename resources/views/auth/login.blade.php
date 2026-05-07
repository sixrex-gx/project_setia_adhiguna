<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — TokoAdv</title>

  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Mono:wght@700&display=swap" rel="stylesheet">

  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #0f0f0f;
      font-family: 'DM Sans', sans-serif;
    }

    .login-box {
      background: #1a1a1a;
      border: 1px solid #333;
      border-radius: 12px;
      padding: 40px;
      width: 100%;
      max-width: 400px;
    }

    .nav-logo {
      text-align: center;
      margin-bottom: 5px;
    }

    .logo-img {
      height: 120px;
      width: auto;
      object-fit: contain;
      display: block;
      margin: 0 auto 5px auto;
    }

    .subtitle {
      text-align: center;
      color: #6b6b6b;
      font-size: 13px;
      margin-top: 4px;   
      margin-bottom: 16px; 
    }

    .form-group { margin-bottom: 16px; }

    label {
      display: block;
      font-size: 12px;
      font-weight: 500;
      color: #a3a3a3;
      margin-bottom: 6px;
    }

    input {
      width: 100%;
      padding: 10px 14px;
      background: #242424;
      border: 1px solid #333;
      border-radius: 8px;
      color: #f5f5f5;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      outline: none;
      transition: border-color .15s;
    }

    input:focus { border-color: #f59e0b; }

    .btn-login {
      width: 100%;
      padding: 12px;
      background: #f59e0b;
      border: none;
      border-radius: 8px;
      color: #000;
      font-weight: 700;
      font-size: 15px;
      cursor: pointer;
      margin-top: 8px;
      transition: background .15s;
    }

    .btn-login:hover { background: #fbbf24; }

    .error {
      background: #450a0a;
      color: #fca5a5;
      border-radius: 8px;
      padding: 10px 14px;
      font-size: 13px;
      margin-bottom: 16px;
    }
  </style>
</head>

<body>
  <div class="login-box">

    <div class="nav-logo">
      <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo Setia Adhiguna" class="logo-img">
      <div class="subtitle">Sistem POS ATK & Advertising</div>
    </div>

    @if($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
               placeholder="admin@tokoadv.id" required autofocus>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>

      <button type="submit" class="btn-login">MASUK →</button>
    </form>

  </div>
</body>
</html>