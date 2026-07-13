@extends('layouts.app')

@section('title', 'TokoAdv — Tambah Gaji ' . $user->name)

@section('content')
<div id="app" style="display:flex;flex-direction:column;height:100vh;overflow:hidden;">

  <nav class="top-nav no-print" style="flex-shrink:0; display:flex; align-items:center; width:100%;">
    <div class="nav-logo">
      <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo Setia Adhiguna" class="logo-img" id="logo-dark">
      <img src="{{ asset('assets/img/logo2.png') }}" alt="Logo Setia Adhiguna" class="logo-img" id="logo-light" style="display:none;">
      <span>Setia Adhiguna</span>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="nav-tab" style="text-decoration:none;">📊 Dashboard</a>
    <button class="nav-tab active" style="font-weight:bold; border:none;">💰 Gaji {{ $user->name }}</button>
    <div style="flex:1;"></div>
    <button onclick="toggleTheme()" id="theme-btn"
      style="background:none;border:none;cursor:pointer;font-size:20px;padding:4px;margin-right:12px"
      title="Toggle tema">🌙</button>
    <div class="nav-status" style="gap:12px; display:flex; align-items:center;">
      <div style="display:flex;align-items:center;gap:6px;">
        <div class="status-dot"></div>
        <span id="nav-time" style="font-size:12px;color:var(--text3)"></span>
      </div>
      <span style="font-size:12px;color:var(--text2)">👤 {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-sm btn-danger">Logout</button>
      </form>
    </div>
  </nav>

  <div style="flex:1; overflow-y:auto; padding:20px 24px;">

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
      <div>
        <h1 style="font-size:20px; font-weight:700; color:var(--text1); margin:0;">💰 Tambah Gaji</h1>
        <p style="font-size:13px; color:var(--text3); margin:4px 0 0;">
          <strong>{{ $user->name }}</strong> · {{ $user->email }} · Kasir
        </p>
      </div>
      <a href="{{ route('penggajian.index', $user->id) }}" style="color:var(--acc); font-size:13px; text-decoration:none;">
        ← Kembali
      </a>
    </div>

    @if($errors->any())
    <div style="background:#450a0a; border:1px solid #dc2626; border-left:4px solid #ef4444;
                border-radius:8px; padding:12px 16px; margin-bottom:16px; font-size:13px;">
      <ul style="margin:0; padding-left:16px; color:#fca5a5;">
        @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:24px; max-width:600px;">
      <form method="POST" action="{{ route('penggajian.store', $user->id) }}">
        @csrf

        <div style="margin-bottom:16px;">
          <label style="display:block; font-size:13px; color:var(--text2); margin-bottom:6px;">Periode (YYYY-MM)</label>
          <input type="text" name="periode" value="{{ old('periode', date('Y-m')) }}" required
                 class="input-field" style="width:100%;" placeholder="2026-07" pattern="\d{4}-\d{2}">
        </div>

        <div style="margin-bottom:16px;">
          <label style="display:block; font-size:13px; color:var(--text2); margin-bottom:6px;">Gaji Pokok (Rp)</label>
          <input type="number" name="gaji_pokok" value="{{ old('gaji_pokok') }}" required
                 class="input-field" style="width:100%;" step="0.01" min="0" placeholder="2500000">
        </div>

        <div style="margin-bottom:16px;">
          <label style="display:block; font-size:13px; color:var(--text2); margin-bottom:6px;">Tunjangan (Rp)</label>
          <input type="number" name="tunjangan" value="{{ old('tunjangan', 0) }}"
                 class="input-field" style="width:100%;" step="0.01" min="0" placeholder="500000">
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
          <div>
            <label style="display:block; font-size:13px; color:var(--text2); margin-bottom:6px;">Jam Lembur</label>
            <input type="number" name="lembur_jam" value="{{ old('lembur_jam', 0) }}"
                   class="input-field" style="width:100%;" step="0.5" min="0" placeholder="0">
          </div>
          <div>
            <label style="display:block; font-size:13px; color:var(--text2); margin-bottom:6px;">Rate Lembur/jam (Rp)</label>
            <input type="number" name="lembur_rate" value="{{ old('lembur_rate', 0) }}"
                   class="input-field" style="width:100%;" step="0.01" min="0" placeholder="0">
          </div>
        </div>

        <div style="margin-bottom:16px;">
          <label style="display:block; font-size:13px; color:var(--text2); margin-bottom:6px;">Potongan (Rp)</label>
          <input type="number" name="potongan" value="{{ old('potongan', 0) }}"
                 class="input-field" style="width:100%;" step="0.01" min="0" placeholder="0">
        </div>

        <div style="margin-bottom:24px;">
          <label style="display:block; font-size:13px; color:var(--text2); margin-bottom:6px;">Tanggal Bayar</label>
          <input type="date" name="tanggal_bayar" value="{{ old('tanggal_bayar') }}"
                 class="input-field" style="width:100%;">
        </div>

        <div style="display:flex; gap:12px;">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="{{ route('penggajian.index', $user->id) }}" class="btn" style="text-decoration:none;">Batal</a>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
function toggleTheme() {
  const body = document.body;
  const btn  = document.getElementById('theme-btn');
  body.classList.toggle('light-mode');
  const isLight = body.classList.contains('light-mode');
  btn.textContent = isLight ? '☀️' : '🌙';
  localStorage.setItem('theme', isLight ? 'light' : 'dark');
  document.getElementById('logo-dark').style.display  = isLight ? 'none'  : 'block';
  document.getElementById('logo-light').style.display = isLight ? 'block' : 'none';
}
(function() {
  const saved = localStorage.getItem('theme');
  const btn   = document.getElementById('theme-btn');
  if (saved === 'light') {
    document.body.classList.add('light-mode');
    if (btn) btn.textContent = '☀️';
    document.getElementById('logo-dark').style.display  = 'none';
    document.getElementById('logo-light').style.display = 'block';
  }
})();
function tick() {
  const n   = new Date().toLocaleString('en-US', { timeZone: 'Asia/Jakarta' });
  const d   = new Date(n);
  const pad = v => String(v).padStart(2,'0');
  const el  = document.getElementById('nav-time');
  if (el) el.textContent = pad(d.getHours())+':'+pad(d.getMinutes())+':'+pad(d.getSeconds());
}
tick(); setInterval(tick, 1000);
</script>
@endpush
