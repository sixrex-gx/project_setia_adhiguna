<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard — TokoAdv</title>
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
  <link rel="stylesheet" href="{{ asset('assets/static/css/style.css') }}">
</head>
<body>
<div id="app">

  <!-- ====== TOP NAV ====== -->
  <nav class="top-nav no-print">
  <div class="nav-logo">
    <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo" class="logo-img">
    <span>Setia Adhiguna</span>
  </div>
  <button class="nav-tab active">⚙ Admin Dashboard</button>
  <div class="nav-spacer"></div>
  <div class="nav-status" style="gap:12px;align-items:center">

    {{-- NOTIF STOK KRITIS --}}
    @if($lowStock > 0)
    <div class="notif-bell" onclick="toggleNotif()" style="position:relative;cursor:pointer">
      <span style="font-size:20px">🔔</span>
      <span class="notif-count">{{ $lowStock }}</span>
      <div class="notif-dropdown" id="notif-dropdown" style="display:none">
        <div style="font-size:12px;font-weight:700;color:var(--text2);margin-bottom:8px">
          ⚠️ Stok Kritis ({{ $lowStock }} produk)
        </div>
        @foreach($lowStockProducts as $p)
        <div class="notif-item">
          <span>{{ $p->emoji }} {{ $p->name }}</span>
          <span class="badge badge-danger">{{ $p->stock }} {{ $p->unit }}</span>
        </div>
        @endforeach
        <div style="margin-top:10px;padding-top:8px;border-top:1px solid var(--border)">
          <a href="#" 
          class="btn btn-sm btn-primary" 
          style="width:100%;text-decoration:none;text-align:center"
          onmousedown="switchPage(document.querySelector('[data-page=\'produk\']'))">
          Lihat Produk →
          </a>
        </div>
      </div>
    </div>
    @endif

    {{-- DARK/LIGHT MODE --}}
    <button onclick="toggleTheme()" id="theme-btn"
      style="background:none;border:none;cursor:pointer;font-size:20px;padding:4px"
      title="Toggle tema">🌙</button>

    <div class="flex center gap-6">
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

  <!-- ====== ADMIN VIEW ====== -->
  <div class="view active" id="view-admin">
    <div class="admin-layout">

      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="sidebar-section-label">Utama</div>
        <div class="sidebar-item active" data-page="dashboard" onclick="switchPage(this)">
          <span class="sidebar-icon">📊</span> Dashboard
        </div>
        <div class="sidebar-item" data-page="transaksi" onclick="switchPage(this)">
          <span class="sidebar-icon">📋</span> Transaksi
        </div>
        <div class="sidebar-item" data-page="produk" onclick="switchPage(this)">
          <span class="sidebar-icon">📦</span> Produk & Stok
          <span class="sidebar-notif" id="low-stock-notif">{{ $lowStock }}</span>
        </div>
        <div class="sidebar-section-label">Bisnis</div>
        <div class="sidebar-item" data-page="pelanggan" onclick="switchPage(this)">
          <span class="sidebar-icon">👥</span> Pelanggan
        </div>
        <div class="sidebar-item" data-page="laporan" onclick="switchPage(this)">
          <span class="sidebar-icon">📈</span> Laporan
        </div>
        <div class="sidebar-section-label">Sistem</div>
        <div class="sidebar-item" data-page="karyawan" onclick="switchPage(this)">
          <span class="sidebar-icon">🧑‍💼</span> Karyawan
        </div>
        <div class="sidebar-item" data-page="setting" onclick="switchPage(this)">
          <span class="sidebar-icon">⚙</span> Pengaturan
        </div>
      </aside>

      <!-- Admin Content -->
      <main class="admin-content">

        <!-- ---- DASHBOARD PAGE ---- -->
        <div class="admin-page active" id="page-dashboard">
          <div class="page-header">
            <div>
              <div class="page-title">Selamat datang, {{ Auth::user()->name }} 👋</div>
              <div class="page-sub" id="dashboard-date">Memuat tanggal...</div>
            </div>
            
          </div>

          <div class="stat-grid">
            <div class="stat-card accent">
              <div class="stat-label">Total Produk</div>
              <div class="stat-value">{{ $products->count() }}</div>
              <div class="stat-change up">↑ Aktif semua</div>
            </div>
            <div class="stat-card">
              <div class="stat-label">Total Transaksi</div>
              <div class="stat-value">{{ $transactions->count() }}</div>
              <div class="stat-change up">↑ Semua waktu</div>
            </div>
            <div class="stat-card">
              <div class="stat-label">Total Omzet</div>
              <div class="stat-value" style="font-size:18px">
                Rp {{ number_format($transactions->sum('total'), 0, ',', '.') }}
              </div>
              <div class="stat-change up">↑ Semua waktu</div>
            </div>
            <div class="stat-card">
              <div class="stat-label">Stok Kritis</div>
              <div class="stat-value" style="color:var(--danger)">{{ $lowStock }}</div>
              <div class="stat-change down">Segera restock!</div>
            </div>
          </div>

          <div class="grid-2">
            <div class="panel">
              <div class="panel-header">
                <span class="panel-title">Penjualan 7 Hari Terakhir</span>
                <span class="badge badge-success">Live</span>
              </div>
              <div class="panel-body">
                <div class="chart-wrap">
                  <canvas id="chart-sales"></canvas>
                </div>
              </div>
            </div>
            <div class="panel">
              <div class="panel-header">
                <span class="panel-title">Distribusi Kategori</span>
              </div>
              <div class="panel-body">
                @php
                  $categories = $products->groupBy('category');
                  $total = $products->count();
                @endphp
                @foreach($categories as $cat => $items)
                  @php $pct = $total > 0 ? round(($items->count() / $total) * 100) : 0; @endphp
                  <div class="progress-item">
                    <div class="progress-label">
                      <span>{{ $cat }}</span>
                      <span style="color:var(--acc)">{{ $pct }}%</span>
                    </div>
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:{{ $pct }}%;background:var(--acc)"></div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="panel" style="margin-top: 16px;">
          <div class="panel-header">
            <span class="panel-title">🏆 Produk Terlaris</span>
          </div>
          <div class="panel-body">
            <div class="chart-wrap" style="height: 200px;">
              <canvas id="chart-top-products"></canvas>
            </div>
          </div>
        </div>

          <div class="panel">
            <div class="panel-header">
              <span class="panel-title">Transaksi Terbaru</span>
              <button class="btn btn-sm" onclick="switchPage(document.querySelector('[data-page=transaksi]'))">Lihat semua →</button>
            </div>
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Kasir</th>
                    <th>Waktu</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($transactions->take(5) as $tx)
                  <tr>
                    <td><span class="mono" style="font-size:11px;color:var(--text2)">{{ $tx->transaction_code }}</span></td>
                    <td>{{ $tx->customer }}</td>
                    <td class="mono" style="font-size:11px;color:var(--acc);font-weight:600">Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-info">{{ $tx->method }}</span></td>
                    <td style="color:var(--text2)">{{ $tx->user->name ?? '-' }}</td>
                    <td style="color:var(--text3);font-size:11px">{{ $tx->created_at->format('d/m H:i') }}</td>
                    <td><span class="badge badge-{{ $tx->status === 'Lunas' ? 'success' : 'warn' }}">{{ $tx->status }}</span></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="7" style="text-align:center;padding:30px;color:var(--text3)">Belum ada transaksi</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- /dashboard -->

        
        <!-- ---- TRANSAKSI PAGE ---- -->
        <div class="admin-page" id="page-transaksi">
          <div class="page-header">
            <div>
              <div class="page-title">Riwayat Transaksi</div>
              <div class="page-sub" id="tx-count">{{ $transactions->count() }} total transaksi</div>
            </div>
            <div class="flex gap-8">
              <input class="input-field" id="tx-search" type="text" placeholder="Cari transaksi..."
                oninput="filterTx()" style="width:220px">
              <a href="{{ route('admin.export.csv') }}" class="btn btn-sm btn-primary">⬇ Export CSV</a>
            </div>
          </div>

          {{-- ✅ TAB FILTER --}}
          <div style="display:flex; gap:8px; margin-bottom:14px;">
            <button onclick="setTxFilter('semua')" id="tab-semua"
                    style="padding:7px 16px; border-radius:8px; border:1px solid var(--border);
                          background:#f59e0b; color:#1a1a2e; font-weight:700; font-size:13px; cursor:pointer;">
              📋 Semua <span id="count-semua">{{ $transactions->count() }}</span>
            </button>
            <button onclick="setTxFilter('atk')" id="tab-atk"
                    style="padding:7px 16px; border-radius:8px; border:1px solid var(--border);
                          background:var(--card); color:var(--text2); font-size:13px; cursor:pointer;">
              🖊️ ATK <span id="count-atk">{{ $transactions->where('order_type','atk')->count() }}</span>
            </button>
            <button onclick="setTxFilter('advertising')" id="tab-advertising"
                    style="padding:7px 16px; border-radius:8px; border:1px solid var(--border);
                          background:var(--card); color:var(--text2); font-size:13px; cursor:pointer;">
              🖨️ Advertising <span id="count-adv">{{ $transactions->where('order_type','advertising')->count() }}</span>
            </button>
          </div>

          <div class="panel">
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Waktu</th>
                    <th>Pelanggan</th>
                    <th>Subtotal</th>
                    <th>PPN</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Kasir</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="all-tx-body">
                  @forelse($transactions as $tx)
                  <tr data-type="{{ $tx->order_type ?? 'atk' }}">
                    <td><span class="mono" style="font-size:11px;color:var(--text2)">{{ $tx->transaction_code }}</span></td>
                    <td>
                      @if(($tx->order_type ?? 'atk') === 'advertising')
                        <span class="badge" style="background:#1d3a6e;color:#93c5fd;font-size:10px;">🖨️ Adv</span>
                      @else
                        <span class="badge badge-info" style="font-size:10px;">🖊️ ATK</span>
                      @endif
                    </td>
                    <td style="color:var(--text3);font-size:11px">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $tx->customer }}</td>
                    <td class="mono" style="font-size:11px">Rp {{ number_format($tx->subtotal, 0, ',', '.') }}</td>
                    <td class="mono" style="font-size:11px">Rp {{ number_format($tx->tax, 0, ',', '.') }}</td>
                    <td class="mono" style="font-size:11px;color:var(--acc);font-weight:600">Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-info">{{ $tx->method }}</span></td>
                    <td style="color:var(--text2)">{{ $tx->user->name ?? '-' }}</td>
                    <td><span class="badge badge-{{ $tx->status === 'Lunas' ? 'success' : 'warn' }}">{{ $tx->status }}</span></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="10" style="text-align:center;padding:30px;color:var(--text3)">Belum ada transaksi</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- /transaksi -->

        <!-- ---- PRODUK PAGE ---- -->
        <div class="admin-page" id="page-produk">
          <div class="page-header">
            <div>
              <div class="page-title">Manajemen Produk & Stok</div>
              <div class="page-sub">Total {{ $products->count() }} SKU aktif</div>
            </div>
            <button class="btn btn-primary btn-sm" onclick="openAddProduct()">+ Tambah Produk</button>
          </div>
          <div class="stat-grid">
            <div class="stat-card">
              <div class="stat-label">Total SKU</div>
              <div class="stat-value">{{ $products->count() }}</div>
            </div>
            <div class="stat-card">
              <div class="stat-label">Stok Normal</div>
              <div class="stat-value" style="color:var(--success)">{{ $products->where('stock', '>', 5)->count() }}</div>
            </div>
            <div class="stat-card">
              <div class="stat-label">Stok Kritis (≤5)</div>
              <div class="stat-value" style="color:var(--danger)">{{ $lowStock }}</div>
            </div>
            <div class="stat-card">
              <div class="stat-label">Est. Nilai Stok</div>
              <div class="stat-value" style="font-size:16px">
                Rp {{ number_format($products->sum(fn($p) => $p->price * $p->stock), 0, ',', '.') }}
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-header">
              <span class="panel-title">Daftar Produk</span>
              <input class="input-field" id="prod-admin-search" type="text" placeholder="Cari produk..."
                oninput="filterProdTable()" style="width:200px;padding:6px 12px;font-size:12px">
            </div>
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga Jual</th>
                    <th>Harga Modal</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Level</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="prod-admin-body">
                  @foreach($products as $p)
                  @php
                    $lvl = $p->stock <= 5 ? 'danger' : ($p->stock <= 20 ? 'warn' : 'success');
                    $lvlT = $p->stock <= 5 ? 'Kritis' : ($p->stock <= 20 ? 'Rendah' : 'Normal');
                    $pct = min(100, round($p->stock / 150 * 100));
                    $barC = $p->stock <= 5 ? 'var(--danger)' : ($p->stock <= 20 ? 'var(--warn)' : 'var(--success)');
                  @endphp
                  <tr>
                    <td><span style="margin-right:6px">{{ $p->emoji }}</span><strong>{{ $p->name }}</strong></td>
                    <td><span class="badge badge-info" style="font-size:10px">{{ $p->category }}</span></td>
                    <td class="mono" style="font-size:12px;color:var(--acc)">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                    <td class="mono" style="font-size:12px;color:var(--text2)">Rp {{ number_format($p->cost, 0, ',', '.') }}</td>
                    <td>
                      <strong>{{ $p->stock }}</strong>
                      <div class="inv-bar"><div class="inv-bar-fill" style="width:{{ $pct }}%;background:{{ $barC }}"></div></div>
                    </td>
                    <td style="color:var(--text2)">{{ $p->unit }}</td>
                    <td><span class="badge badge-{{ $lvl }}">{{ $lvlT }}</span></td>
                    <td>
                      <button class="btn btn-sm" onclick="openEditProduct({{ $p->id }})" style="margin-right:4px">✏ Edit</button>
                      <button class="btn btn-sm btn-danger" onclick="restockProduct({{ $p->id }})">+ Restock</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- /produk -->

        <!-- ---- PELANGGAN PAGE ---- -->
        <div class="admin-page" id="page-pelanggan">
          <div class="page-header">
            <div>
              <div class="page-title">Data Pelanggan</div>
              <div class="page-sub">Dari riwayat transaksi</div>
            </div>
          </div>
          <div class="panel">
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Total Trx</th>
                    <th>Total Belanja</th>
                    <th>Terakhir Beli</th>
                    <th>Segmen</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $customers = $transactions->groupBy('customer');
                  @endphp
                  @forelse($customers as $name => $txs)
                  @php
                    $totalBelanja = $txs->sum('total');
                    $segmen = $totalBelanja >= 5000000 ? 'VIP' : ($totalBelanja >= 1000000 ? 'Regular' : 'Baru');
                    $segmenClass = $segmen === 'VIP' ? 'success' : ($segmen === 'Regular' ? 'info' : 'gray');
                  @endphp
                  <tr>
                    <td><strong>{{ $name }}</strong></td>
                    <td>{{ $txs->count() }} trx</td>
                    <td class="mono" style="font-size:11px;color:var(--acc)">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</td>
                    <td style="color:var(--text2)">{{ $txs->first()->created_at->format('d M Y') }}</td>
                    <td><span class="badge badge-{{ $segmenClass }}">{{ $segmen }}</span></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" style="text-align:center;padding:30px;color:var(--text3)">Belum ada data pelanggan</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- /pelanggan -->

        <!-- ---- LAPORAN PAGE ---- -->
<div class="admin-page" id="page-laporan">
  <div class="page-header">
    <div>
      <div class="page-title">Laporan Bisnis</div>
      <div class="page-sub">Data real dari database</div>
    </div>
    <a href="{{ route('admin.export.csv') }}" class="btn btn-sm btn-primary" style="text-decoration:none">
      ⬇ Export CSV
    </a>
  </div>

  {{-- STAT CARDS --}}
  <div class="stat-grid">
    <div class="stat-card accent">
      <div class="stat-label">Omzet Hari Ini</div>
      <div class="stat-value" style="font-size:18px">
        Rp {{ number_format($todayStat->omzet ?? 0, 0, ',', '.') }}
      </div>
      @php
        $diffOmzet = ($todayStat->omzet ?? 0) - ($yesterdayStat->omzet ?? 0);
      @endphp
      <div class="stat-change {{ $diffOmzet >= 0 ? 'up' : 'down' }}">
        {{ $diffOmzet >= 0 ? '↑' : '↓' }} vs kemarin
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Transaksi Hari Ini</div>
      <div class="stat-value">{{ $todayStat->trx ?? 0 }}</div>
      @php $diffTrx = ($todayStat->trx ?? 0) - ($yesterdayStat->trx ?? 0); @endphp
      <div class="stat-change {{ $diffTrx >= 0 ? 'up' : 'down' }}">
        {{ $diffTrx >= 0 ? '↑' : '↓' }} {{ abs($diffTrx) }} dari kemarin
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Total Omzet</div>
      <div class="stat-value" style="font-size:18px">
        Rp {{ number_format($transactions->sum('total'), 0, ',', '.') }}
      </div>
      <div class="stat-change up">↑ Semua waktu</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Avg / Transaksi</div>
      <div class="stat-value" style="font-size:18px">
        Rp {{ $transactions->count() > 0 ? number_format($transactions->avg('total'), 0, ',', '.') : 0 }}
      </div>
      <div class="stat-change up">Rata-rata semua trx</div>
    </div>
  </div>

  {{-- TABEL HARIAN --}}
  <div class="panel" style="margin-bottom:16px">
    <div class="panel-header">
      <span class="panel-title">📅 Omzet 7 Hari Terakhir</span>
    </div>
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Jumlah Transaksi</th>
            <th>Subtotal</th>
            <th>PPN</th>
            <th>Total Omzet</th>
          </tr>
        </thead>
        <tbody>
          @forelse($dailyReport as $day)
          <tr>
            <td>{{ \Carbon\Carbon::parse($day->trx_date)->translatedFormat('l, d M Y') }}</td>
            <td>{{ $day->total_trx }} transaksi</td>
            <td class="mono" style="font-size:11px">Rp {{ number_format($day->total_subtotal, 0, ',', '.') }}</td>
            <td class="mono" style="font-size:11px">Rp {{ number_format($day->total_tax, 0, ',', '.') }}</td>
            <td class="mono" style="font-size:12px;color:var(--acc);font-weight:600">
              Rp {{ number_format($day->total_omzet, 0, ',', '.') }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" style="text-align:center;padding:30px;color:var(--text3)">
              Belum ada transaksi dalam 7 hari terakhir
            </td>
          </tr>
          @endforelse
        </tbody>
        @if($dailyReport->count() > 0)
        <tfoot>
          <tr style="border-top:2px solid var(--border)">
            <td><strong>TOTAL</strong></td>
            <td><strong>{{ $dailyReport->sum('total_trx') }} transaksi</strong></td>
            <td class="mono" style="font-size:11px;font-weight:600">
              Rp {{ number_format($dailyReport->sum('total_subtotal'), 0, ',', '.') }}
            </td>
            <td class="mono" style="font-size:11px;font-weight:600">
              Rp {{ number_format($dailyReport->sum('total_tax'), 0, ',', '.') }}
            </td>
            <td class="mono" style="font-size:12px;color:var(--acc);font-weight:700">
              Rp {{ number_format($dailyReport->sum('total_omzet'), 0, ',', '.') }}
            </td>
          </tr>
        </tfoot>
        @endif
      </table>
    </div>
  </div>

  {{-- TABEL BULANAN --}}
  <div class="panel">
    <div class="panel-header">
      <span class="panel-title">📆 Omzet Per Bulan</span>
    </div>
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>Bulan</th>
            <th>Jumlah Transaksi</th>
            <th>Total Omzet</th>
            <th>Rata-rata / Trx</th>
          </tr>
        </thead>
        <tbody>
          @forelse($monthlyReport as $month)
          <tr>
            <td><strong>{{ $month->label }}</strong></td>
            <td>{{ $month->total_trx }} transaksi</td>
            <td class="mono" style="font-size:12px;color:var(--acc);font-weight:600">
              Rp {{ number_format($month->total_omzet, 0, ',', '.') }}
            </td>
            <td class="mono" style="font-size:11px;color:var(--text2)">
              Rp {{ number_format($month->total_omzet / $month->total_trx, 0, ',', '.') }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" style="text-align:center;padding:30px;color:var(--text3)">
              Belum ada data bulanan
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div><!-- /laporan -->

        <!-- ---- SETTING PAGE ---- -->
        <div class="admin-page" id="page-setting">
          <div class="page-header">
            <div class="page-title">Pengaturan Sistem</div>
          </div>
          <div class="grid-2">

            <div class="panel">
              <div class="panel-header"><span class="panel-title">Informasi Toko</span></div>
              <div class="panel-body">
                <div class="form-group">
                  <label class="form-label">Nama Toko</label>
                  <input class="input-field" value="TokoAdv — ATK & Advertising">
                </div>
                <div class="form-group">
                  <label class="form-label">Alamat</label>
                  <input class="input-field" value="Senen Jaya Blok 1&2 Lt.2 No.A7-15 Senen, Jakarta Pusat">
                </div>
                <div class="form-group">
                  <label class="form-label">Nomor Telepon</label>
                  <input class="input-field" value="0813 8232 8476">
                </div>
                <button class="btn btn-primary" onclick="showToast('Tersimpan', 'Pengaturan berhasil disimpan', 'success')">💾 Simpan</button>
              </div>
            </div>
            <div class="panel">
              <div class="panel-header"><span class="panel-title">Pajak & Keuangan</span></div>
              <div class="panel-body">
                <div class="form-group">
                  <label class="form-label">PPN (%)</label>
                  <input class="input-field" type="number" value="11">
                </div>
                <div class="form-group">
                  <label class="form-label">Biaya Admin QRIS (%)</label>
                  <input class="input-field" type="number" value="0.7" step="0.1">
                </div>
                <button class="btn btn-primary" onclick="showToast('Tersimpan', 'Pengaturan berhasil disimpan', 'success')">💾 Simpan</button>
              </div>
            </div>
          </div>
        </div><!-- /setting -->
                
        <!-- ---- KARYAWAN PAGE ---- -->
        <div class="admin-page" id="page-karyawan">
          <div class="page-header">
            <div>
              <div class="page-title">Manajemen Karyawan</div>
              <div class="page-sub">{{ count($kasirs) }} kasir terdaftar</div>
            </div>
          </div>
          <div class="panel">
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Shift</th>
                    <th>Trx Hari Ini</th>
                    <th>Omzet Hari Ini</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($kasirs as $kasir)
          <tr>
            <td>
              <strong>{{ $kasir['name'] }}</strong><br>
              <span style="font-size:11px;color:var(--text3)">{{ $kasir['email'] }}</span>
            </td>
            <td style="color:var(--text2)">Kasir</td>
            <td style="color:var(--text2)">{{ $kasir['status'] === 'Aktif' ? 'Hari ini' : '-' }}</td>
            <td>
              <strong>{{ $kasir['trx_today'] }}</strong> trx<br>
              <span style="font-size:11px;color:var(--text3)">Total: {{ $kasir['trx_all'] }} trx</span>
            </td>
            <td class="mono" style="font-size:11px;color:var(--acc)">
              Rp {{ number_format($kasir['omzet_today'], 0, ',', '.') }}<br>
              <span style="color:var(--text3)">Total: Rp {{ number_format($kasir['omzet_all'], 0, ',', '.') }}</span>
            </td>
            <td>
              <span class="badge badge-{{ $kasir['status'] === 'Aktif' ? 'success' : 'warn' }}">
                {{ $kasir['status'] }}
              </span>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="text-align:center;padding:30px;color:var(--text3)">
              Belum ada kasir terdaftar
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div><!-- /karyawan -->

      </main>
    </div>
  </div>

</div><!-- /app -->

<!-- ====== MODAL: TAMBAH/EDIT PRODUK ====== -->
<div class="modal-overlay" id="modal-add-product">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="modal-prod-title">+ Tambah Produk Baru</span>
      <button class="modal-close" onclick="closeModal('modal-add-product')">✕</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="np-id">
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Nama Produk *</label>
          <input class="input-field" id="np-name" placeholder="Nama produk">
        </div>
        <div class="form-group">
          <label class="form-label">Emoji</label>
          <input class="input-field" id="np-emoji" placeholder="📦" maxlength="4">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Kategori *</label>
          <select class="input-field" id="np-cat">
            <option>ATK Tulis</option>
            <option>Kertas</option>
            <option>Perlengkapan</option>
            <option>Advertising</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Satuan</label>
          <input class="input-field" id="np-unit" placeholder="pcs, rim, lbr...">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Harga Jual (Rp) *</label>
          <input class="input-field" id="np-price" type="number" placeholder="0">
        </div>
        <div class="form-group">
          <label class="form-label">Harga Modal (Rp)</label>
          <input class="input-field" id="np-cost" type="number" placeholder="0">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Stok *</label>
        <input class="input-field" id="np-stock" type="number" placeholder="0">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeModal('modal-add-product')">Batal</button>
      <button class="btn btn-primary" onclick="saveProduct()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- ====== TOAST ====== -->
<div class="toast-container" id="toast-container"></div>

<script>
  // Data produk dari Laravel
  const PRODUCTS_DATA = @json($products);

  // Clock
  function updateClock() {
    const now = new Date().toLocaleString('en-US', { timeZone: 'Asia/Jakarta' });
    const d = new Date(now);
    const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
    document.getElementById('nav-time').textContent =
      d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit', second:'2-digit', timeZone:'Asia/Jakarta' });
    const dd = document.getElementById('dashboard-date');
    if (dd) dd.textContent = d.toLocaleDateString('id-ID', opts) + ' — Semua sistem berjalan normal';
  }
  setInterval(updateClock, 1000);
  updateClock();

  // Switch Page
  function switchPage(el) {
    const page = el.dataset.page;
    document.querySelectorAll('.admin-page').forEach(p => p.classList.remove('active'));
    document.getElementById('page-' + page).classList.add('active');
    document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
    el.classList.add('active');
    if (page === 'laporan') setTimeout(initMonthlyChart, 150);
    if (page === 'dashboard') 
      setTimeout(initSalesChart, 150);
      setTimeout(initTopProductsChart, 150);
  }

  function initTopProductsChart() {
    const ctx = document.getElementById('chart-top-products');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($topProducts->pluck('product_name') ?? []), 
            datasets: [{
                llabel: 'Total Terjual',
                data: @json($topProducts->pluck('total_sold') ?? []),
                backgroundColor: '#f59e0b',
                hoverBackgroundColor: '#d97706',
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true, grid: { display: false } },
                y: { grid: { display: false } }
            }
        }
    });
}
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(initTopProductsChart, 500);
  });

  // Toast
  function showToast(title, msg, type = '') {
    const tc = document.getElementById('toast-container');
    const t = document.createElement('div');
    t.className = 'toast ' + type;
    t.innerHTML = `<div class="toast-title">${title}</div><div style="color:var(--text2);font-size:12px">${msg}</div>`;
    tc.appendChild(t);
    setTimeout(() => t.remove(), 3500);
  }

  // Modal
  function openModal(id) { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }
  document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
  });

  // Filter transaksi by tab + search
  let activeTxFilter = 'semua';

  function setTxFilter(type) {
    activeTxFilter = type;
    ['semua','atk','advertising'].forEach(t => {
      const btn = document.getElementById('tab-' + t);
      if (btn) {
        btn.style.background = t === type ? '#f59e0b' : 'var(--card)';
        btn.style.color      = t === type ? '#1a1a2e' : 'var(--text2)';
        btn.style.fontWeight = t === type ? '700' : '400';
      }
    });
    filterTx();
  }

  function filterTx() {
    const q    = (document.getElementById('tx-search')?.value ?? '').toLowerCase();
    const rows = document.querySelectorAll('#all-tx-body tr');
    let visible = 0;

    rows.forEach(row => {
      const type      = row.dataset.type ?? 'atk';
      const matchType = activeTxFilter === 'semua' || type === activeTxFilter;
      const matchQ    = row.textContent.toLowerCase().includes(q);
      const show      = matchType && matchQ;
      row.style.display = show ? '' : 'none';
      if (show) visible++;
    });

    const countEl = document.getElementById('tx-count');
    if (countEl) countEl.textContent = visible + ' transaksi ditampilkan';
  }

  // Filter tabel produk
  function filterProdTable() {
    const q = document.getElementById('prod-admin-search').value.toLowerCase();
    document.querySelectorAll('#prod-admin-body tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  }

  // Add Product Modal
  function openAddProduct() {
    document.getElementById('modal-prod-title').textContent = '+ Tambah Produk Baru';
    document.getElementById('np-id').value = '';
    ['np-name','np-emoji','np-unit','np-price','np-cost','np-stock'].forEach(id => {
      document.getElementById(id).value = '';
    });
    document.getElementById('np-emoji').value = '📦';
    openModal('modal-add-product');
  }

  function openEditProduct(id) {
    const p = PRODUCTS_DATA.find(x => x.id === id);
    if (!p) return;
    document.getElementById('modal-prod-title').textContent = '✏ Edit Produk';
    document.getElementById('np-id').value    = p.id;
    document.getElementById('np-name').value  = p.name;
    document.getElementById('np-emoji').value = p.emoji;
    document.getElementById('np-cat').value   = p.category;
    document.getElementById('np-unit').value  = p.unit;
    document.getElementById('np-price').value = p.price;
    document.getElementById('np-cost').value  = p.cost;
    document.getElementById('np-stock').value = p.stock;
    openModal('modal-add-product');
  }

  // save product
  async function saveProduct() {
  const id    = document.getElementById('np-id').value;
  const payload = {
    name:     document.getElementById('np-name').value.trim(),
    emoji:    document.getElementById('np-emoji').value.trim() || '📦',
    category: document.getElementById('np-cat').value,
    unit:     document.getElementById('np-unit').value.trim() || 'pcs',
    price:    parseInt(document.getElementById('np-price').value) || 0,
    cost:     parseInt(document.getElementById('np-cost').value)  || 0,
    stock:    parseInt(document.getElementById('np-stock').value) || 0,
  };

  if (!payload.name)  { showToast('Error', 'Nama produk wajib diisi', 'danger'); return; }
  if (!payload.price) { showToast('Error', 'Harga jual wajib diisi', 'danger');  return; }

  const CSRF = document.querySelector('meta[name="csrf-token"]').content;

  try {
    const url    = id ? `/api/products/${id}` : '/api/products';
    const method = id ? 'PUT' : 'POST';

    const res  = await fetch(url, {
      method,
      headers: {
        'Content-Type': 'application/json',
        'Accept':       'application/json',
        'X-CSRF-TOKEN': CSRF,
      },
      body: JSON.stringify(payload),
    });

    const data = await res.json();
    if (!res.ok) { showToast('Gagal', data.message ?? 'Terjadi kesalahan', 'danger'); return; }

    showToast('Berhasil ✅', id ? 'Produk berhasil diperbarui' : 'Produk baru ditambahkan', 'success');
    closeModal('modal-add-product');
    setTimeout(() => location.reload(), 1200);

  } catch (err) {
    showToast('Error', 'Koneksi ke server gagal', 'danger');
  }
}
// restock Product
async function restockProduct(id) {
  const qty = parseInt(prompt('Tambah berapa stok?', '50'));
  if (!qty || qty <= 0) return;

  const CSRF = document.querySelector('meta[name="csrf-token"]').content;

  try {
    const res  = await fetch(`/api/products/${id}/restock`, {
      method:  'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept':       'application/json',
        'X-CSRF-TOKEN': CSRF,
      },
      body: JSON.stringify({ qty }),
    });

    const data = await res.json();
    if (!res.ok) { showToast('Gagal', data.message ?? 'Terjadi kesalahan', 'danger'); return; }

    showToast('Restock Berhasil ✅', `Stok sekarang: ${data.stock}`, 'success');
    setTimeout(() => location.reload(), 1200);

  } catch (err) {
    showToast('Error', 'Koneksi ke server gagal', 'danger');
  }
} 

  // Export CSV
  function exportCSV() {
    showToast('Export', 'Mengunduh data transaksi...', 'success');
  }

  // Charts
  let chartSales = null;
  let chartMonthly = null;

  function initSalesChart() {
    const ctx = document.getElementById('chart-sales');
    if (!ctx || chartSales) return;
    chartSales = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: @json($omzetMingguan),
                    backgroundColor: 'rgba(245, 158, 11, 0.7)',
                    borderColor: '#f59e0b',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: { ticks: { color:'#6b6b6b' }, grid: { color:'rgba(255,255,255,0.04)' } },
          y: { ticks: { color:'#6b6b6b', callback: v => v >= 1000000 ? (v/1000000).toFixed(1)+'Jt' : (v/1000)+'K' }, grid: { color:'rgba(255,255,255,0.06)' } }
        }
      }
    });
  }

  function initMonthlyChart() {
  const ctx = document.getElementById('chart-monthly');
  if (!ctx || chartMonthly) return;

  chartMonthly = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan','Feb','Mar','Apr','Mei'],
      datasets: [{
        label: 'Omzet',
        data: [52000000,63000000,74000000,87200000,92000000],
        borderColor: '#f59e0b',
        backgroundColor: 'rgba(245,158,11,0.08)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#f59e0b',
        pointRadius: 5,
        borderWidth: 2,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: { ticks: { color:'#6b6b6b' }, grid: { color:'rgba(255,255,255,0.04)' } },
        y: { ticks: { color:'#6b6b6b', callback: v => (v/1000000).toFixed(0)+'Jt' }, grid: { color:'rgba(255,255,255,0.06)' } }
      }
    }
  });
}

// ====== NOTIF BELL ======
function toggleNotif() {
  event.stopPropagation();
  const dd = document.getElementById('notif-dropdown');
  if (dd) {
    if (dd.style.display === 'none' || dd.style.display === '') {
      dd.style.display = 'block';
      dd.style.pointerEvents = 'all';
      dd.style.zIndex = '9999';
    } else {
      dd.style.display = 'none';
      dd.style.pointerEvents = 'none';
    }
  }
}

function goToProduk() {
  const dd = document.getElementById('notif-dropdown');
  if (dd) dd.style.display = 'none';
  setTimeout(function() {
    const produkBtn = document.querySelector('[data-page="produk"]');
    if (produkBtn) switchPage(produkBtn);
  }, 100);
}

document.addEventListener('click', function(e) {
  const bell = document.querySelector('.notif-bell');
  const dd   = document.getElementById('notif-dropdown');
  if (bell && dd && !bell.contains(e.target)) {
    dd.style.display = 'none';
  }
});

// ====== DARK/LIGHT MODE ======
function toggleTheme() {
  const body = document.body;
  const btn  = document.getElementById('theme-btn');
  body.classList.toggle('light-mode');
  const isLight = body.classList.contains('light-mode');
  btn.textContent = isLight ? '☀️' : '🌙';
  localStorage.setItem('theme', isLight ? 'light' : 'dark');
}

// Load saved theme
(function() {
  const saved = localStorage.getItem('theme');
  const btn   = document.getElementById('theme-btn');
  if (saved === 'light') {
    document.body.classList.add('light-mode');
    if (btn) btn.textContent = '☀️';
  }
})();

  // Init chart on load
  setTimeout(initSalesChart, 300);
</script>

</body>
</html>