@extends('layouts.app')

@section('title', 'TokoAdv — Detail Gaji ' . $user->name)

@section('content')
<div id="app" style="display:flex;flex-direction:column;height:100vh;overflow:hidden;">

  <nav class="top-nav no-print" style="flex-shrink:0; display:flex; align-items:center; width:100%;">
    <div class="nav-logo">
      <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo Setia Adhiguna" class="logo-img" id="logo-dark">
      <img src="{{ asset('assets/img/logo2.png') }}" alt="Logo Setia Adhiguna" class="logo-img" id="logo-light" style="display:none;">
      <span>Setia Adhiguna</span>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="nav-tab" style="text-decoration:none;">📊 Dashboard</a>
    <button class="nav-tab active" style="font-weight:bold; border:none;">👤 {{ $user->name }}</button>
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

  <div style="flex:1; overflow-y:auto; padding:24px 32px;">

    @if(session('success'))
    <div style="background:#052e16; border:1px solid #16a34a; border-left:4px solid #22c55e;
                border-radius:8px; padding:12px 16px; margin-bottom:20px; color:#86efac; font-size:13px;">
      {{ session('success') }}
    </div>
    @endif

    @php
      $initials = strtoupper(implode('', array_map(fn($s) => $s[0], explode(' ', $user->name))));
    @endphp

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
      <a href="{{ route('admin.dashboard') }}" style="color:var(--text3); font-size:13px; text-decoration:none; display:flex; align-items:center; gap:6px; transition:color 0.2s;"
         onmouseover="this.style.color='var(--acc)'" onmouseout="this.style.color=''">
        ← Kembali ke Dashboard
      </a>
    </div>

    <div style="background:var(--card); border:1px solid var(--border); border-radius:16px; padding:28px 32px; margin-bottom:24px; position:relative; overflow:hidden;">
      <div style="position:absolute; top:-60px; right:-60px; width:180px; height:180px; border-radius:50%; background:rgba(245,158,11,0.04); pointer-events:none;"></div>
      <div style="display:flex; align-items:center; gap:24px; position:relative; z-index:1;">
        <div style="width:72px; height:72px; border-radius:50%; background:rgba(245,158,11,0.12); display:flex; align-items:center; justify-content:center; flex-shrink:0; border:2px solid rgba(245,158,11,0.2);">
          <span style="font-size:26px; font-weight:700; color:#f59e0b; font-family:'Space Mono',monospace;">{{ $initials }}</span>
        </div>
        <div style="flex:1;">
          <h1 style="font-size:24px; font-weight:700; color:var(--text1); margin:0; letter-spacing:-0.3px;">{{ $user->name }}</h1>
          <div style="display:flex; align-items:center; gap:12px; margin-top:6px;">
            <span style="display:flex; align-items:center; gap:4px; font-size:13px; color:var(--acc); font-weight:500;">
              <span style="font-size:14px;">🧑‍💼</span> Kasir
            </span>
            <span style="width:3px; height:3px; border-radius:50%; background:var(--text3);"></span>
            <span style="font-size:13px; color:var(--text3);">{{ $user->email }}</span>
          </div>
        </div>
        <span class="badge badge-{{ $statusClass }}" style="font-size:12px; padding:6px 16px; border-radius:20px; font-weight:600; letter-spacing:0.3px;">
          {{ $statusLabel }}
        </span>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px;">
      <div style="background:var(--card); border:1px solid var(--border); border-radius:14px; padding:22px 24px; position:relative; overflow:hidden; transition:border-color 0.2s;"
           onmouseover="this.style.borderColor='rgba(245,158,11,0.3)'" onmouseout="this.style.borderColor=''">
        <div style="font-size:11px; color:var(--text3); text-transform:uppercase; letter-spacing:0.8px; font-weight:600; margin-bottom:12px;">Total Transaksi</div>
        <div style="display:flex; align-items:baseline; gap:8px;">
          <span style="font-size:38px; font-weight:800; color:var(--acc); font-family:'Space Mono',monospace; line-height:1;">{{ $totalTrxWeek }}</span>
          <span style="font-size:12px; color:var(--text3); font-weight:500;">transaksi</span>
        </div>
        <div style="font-size:12px; color:var(--text3); margin-top:8px; border-top:1px solid var(--border); padding-top:8px;">
          <span style="color:var(--text2);">Minggu ini</span>
        </div>
      </div>
      <div style="background:var(--card); border:1px solid var(--border); border-radius:14px; padding:22px 24px; position:relative; overflow:hidden; transition:border-color 0.2s;"
           onmouseover="this.style.borderColor='rgba(34,197,94,0.3)'" onmouseout="this.style.borderColor=''">
        <div style="font-size:11px; color:var(--text3); text-transform:uppercase; letter-spacing:0.8px; font-weight:600; margin-bottom:12px;">Total Omset</div>
        <div style="font-size:26px; font-weight:800; color:var(--success); font-family:'Space Mono',monospace; line-height:1.2; word-break:break-word;">
          Rp {{ number_format($totalOmzetWeek, 0, ',', '.') }}
        </div>
        <div style="font-size:12px; color:var(--text3); margin-top:8px; border-top:1px solid var(--border); padding-top:8px;">
          <span style="color:var(--text2);">Minggu ini</span>
        </div>
      </div>
      <div style="background:var(--card); border:1px solid var(--border); border-radius:14px; padding:22px 24px; position:relative; overflow:hidden; transition:border-color 0.2s;"
           onmouseover="this.style.borderColor='rgba(59,130,246,0.3)'" onmouseout="this.style.borderColor=''">
        <div style="font-size:11px; color:var(--text3); text-transform:uppercase; letter-spacing:0.8px; font-weight:600; margin-bottom:12px;">Hari Masuk</div>
        <div style="display:flex; align-items:baseline; gap:8px;">
          <span style="font-size:38px; font-weight:800; color:var(--info); font-family:'Space Mono',monospace; line-height:1;">{{ $hariMasuk }}</span>
          <span style="font-size:14px; color:var(--text3); font-weight:500;">/ 7 hari</span>
        </div>
        <div style="font-size:12px; color:var(--text3); margin-top:8px; border-top:1px solid var(--border); padding-top:8px;">
          <span style="color:var(--text2);">Minggu ini</span>
        </div>
      </div>
    </div>

    <div style="background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden; margin-bottom:24px;">
      <div style="padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--bg);">
        <div style="display:flex; align-items:center; gap:10px;">
          <span style="font-size:16px;">📋</span>
          <span style="font-size:14px; font-weight:600; color:var(--text1);">Absensi & Transaksi Harian</span>
        </div>
        <span style="font-size:12px; color:var(--text3); font-family:'Space Mono',monospace; padding:4px 10px; background:var(--card); border-radius:6px; border:1px solid var(--border);">
          {{ \Carbon\Carbon::now('Asia/Jakarta')->startOfWeek()->format('d M') }} — {{ \Carbon\Carbon::now('Asia/Jakarta')->endOfWeek()->format('d M Y') }}
        </span>
      </div>
      <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; font-size:13px;">
          <thead>
            <tr style="border-bottom:1px solid var(--border);">
              <th style="padding:14px 20px; text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:0.6px; color:var(--text3); font-weight:600;">Hari</th>
              <th style="padding:14px 20px; text-align:center; font-size:11px; text-transform:uppercase; letter-spacing:0.6px; color:var(--text3); font-weight:600;">Tanggal</th>
              <th style="padding:14px 20px; text-align:center; font-size:11px; text-transform:uppercase; letter-spacing:0.6px; color:var(--text3); font-weight:600;">Status</th>
              <th style="padding:14px 20px; text-align:right; font-size:11px; text-transform:uppercase; letter-spacing:0.6px; color:var(--text3); font-weight:600;">Transaksi</th>
              <th style="padding:14px 20px; text-align:right; font-size:11px; text-transform:uppercase; letter-spacing:0.6px; color:var(--text3); font-weight:600;">Omset</th>
            </tr>
          </thead>
          <tbody>
            @foreach($absensi as $day)
            <tr style="border-bottom:1px solid var(--border); transition:background 0.15s;"
                onmouseover="this.style.background='var(--bg)'" onmouseout="this.style.background=''">
              <td style="padding:14px 20px; font-weight:600; color:var(--text1); font-size:14px;">{{ $day['hari'] }}</td>
              <td style="padding:14px 20px; text-align:center; color:var(--text3); font-size:12px;">{{ $day['tanggal'] }}</td>
              <td style="padding:14px 20px; text-align:center;">
                @if($day['status'] === 'Masuk')
                  <span style="display:inline-flex; align-items:center; gap:4px; background:rgba(34,197,94,0.1); color:#22c55e; padding:3px 12px; border-radius:12px; font-size:12px; font-weight:600;">
                    <span style="font-size:10px;">●</span> Masuk
                  </span>
                @else
                  <span style="display:inline-flex; align-items:center; gap:4px; background:var(--bg); color:var(--text3); padding:3px 12px; border-radius:12px; font-size:12px; font-weight:500;">
                    <span style="font-size:10px;">○</span> Libur
                  </span>
                @endif
              </td>
              <td style="padding:14px 20px; text-align:right; font-weight:600;">
                @if($day['trx'] > 0)
                  <span style="color:var(--acc); font-family:'Space Mono',monospace;">{{ $day['trx'] }}</span>
                @else
                  <span style="color:var(--text3);">—</span>
                @endif
              </td>
              <td style="padding:14px 20px; text-align:right; font-family:'Space Mono',monospace; font-weight:500;">
                @if($day['omzet'] > 0)
                  <span style="color:var(--success); font-size:13px;">Rp {{ number_format($day['omzet'], 0, ',', '.') }}</span>
                @else
                  <span style="color:var(--text3);">—</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:1.2fr 0.8fr; gap:20px; margin-bottom:24px;">
      <div style="background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden;">
        <div style="padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--bg);">
          <div style="display:flex; align-items:center; gap:10px;">
            <span style="font-size:16px;">💰</span>
            <span style="font-size:14px; font-weight:600; color:var(--text1);">Rincian Penggajian</span>
          </div>
          <div style="display:flex; align-items:center; gap:8px;">
            @if($detailGaji)
            <span style="background:rgba(245,158,11,0.1); color:#f59e0b; padding:3px 12px; border-radius:6px; font-size:12px; font-weight:600; font-family:'Space Mono',monospace; border:1px solid rgba(245,158,11,0.2);">
              {{ $selectedPeriode }}
            </span>
            @endif
          </div>
        </div>

        @if($detailGaji)
        <div style="padding:24px 28px;">
          <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 0; border-bottom:1px solid var(--border);">
            <span style="color:var(--text2); font-size:14px;">Gaji Pokok</span>
            <span style="color:var(--text1); font-weight:600; font-size:15px; font-family:'Space Mono',monospace;">Rp {{ number_format($detailGaji->gaji_pokok, 0, ',', '.') }}</span>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 0; border-bottom:1px solid var(--border);">
            <span style="color:var(--text2); font-size:14px;">Tunjangan</span>
            <span style="color:var(--text1); font-weight:600; font-size:15px; font-family:'Space Mono',monospace;">Rp {{ number_format($detailGaji->tunjangan, 0, ',', '.') }}</span>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:flex-start; padding:14px 0; border-bottom:1px solid var(--border);">
            <span style="color:var(--text2); font-size:14px;">Lembur</span>
            <div style="text-align:right;">
              @if($detailGaji->lembur_jam > 0)
                <span style="color:var(--text1); font-weight:600; font-size:14px; font-family:'Space Mono',monospace;">
                  {{ number_format($detailGaji->lembur_jam, 1) }}h × Rp {{ number_format($detailGaji->lembur_rate, 0, ',', '.') }}
                </span>
                <div style="font-size:13px; color:var(--text2); margin-top:2px; font-family:'Space Mono',monospace;">
                  = Rp {{ number_format($detailGaji->lembur_jam * $detailGaji->lembur_rate, 0, ',', '.') }}
                </div>
              @else
                <span style="color:var(--text3);">—</span>
              @endif
            </div>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 0; border-bottom:2px solid rgba(239,68,68,0.2);">
            <span style="color:var(--danger); font-size:14px; font-weight:500;">Potongan</span>
            <span style="color:var(--danger); font-weight:600; font-size:15px; font-family:'Space Mono',monospace;">(Rp {{ number_format($detailGaji->potongan, 0, ',', '.') }})</span>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; padding:18px 0 6px;">
            <span style="color:var(--text1); font-size:16px; font-weight:700;">Gaji Bersih</span>
            <span style="color:var(--success); font-size:26px; font-weight:800; font-family:'Space Mono',monospace; letter-spacing:-0.5px;">
              Rp {{ number_format($detailGaji->gaji_bersih, 0, ',', '.') }}
            </span>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; padding-top:12px; border-top:1px solid var(--border); margin-top:4px;">
            <div style="display:flex; align-items:center; gap:8px;">
              @if($periodes->isNotEmpty())
              <form method="GET" action="{{ route('penggajian.index', $user->id) }}" style="display:flex; align-items:center; gap:6px;">
                <span style="font-size:12px; color:var(--text3);">Periode:</span>
                <select name="periode" onchange="this.form.submit()"
                        style="background:var(--bg); border:1px solid var(--border); border-radius:6px; padding:5px 10px; font-size:12px; color:var(--text1); outline:none; cursor:pointer; font-family:'Space Mono',monospace;">
                  @foreach($periodes as $p)
                  <option value="{{ $p }}" {{ $p === $selectedPeriode ? 'selected' : '' }}>{{ $p }}</option>
                  @endforeach
                </select>
              </form>
              @endif
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
              @if($detailGaji->tanggal_bayar)
                <span style="font-size:12px; color:var(--success); display:flex; align-items:center; gap:4px;">
                  <span>✅</span> Dibayar {{ \Carbon\Carbon::parse($detailGaji->tanggal_bayar)->format('d M Y') }}
                </span>
              @else
                <form method="POST" action="{{ route('penggajian.bayar', [$user->id, $detailGaji->id]) }}" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-primary" style="cursor:pointer; border-radius:8px; font-size:12px; padding:5px 14px;"
                          onclick="return confirm('Tandai gaji periode {{ $selectedPeriode }} sudah dibayar?')">
                    ✅ Tandai Dibayar
                  </button>
                </form>
              @endif
            </div>
          </div>
        </div>
        @else
        <div style="padding:60px 20px; text-align:center;">
          <div style="font-size:40px; margin-bottom:12px;">💰</div>
          <div style="font-size:15px; font-weight:600; color:var(--text1); margin-bottom:6px;">Belum ada data penggajian</div>
          <div style="font-size:13px; color:var(--text3); margin-bottom:20px;">Belum ada periode gaji untuk {{ $user->name }}</div>
          <a href="{{ route('penggajian.create', $user->id) }}" class="btn btn-primary" style="text-decoration:none;">+ Gaji Baru</a>
        </div>
        @endif
      </div>

      <div style="background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden; display:flex; flex-direction:column;">
        <div style="padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--bg);">
          <div style="display:flex; align-items:center; gap:10px;">
            <span style="font-size:16px;">⚡</span>
            <span style="font-size:14px; font-weight:600; color:var(--text1);">Aksi Cepat</span>
          </div>
        </div>
        <div style="flex:1; padding:24px; display:flex; flex-direction:column; gap:14px; justify-content:center;">
          <a href="{{ route('penggajian.create', $user->id) }}"
             style="display:flex; align-items:center; gap:14px; background:rgba(245,158,11,0.08); border:1px solid rgba(245,158,11,0.2); border-radius:12px; padding:18px 20px; text-decoration:none; transition:all 0.2s;"
             onmouseover="this.style.background='rgba(245,158,11,0.15)'" onmouseout="this.style.background=''">
            <div style="width:44px; height:44px; border-radius:10px; background:rgba(245,158,11,0.15); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
              <span style="font-size:20px;">➕</span>
            </div>
            <div style="flex:1;">
              <div style="font-size:14px; font-weight:600; color:var(--text1);">Tambah Gaji Baru</div>
              <div style="font-size:12px; color:var(--text3); margin-top:2px;">Buat data gaji periode baru untuk {{ $user->name }}</div>
            </div>
            <span style="color:var(--acc); font-size:18px;">→</span>
          </a>

          @if($detailGaji && !$detailGaji->tanggal_bayar)
          <form method="POST" action="{{ route('penggajian.bayar', [$user->id, $detailGaji->id]) }}" style="display:block;">
            @csrf @method('PATCH')
            <button type="submit"
                    style="display:flex; align-items:center; gap:14px; width:100%; background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.2); border-radius:12px; padding:18px 20px; cursor:pointer; transition:all 0.2s; text-align:left; font-family:inherit;"
                    onmouseover="this.style.background='rgba(34,197,94,0.15)'" onmouseout="this.style.background=''"
                    onclick="return confirm('Tandai gaji periode {{ $selectedPeriode }} sudah dibayar?')">
              <div style="width:44px; height:44px; border-radius:10px; background:rgba(34,197,94,0.15); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <span style="font-size:20px;">✅</span>
              </div>
              <div style="flex:1; text-align:left;">
                <div style="font-size:14px; font-weight:600; color:var(--text1);">Tandai Sudah Dibayar</div>
                <div style="font-size:12px; color:var(--text3); margin-top:2px;">Periode {{ $selectedPeriode }} — set tanggal bayar ke hari ini</div>
              </div>
              <span style="color:var(--success); font-size:18px;">→</span>
            </button>
          </form>
          @endif

          <a href="{{ route('admin.dashboard') }}"
             style="display:flex; align-items:center; gap:14px; background:var(--bg); border:1px solid var(--border); border-radius:12px; padding:18px 20px; text-decoration:none; transition:all 0.2s;"
             onmouseover="this.style.background='var(--card)'" onmouseout="this.style.background=''">
            <div style="width:44px; height:44px; border-radius:10px; background:var(--card); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
              <span style="font-size:18px;">📊</span>
            </div>
            <div style="flex:1;">
              <div style="font-size:14px; font-weight:600; color:var(--text1);">Kembali ke Dashboard</div>
              <div style="font-size:12px; color:var(--text3); margin-top:2px;">Lihat performa semua kasir</div>
            </div>
            <span style="color:var(--text3); font-size:18px;">→</span>
          </a>
        </div>
      </div>
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
