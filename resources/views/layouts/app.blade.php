<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'TokoAdv — Sistem POS ATK & Advertising')</title>
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet" href="{{ asset('assets/static/css/style.css') }}">
  @stack('styles')
</head>
<body>
<script>
  if (localStorage.getItem('theme') === 'light') {
    document.body.classList.add('light-mode');
  }
</script>
  @yield('content')
  <script src="{{ asset('assets/static/js/script.js') }}"></script>
  @stack('scripts')
</body>
</html>