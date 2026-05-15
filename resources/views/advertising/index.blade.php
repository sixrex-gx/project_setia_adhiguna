@extends('layouts.app')

@section('title', 'TokoAdv — Advertising')

@section('content')
<div id="app" style="display:flex;flex-direction:column;height:100vh;overflow:hidden;">

  <!-- ====== TOP NAV ====== -->
  <nav class="top-nav no-print" style="flex-shrink:0; display:flex; align-items:center; width:100%;">
    <div class="nav-logo">
      <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo Setia Adhiguna" class="logo-img" id="logo-dark">
      <img src="{{ asset('assets/img/logo2.png') }}" alt="Logo Setia Adhiguna" class="logo-img" id="logo-light" style="display:none;">
      <span>Setia Adhiguna</span>
    </div>
    <a href="{{ route('kasir.index') }}" class="nav-tab" style="text-decoration:none;">🖥 ATK</a>
    <button class="nav-tab active" style="font-weight:bold; border:none;">
      🖨️ Advertising
    </button>
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

  <!-- ====== CONTENT ====== -->
  <div style="flex:1; overflow-y:auto; padding:20px 24px;">

    <!-- Flash success -->
    @if(session('success'))
    <div style="background:#052e16; border:1px solid #16a34a; border-left:4px solid #22c55e;
                border-radius:8px; padding:12px 16px; margin-bottom:16px; color:#86efac; font-size:13px;">
      {{ session('success') }}
    </div>
    @endif

    <!-- Header -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
      <div>
        <h1 style="font-size:20px; font-weight:700; color:var(--text1); margin:0;">🖨️ Order Advertising</h1>
        <p style="font-size:13px; color:var(--text3); margin:4px 0 0;">Custom Print, Spanduk & Percetakan — Setia Adhiguna</p>
      </div>
      <a href="{{ route('advertising.create') }}"
         class="btn btn-primary" style="text-decoration:none;">
        + Order Baru
      </a>
    </div>

    <!-- Stats Pipeline (data real) -->
    @php
      $statusList = ['Pending'=>'⏳','Design'=>'🎨','Cetak'=>'🖨️','Selesai'=>'✅','Diambil'=>'📦'];
      $statusColors = [
        'Pending' => '#9CA3AF',
        'Design'  => '#1A6B47',
        'Cetak'   => '#1A6B47',
        'Selesai' => '#1A6B47',
        'Diambil' => '#1A6B47',
      ];
    @endphp
    <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:10px; margin-bottom:20px;">
      @foreach($statusList as $status => $icon)
      @php $count = $orders->where('production_status', $status)->count(); @endphp
      <div style="background:var(--card); border:1px solid var(--border); border-radius:10px;
                  padding:14px; display:flex; align-items:center; gap:10px;">
        <div style="font-size:22px;">{{ $icon }}</div>
        <div>
          <div style="font-size:20px; font-weight:700; color:{{ $statusColors[$status] }};">{{ $count }}</div>
          <div style="font-size:11px; color:var(--text3);">{{ $status }}</div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Tabel Order -->
    @if($orders->isEmpty())
    <div style="background:var(--card); border:1px solid var(--border); border-radius:12px;
                padding:60px 20px; text-align:center;">
      <div style="font-size:48px; margin-bottom:12px;">🖨️</div>
      <div style="font-size:16px; font-weight:600; color:var(--text1); margin-bottom:6px;">Belum ada order advertising</div>
      <div style="font-size:13px; color:var(--text3); margin-bottom:20px;">Klik tombol <strong>+ Order Baru</strong> untuk membuat order pertama</div>
      <a href="{{ route('advertising.create') }}"
         class="btn btn-primary" style="text-decoration:none;">
        + Buat Order Pertama
      </a>
    </div>

    @else
    <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; overflow:hidden;">
      <table style="width:100%; border-collapse:collapse; font-size:13px;">
        <thead>
          <tr style="background:var(--bg); border-bottom:1px solid var(--border);">
            <th style="padding:12px 14px; text-align:left; font-size:11px; text-transform:uppercase;
                       letter-spacing:0.5px; color:var(--text3); font-weight:700;">Kode Order</th>
            <th style="padding:12px 14px; text-align:left; font-size:11px; text-transform:uppercase;
                       letter-spacing:0.5px; color:var(--text3); font-weight:700;">Customer</th>
            <th style="padding:12px 14px; text-align:left; font-size:11px; text-transform:uppercase;
                       letter-spacing:0.5px; color:var(--text3); font-weight:700;">Item & Ukuran</th>
            <th style="padding:12px 14px; text-align:left; font-size:11px; text-transform:uppercase;
                       letter-spacing:0.5px; color:var(--text3); font-weight:700;">Status</th>
            <th style="padding:12px 14px; text-align:right; font-size:11px; text-transform:uppercase;
                       letter-spacing:0.5px; color:var(--text3); font-weight:700;">Total</th>
            <th style="padding:12px 14px; text-align:left; font-size:11px; text-transform:uppercase;
                       letter-spacing:0.5px; color:var(--text3); font-weight:700;">Tanggal</th>
            <th style="padding:12px 14px; text-align:center; font-size:11px; text-transform:uppercase;
                       letter-spacing:0.5px; color:var(--text3); font-weight:700;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          <tr style="border-bottom:1px solid var(--border);">

            <!-- Kode -->
            <td style="padding:12px 14px;">
              <span style="font-family:monospace; color:var(--acc); font-weight:700;">
                {{ $order->transaction_code }}
              </span>
            </td>

            <!-- Customer -->
            <td style="padding:12px 14px;">
              <div style="color:var(--text1); font-weight:500;">{{ $order->customer }}</div>
              @if($order->customer_phone)
              <div style="color:var(--text3); font-size:11px;">{{ $order->customer_phone }}</div>
              @endif
            </td>

            <!-- Item & Ukuran -->
            <td style="padding:12px 14px;">
              @foreach($order->advertisingDetails->take(2) as $detail)
              <div style="margin-bottom:3px;">
                <span style="color:var(--text2);">{{ $detail->item_name }}</span>
                <span class="badge-ukuran">
                  {{ $detail->panjang }}×{{ $detail->lebar }}m
                </span>
              </div>
              @endforeach
              @if($order->advertisingDetails->count() > 2)
              <div style="color:var(--text3); font-size:11px;">
                +{{ $order->advertisingDetails->count() - 2 }} item lainnya
              </div>
              @endif
            </td>

            <!-- Status -->
            <td style="padding:12px 14px;">
              <form method="POST" action="{{ route('advertising.status', $order->id) }}">
                @csrf @method('PATCH')
                <select name="production_status" onchange="this.form.submit()"
                        style="background:var(--bg); border:1px solid var(--border); border-radius:6px;
                               padding:5px 8px; font-size:12px; cursor:pointer; outline:none;
                               color:{{ $statusColors[$order->production_status] ?? 'var(--text2)' }};">
                  @foreach($statusList as $s => $icon)
                  <option value="{{ $s }}" {{ $order->production_status === $s ? 'selected' : '' }}>
                    {{ $icon }} {{ $s }}
                  </option>
                  @endforeach
                </select>
              </form>
            </td>

            <!-- Total -->
            <td style="padding:12px 14px; text-align:right; font-weight:700; color:var(--text1);">
              Rp {{ number_format($order->total, 0, ',', '.') }}
            </td>

            <!-- Tanggal -->
            <td style="padding:12px 14px; color:var(--text3); font-size:12px;">
              {{ $order->created_at->format('d M Y') }}<br>
              <span style="font-size:11px;">{{ $order->created_at->format('H:i') }} WIB</span>
            </td>

            <!-- Aksi -->
            <td style="padding:12px 14px; text-align:center;">
              <div style="display:flex; gap:6px; justify-content:center;">
                <a href="{{ route('advertising.show', $order->id) }}"
                   style="background:var(--bg); border:1px solid var(--border); color:var(--text2);
                          border-radius:6px; padding:5px 10px; font-size:11px; text-decoration:none;">
                  Detail
                </a>
                <a href="{{ route('advertising.invoice', $order->id) }}"
                   class="btn btn-sm btn-primary" style="text-decoration:none;">
                  🖨️ Nota
                </a>
              </div>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endif

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