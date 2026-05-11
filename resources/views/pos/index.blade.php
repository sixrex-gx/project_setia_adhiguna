@extends('layouts.app')

@section('title', 'TokoAdv — Sistem POS ATK & Advertising')

@section('content')

  <div id="app">

    <!-- ====== TOP NAV ====== -->
    <nav class="top-nav no-print">
      <div class="nav-logo"><span>▣</span> Setia Adhiguan</div>
      <button class="nav-tab active" id="tab-kasir" onclick="switchView('kasir')">🖥 Kasir / POS</button>
      <button class="nav-tab" id="tab-admin" onclick="switchView('admin')">⚙ Admin Dashboard</button>
      <div class="nav-spacer"></div>
      <div class="nav-status">
        <div class="status-dot"></div>
        <span id="nav-time"></span>
      </div>
    </nav>

    <!-- ====== KASIR VIEW ====== -->
    <div class="view active" id="view-kasir">
      <div class="kasir-layout">

        <!-- Product Panel -->
        <div class="prod-panel">
          <div class="prod-panel-top">
            <div class="search-bar">
              <input class="input-field" id="prod-search" type="text"
                placeholder="🔍  Cari produk ATK atau advertising..." oninput="filterProducts()">
              <button class="btn btn-sm"
                onclick="document.getElementById('prod-search').value='';filterProducts()">✕</button>
            </div>
            <div class="cat-tabs" id="cat-tabs"></div>
          </div>
          <div class="prod-grid-wrap">
            <div class="prod-grid" id="prod-grid"></div>
          </div>
        </div>

        <!-- Cart Panel -->
        <div class="cart-panel">
          <div class="cart-cust">
            <div class="section-label">Pelanggan</div>
            <input class="input-field" id="cust-name" type="text" placeholder="Nama / perusahaan (opsional)">
          </div>

          <div class="cart-header">
            <div class="cart-title">
              Keranjang
              <div class="cart-count-badge" id="cart-badge">0</div>
            </div>
            <button class="clear-cart-btn" onclick="clearCart()">Kosongkan</button>
          </div>

          <div class="cart-items-wrap" id="cart-items">
            <div class="empty-cart">
              <div class="empty-cart-icon">🛒</div>
              <div class="empty-cart-title">Keranjang kosong</div>
              <div style="font-size:12px;color:var(--text3)">Klik produk di kiri untuk menambahkan</div>
            </div>
          </div>

          <div class="cart-summary" id="cart-summary" style="display:none">
            <div class="sum-row">
              <span>Subtotal</span>
              <span class="val mono" id="s-subtotal">Rp 0</span>
            </div>
            <div class="sum-row">
              <span>Diskon</span>
              <span class="val sum-discount">- Rp 0</span>
            </div>
            <div class="sum-row">
              <span>PPN (11%)</span>
              <span class="val mono" id="s-ppn">Rp 0</span>
            </div>
            <div class="sum-row total">
              <span>TOTAL</span>
              <span class="val" id="s-total">Rp 0</span>
            </div>
          </div>

          <div class="pay-section">
            <div class="section-label" style="margin-bottom:8px">Metode Pembayaran</div>
            <div class="pay-methods" id="pay-methods">
              <button class="pay-method-btn active" data-method="Tunai">💵 Tunai</button>
              <button class="pay-method-btn" data-method="QRIS">📱 QRIS</button>
              <button class="pay-method-btn" data-method="Transfer">🏦 Transfer</button>
              <button class="pay-method-btn" data-method="Kartu">💳 Kartu</button>
            </div>
            <button class="checkout-btn" id="checkout-btn" onclick="openCheckout()" disabled>
              BAYAR SEKARANG →
            </button>
          </div>
        </div>
      </div>
    </div><!-- /kasir -->

    <!-- ====== ADMIN VIEW ====== -->
    <div class="view" id="view-admin">
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
            <span class="sidebar-notif" id="low-stock-notif">6</span>
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
                <div class="page-title">Selamat datang, Admin 👋</div>
                <div class="page-sub" id="dashboard-date">Memuat tanggal...</div>
              </div>
              <button class="btn btn-primary btn-sm" onclick="switchView('kasir')">+ Transaksi Baru</button>
            </div>

            <div class="stat-grid">
              <div class="stat-card accent">
                <div class="stat-label">Pendapatan Hari Ini</div>
                <div class="stat-value">Rp 4,8Jt</div>
                <div class="stat-change up">↑ 12% vs kemarin</div>
              </div>
              <div class="stat-card">
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">37</div>
                <div class="stat-change up">↑ 5 dari kemarin</div>
              </div>
              <div class="stat-card">
                <div class="stat-label">Produk Terjual</div>
                <div class="stat-value">142</div>
                <div class="stat-change up">↑ 23 item</div>
              </div>
              <div class="stat-card">
                <div class="stat-label">Stok Kritis</div>
                <div class="stat-value" style="color:var(--danger)">6</div>
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
                    <canvas id="chart-sales" role="img" aria-label="Bar chart penjualan 7 hari terakhir">Data penjualan mingguan</canvas>
                  </div>
                </div>
              </div>
              <div class="panel">
                <div class="panel-header">
                  <span class="panel-title">Distribusi Kategori</span>
                </div>
                <div class="panel-body">
                  <div class="progress-item">
                    <div class="progress-label">
                      <span>ATK Tulis</span>
                      <span style="color:var(--acc)">38%</span>
                    </div>
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:38%;background:var(--acc)"></div>
                    </div>
                  </div>
                  <div class="progress-item">
                    <div class="progress-label">
                      <span>Advertising</span>
                      <span style="color:var(--info)">29%</span>
                    </div>
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:29%;background:var(--info)"></div>
                    </div>
                  </div>
                  <div class="progress-item">
                    <div class="progress-label">
                      <span>Kertas & Print</span>
                      <span style="color:var(--success)">18%</span>
                    </div>
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:18%;background:var(--success)"></div>
                    </div>
                  </div>
                  <div class="progress-item" style="margin-bottom:0">
                    <div class="progress-label">
                      <span>Perlengkapan Kantor</span>
                      <span style="color:var(--text3)">15%</span>
                    </div>
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:15%;background:var(--text3)"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="panel">
              <div class="panel-header">
                <span class="panel-title">Transaksi Terbaru</span>
                <button class="btn btn-sm" onclick="document.querySelector('[data-page=transaksi]').click()">Lihat semua →</button>
              </div>
              <div class="table-wrap">
                <table class="data-table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Pelanggan</th>
                      <th>Produk</th>
                      <th>Total</th>
                      <th>Metode</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="recent-tx-body"></tbody>
                </table>
              </div>
            </div>
          </div><!-- /dashboard -->

          <!-- ---- TRANSAKSI PAGE ---- -->
          <div class="admin-page" id="page-transaksi">
            <div class="page-header">
              <div>
                <div class="page-title">Riwayat Transaksi</div>
                <div class="page-sub">Semua catatan penjualan</div>
              </div>
              <div class="flex gap-8">
                <input class="input-field" id="tx-search" type="text" placeholder="Cari transaksi..."
                  oninput="filterTx()" style="width:220px">
                <button class="btn btn-sm btn-primary" onclick="exportCSV()">⬇ Export CSV</button>
              </div>
            </div>
            <div class="panel">
              <div class="table-wrap">
                <table class="data-table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Waktu</th>
                      <th>Pelanggan</th>
                      <th>Item</th>
                      <th>Total</th>
                      <th>Metode</th>
                      <th>Kasir</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="all-tx-body"></tbody>
                </table>
              </div>
            </div>
          </div><!-- /transaksi -->

          <!-- ---- PRODUK PAGE ---- -->
          <div class="admin-page" id="page-produk">
            <div class="page-header">
              <div>
                <div class="page-title">Manajemen Produk & Stok</div>
                <div class="page-sub">Total <span id="total-sku">0</span> SKU aktif</div>
              </div>
              <button class="btn btn-primary btn-sm" onclick="openAddProduct()">+ Tambah Produk</button>
            </div>
            <div class="stat-grid">
              <div class="stat-card">
                <div class="stat-label">Total SKU</div>
                <div class="stat-value" id="p-total-sku">0</div>
              </div>
              <div class="stat-card">
                <div class="stat-label">Stok Normal</div>
                <div class="stat-value" style="color:var(--success)" id="p-normal">0</div>
              </div>
              <div class="stat-card">
                <div class="stat-label">Stok Kritis (≤5)</div>
                <div class="stat-value" style="color:var(--danger)" id="p-critical">0</div>
              </div>
              <div class="stat-card">
                <div class="stat-label">Est. Nilai Stok</div>
                <div class="stat-value" id="p-value">0</div>
              </div>
            </div>
            <div class="panel">
              <div class="panel-header">
                <span class="panel-title">Daftar Produk</span>
                <input class="input-field" id="prod-admin-search" type="text" placeholder="Cari produk..."
                  oninput="renderProdTable()" style="width:200px;padding:6px 12px;font-size:12px">
              </div>
              <div class="table-wrap">
                <table class="data-table">
                  <thead>
                    <tr>
                      <th>Produk</th>
                      <th>Kategori</th>
                      <th>Harga Jual</th>
                      <th>Stok</th>
                      <th>Satuan</th>
                      <th>Level</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="prod-admin-body"></tbody>
                </table>
              </div>
            </div>
          </div><!-- /produk -->

          <!-- ---- PELANGGAN PAGE ---- -->
          <div class="admin-page" id="page-pelanggan">
            <div class="page-header">
              <div>
                <div class="page-title">Data Pelanggan</div>
                <div class="page-sub">5 pelanggan terdaftar</div>
              </div>
              <button class="btn btn-primary btn-sm">+ Tambah Pelanggan</button>
            </div>
            <div class="panel">
              <div class="table-wrap">
                <table class="data-table">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Kontak</th>
                      <th>Total Trx</th>
                      <th>Total Belanja</th>
                      <th>Terakhir Beli</th>
                      <th>Segmen</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><strong>PT Maju Bersama</strong></td>
                      <td style="color:var(--text2)">021-5551234</td>
                      <td>24</td>
                      <td style="color:var(--acc);font-family:'Space Mono',monospace;font-size:11px">Rp 14.500.000</td>
                      <td style="color:var(--text2)">28 Apr 2026</td>
                      <td><span class="badge badge-success">VIP</span></td>
                    </tr>
                    <tr>
                      <td><strong>CV Karya Mandiri</strong></td>
                      <td style="color:var(--text2)">0812-9876543</td>
                      <td>18</td>
                      <td style="color:var(--acc);font-family:'Space Mono',monospace;font-size:11px">Rp 9.200.000</td>
                      <td style="color:var(--text2)">27 Apr 2026</td>
                      <td><span class="badge badge-success">VIP</span></td>
                    </tr>
                    <tr>
                      <td><strong>Andi Pratama</strong></td>
                      <td style="color:var(--text2)">0857-1234567</td>
                      <td>7</td>
                      <td style="color:var(--acc);font-family:'Space Mono',monospace;font-size:11px">Rp 2.300.000</td>
                      <td style="color:var(--text2)">25 Apr 2026</td>
                      <td><span class="badge badge-info">Regular</span></td>
                    </tr>
                    <tr>
                      <td><strong>Yayasan Pendidikan Nusa</strong></td>
                      <td style="color:var(--text2)">021-7778899</td>
                      <td>12</td>
                      <td style="color:var(--acc);font-family:'Space Mono',monospace;font-size:11px">Rp 5.800.000</td>
                      <td style="color:var(--text2)">24 Apr 2026</td>
                      <td><span class="badge badge-info">Regular</span></td>
                    </tr>
                    <tr>
                      <td><strong>Toko Berkah Jaya</strong></td>
                      <td style="color:var(--text2)">0821-5556677</td>
                      <td>3</td>
                      <td style="color:var(--acc);font-family:'Space Mono',monospace;font-size:11px">Rp 890.000</td>
                      <td style="color:var(--text2)">20 Apr 2026</td>
                      <td><span class="badge badge-gray">Baru</span></td>
                    </tr>
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
                <div class="page-sub">Ringkasan keuangan & performa penjualan</div>
              </div>
              <button class="btn btn-sm btn-primary">⬇ Download PDF</button>
            </div>
            <div class="stat-grid">
              <div class="stat-card accent">
                <div class="stat-label">Omzet Bulan Ini</div>
                <div class="stat-value">87,2Jt</div>
                <div class="stat-change up">↑ 18% vs bulan lalu</div>
              </div>
              <div class="stat-card">
                <div class="stat-label">Laba Bersih Est.</div>
                <div class="stat-value">24,1Jt</div>
                <div class="stat-change up">↑ 11%</div>
              </div>
              <div class="stat-card">
                <div class="stat-label">Avg / Transaksi</div>
                <div class="stat-value">130K</div>
                <div class="stat-change up">↑ 8%</div>
              </div>
              <div class="stat-card">
                <div class="stat-label">Tingkat Retur</div>
                <div class="stat-value" style="color:var(--success)">0,8%</div>
                <div class="stat-change up">↓ Sangat rendah</div>
              </div>
            </div>
            <div class="grid-2">
              <div class="panel">
                <div class="panel-header"><span class="panel-title">Omzet Bulanan 2026</span></div>
                <div class="panel-body">
                  <div class="chart-wrap">
                    <canvas id="chart-monthly" role="img" aria-label="Grafik omzet bulanan">Data omzet per bulan</canvas>
                  </div>
                </div>
              </div>
              <div class="panel">
                <div class="panel-header"><span class="panel-title">Top 5 Produk Terlaris</span></div>
                <div class="panel-body">
                  <div class="progress-item">
                    <div class="progress-label"><span>Spidol Whiteboard</span><span style="color:var(--acc)">142 pcs</span></div>
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:100%;background:var(--acc)"></div>
                    </div>
                  </div>
                  <div class="progress-item">
                    <div class="progress-label"><span>Banner Print A1</span><span style="color:var(--info)">98 lbr</span></div>
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:69%;background:var(--info)"></div>
                    </div>
                  </div>
                  <div class="progress-item">
                    <div class="progress-label"><span>Kertas HVS A4 Rim</span><span style="color:var(--success)">87 rim</span></div>
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:61%;background:var(--success)"></div>
                    </div>
                  </div>
                  <div class="progress-item">
                    <div class="progress-label"><span>Pulpen Pilot G2</span><span style="color:var(--text2)">75 pcs</span></div>
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:53%;background:var(--text3)"></div>
                    </div>
                  </div>
                  <div class="progress-item" style="margin-bottom:0">
                    <div class="progress-label"><span>Stiker Label Vinyl</span><span style="color:var(--danger)">64 lbr</span></div>
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:45%;background:var(--danger)"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- /laporan -->

          <!-- ---- KARYAWAN PAGE ---- -->
          <div class="admin-page" id="page-karyawan">
            <div class="page-header">
              <div>
                <div class="page-title">Manajemen Karyawan</div>
                <div class="page-sub">3 karyawan aktif</div>
              </div>
              <button class="btn btn-primary btn-sm">+ Tambah Karyawan</button>
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
                      <th>Omzet</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><strong>Budi Santoso</strong></td>
                      <td style="color:var(--text2)">Kasir Utama</td>
                      <td style="color:var(--text2)">Pagi 07:00–15:00</td>
                      <td>18 trx</td>
                      <td style="color:var(--acc);font-family:'Space Mono',monospace;font-size:11px">Rp 2.340.000</td>
                      <td><span class="badge badge-success">Aktif</span></td>
                    </tr>
                    <tr>
                      <td><strong>Siti Rahayu</strong></td>
                      <td style="color:var(--text2)">Kasir</td>
                      <td style="color:var(--text2)">Sore 15:00–22:00</td>
                      <td style="color:var(--text3)">—</td>
                      <td style="color:var(--text3)">—</td>
                      <td><span class="badge badge-warn">Belum Mulai</span></td>
                    </tr>
                    <tr>
                      <td><strong>Admin Pusat</strong></td>
                      <td style="color:var(--text2)">Administrator</td>
                      <td style="color:var(--text2)">Full Day</td>
                      <td style="color:var(--text3)">—</td>
                      <td style="color:var(--text3)">—</td>
                      <td><span class="badge badge-success">Aktif</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div><!-- /karyawan -->

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
                    <input class="input-field" id="s-toko" value="TokoAdv — ATK & Advertising">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <input class="input-field" id="s-alamat" value="Senen Jaya Blok 1&2 Lt.2 No.A7-15 Senen, Jakarta Pusat">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Nomor Telepon</label>
                    <input class="input-field" id="s-telp" value="0813 8232 8474">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Email</label>
                    <input class="input-field" id="s-email" value="admin@tokoadv.id">
                  </div>
                  <button class="btn btn-primary" onclick="saveSetting()">💾 Simpan Perubahan</button>
                </div>
              </div>
              <div>
                <div class="panel" style="margin-bottom:16px">
                  <div class="panel-header"><span class="panel-title">Pajak & Keuangan</span></div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label class="form-label">PPN (%)</label>
                      <input class="input-field" id="s-ppn" type="number" value="11" min="0" max="100">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Biaya Admin QRIS (%)</label>
                      <input class="input-field" id="s-qris" type="number" value="0.7" step="0.1">
                    </div>
                    <button class="btn btn-primary" onclick="saveSetting()">💾 Simpan</button>
                  </div>
                </div>
                <div class="panel">
                  <div class="panel-header"><span class="panel-title">Metode Pembayaran</span></div>
                  <div class="panel-body" style="display:flex;flex-direction:column;gap:10px">
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer"><input type="checkbox" checked> 💵 Tunai</label>
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer"><input type="checkbox" checked> 📱 QRIS</label>
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer"><input type="checkbox" checked> 🏦 Transfer Bank</label>
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer"><input type="checkbox" checked> 💳 Kartu Debit/Kredit</label>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- /setting -->

        </main>
      </div>
    </div><!-- /admin -->

  </div><!-- /app -->

  <!-- ====== MODAL: CHECKOUT / RECEIPT ====== -->
  <div class="modal-overlay" id="modal-checkout">
    <div class="modal">
      <div class="modal-header">
        <span class="modal-title">🧾 Konfirmasi Pembayaran</span>
        <button class="modal-close" onclick="closeModal('modal-checkout')">✕</button>
      </div>
      <div class="modal-body" id="modal-checkout-body"></div>
      <div class="modal-footer">
        <button class="btn" onclick="closeModal('modal-checkout')">Batal</button>
        <button class="btn btn-primary" onclick="processPayment()">✔ Konfirmasi & Bayar</button>
      </div>
    </div>
  </div>

  <!-- ====== MODAL: STRUK ====== -->
  <div class="modal-overlay" id="modal-struk">
    <div class="modal" style="max-width:380px">
      <div class="modal-header">
        <span class="modal-title">🖨 Struk Pembelian</span>
        <button class="modal-close" onclick="closeModal('modal-struk')">✕</button>
      </div>
      <div class="modal-body" id="modal-struk-body"></div>
      <div class="modal-footer">
        <button class="btn" onclick="closeModal('modal-struk')">Tutup</button>
        <button class="btn btn-primary" onclick="printStruk()">🖨 Print Struk</button>
      </div>
    </div>
  </div>

  <!-- ====== MODAL: TAMBAH PRODUK ====== -->
  <div class="modal-overlay" id="modal-add-product">
    <div class="modal">
      <div class="modal-header">
        <span class="modal-title" id="modal-prod-title">+ Tambah Produk Baru</span>
        <button class="modal-close" onclick="closeModal('modal-add-product')">✕</button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Produk *</label>
            <input class="input-field" id="np-name" placeholder="Nama produk">
          </div>
          <div class="form-group">
            <label class="form-label">Emoji / Ikon</label>
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
          <label class="form-label">Stok Awal *</label>
          <input class="input-field" id="np-stock" type="number" placeholder="0">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn" onclick="closeModal('modal-add-product')">Batal</button>
        <button class="btn btn-primary" onclick="saveProduct()">💾 Simpan Produk</button>
      </div>
    </div>
  </div>

  <!-- ====== TOAST CONTAINER ====== -->
  <div class="toast-container" id="toast-container"></div>

@endsection
