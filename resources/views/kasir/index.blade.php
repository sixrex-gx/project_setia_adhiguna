@extends('layouts.app')

@section('title', 'TokoAdv — Kasir POS')

@section('content')
<div id="app" style="display:flex;flex-direction:column;height:100vh;overflow:hidden;">

  <!-- ====== TOP NAV ====== -->
  <nav class="top-nav no-print" style="flex-shrink:0;">
    <div class="nav-logo">
      <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo Setia Adhiguna" class="logo-img">
      <span>Setia Adhiguna</span>
    </div>
    <button class="nav-tab active">🖥 Kasir / POS</button>
    <a href="{{ route('advertising.index') }}" class="nav-tab" style="text-decoration:none;">🖨️ Advertising</a>
    <div class="nav-spacer"></div>
    <div class="nav-status" style="gap:12px">
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

  <!-- ====== STATS BAR ====== -->
  <div class="kasir-stats-bar no-print" style="flex-shrink:0;">
    <div class="kstat-card">
      <div class="kstat-icon">🧾</div>
      <div class="kstat-info">
        <div class="kstat-val">{{ $stats['total_trx'] }}</div>
        <div class="kstat-label">Transaksi Hari Ini</div>
      </div>
    </div>
    <div class="kstat-card">
      <div class="kstat-icon">💰</div>
      <div class="kstat-info">
        <div class="kstat-val">Rp {{ number_format($stats['total_omzet'], 0, ',', '.') }}</div>
        <div class="kstat-label">Omzet Hari Ini</div>
      </div>
    </div>
    <div class="kstat-card">
      <div class="kstat-icon">📦</div>
      <div class="kstat-info">
        <div class="kstat-val">{{ $stats['total_items'] }}</div>
        <div class="kstat-label">Item Terjual</div>
      </div>
    </div>
    <div class="kstat-card">
      <div class="kstat-icon">👤</div>
      <div class="kstat-info">
        <div class="kstat-val">{{ Auth::user()->name }}</div>
        <div class="kstat-label">Kasir Bertugas</div>
      </div>
    </div>
  </div>

  <!-- ====== KASIR LAYOUT ====== -->
  <div class="kasir-layout" style="flex:1;overflow:hidden;">

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

  </div><!-- /kasir-layout -->

</div><!-- /app -->

<!-- ====== MODAL: CHECKOUT ====== -->
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

<!-- ====== TOAST ====== -->
<div class="toast-container" id="toast-container"></div>

@endsection