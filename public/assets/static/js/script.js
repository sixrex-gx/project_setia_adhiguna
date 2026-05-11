/* =====================================================
   CONFIG
===================================================== */
const API = {
  products:     '/api/products',
  transactions: '/api/transactions',
};

// CSRF token untuk POST request
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

/* =====================================================
   STATE
===================================================== */
let PRODUCTS    = [];   // diisi dari API
let cart        = {};
let payMethod   = 'Tunai';
let currentCat  = 'Semua';

const CATEGORIES = ['Semua', 'ATK Tulis', 'Kertas', 'Perlengkapan', 'Advertising'];

/* =====================================================
   HELPERS
===================================================== */
const fmt      = n  => 'Rp ' + Math.round(n).toLocaleString('id-ID');
const getTotal = () => Object.values(cart).reduce((s, i) => s + i.price * i.qty, 0);

/* =====================================================
   CLOCK
===================================================== */
function updateClock() {
  const now   = new Date().toLocaleString('en-US', { timeZone: 'Asia/Jakarta' });
  const d     = new Date(now);
  const el    = document.getElementById('nav-time');
  if (el) el.textContent = d.toLocaleTimeString('id-ID', {
    hour:'2-digit', minute:'2-digit', second:'2-digit', timeZone:'Asia/Jakarta'
  });
}
setInterval(updateClock, 1000);
updateClock();

/* =====================================================
   TOAST
===================================================== */
function showToast(title, msg, type = '') {
  const tc = document.getElementById('toast-container');
  const t  = document.createElement('div');
  t.className = 'toast ' + type;
  t.innerHTML = `<div class="toast-title">${title}</div>
                 <div style="color:var(--text2);font-size:12px">${msg}</div>`;
  tc.appendChild(t);
  setTimeout(() => t.remove(), 3500);
}

/* =====================================================
   MODAL
===================================================== */
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(m => {
  m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});

/* =====================================================
   FETCH PRODUCTS DARI API
===================================================== */
async function loadProducts() {
  try {
    const res  = await fetch(API.products, { headers: { 'Accept': 'application/json' } });
    PRODUCTS   = await res.json();
    initCatTabs();
    renderProducts();
  } catch (err) {
    showToast('Error', 'Gagal memuat produk dari server', 'danger');
  }
}

/* =====================================================
   CATEGORY TABS
===================================================== */
function initCatTabs() {
  const c = document.getElementById('cat-tabs');
  c.innerHTML = '';
  CATEGORIES.forEach(cat => {
    const b      = document.createElement('button');
    b.className  = 'cat-tab' + (cat === 'Semua' ? ' active' : '');
    b.textContent = cat;
    b.onclick    = () => {
      currentCat = cat;
      document.querySelectorAll('.cat-tab').forEach(x => x.classList.remove('active'));
      b.classList.add('active');
      renderProducts();
    };
    c.appendChild(b);
  });
}

/* =====================================================
   PRODUCT GRID
===================================================== */
function filterProducts() { renderProducts(); }

function renderProducts() {
  const q    = (document.getElementById('prod-search')?.value ?? '').trim().toLowerCase();
  const grid = document.getElementById('prod-grid');
  const list = PRODUCTS.filter(p =>
    (currentCat === 'Semua' || p.category === currentCat) &&
    p.name.toLowerCase().includes(q)
  );

  if (!list.length) {
    grid.innerHTML = `<div class="no-results">
      <div class="no-results-icon">🔍</div>
      <p>Produk tidak ditemukan</p>
      <p style="font-size:12px;margin-top:4px">Coba kata kunci lain</p>
    </div>`;
    return;
  }

  grid.innerHTML = list.map(p => {
    const lowStock  = p.stock <= 5;
    const outOfStock = p.stock === 0;
    return `
    <div class="prod-card${outOfStock ? ' out-of-stock' : ''}"
         onclick="addToCart(${p.id})"
         title="${p.name} — ${fmt(p.price)}">
      <span class="prod-emoji">${p.emoji ?? '📦'}</span>
      <div class="prod-name">${p.name}</div>
      <div class="prod-price">${fmt(p.price)}</div>
      <div class="prod-stock${lowStock ? ' low' : ''}">
        ${outOfStock ? '❌ Habis' : `Stok: ${p.stock} ${p.unit}${lowStock ? ' ⚠' : ''}`}
      </div>
      <div class="prod-add-badge">+</div>
    </div>`;
  }).join('');
}

/* =====================================================
   CART
===================================================== */
function addToCart(id) {
  const p = PRODUCTS.find(x => x.id === id);
  if (!p || p.stock === 0) return;
  if (cart[id]) {
    if (cart[id].qty >= p.stock) {
      showToast('Stok terbatas', `Maks ${p.stock} ${p.unit}`, 'danger');
      return;
    }
    cart[id].qty++;
  } else {
    cart[id] = { ...p, qty: 1 };
  }
  renderCart();
  showToast('Ditambahkan', p.name, 'success');
}

function changeQty(id, delta) {
  if (!cart[id]) return;
  cart[id].qty += delta;
  if (cart[id].qty <= 0) delete cart[id];
  renderCart();
}

function removeItem(id) {
  delete cart[id];
  renderCart();
}

function clearCart() {
  if (!Object.keys(cart).length) return;
  cart = {};
  renderCart();
  showToast('Keranjang dikosongkan', 'Semua item dihapus');
}

function renderCart() {
  const items  = Object.values(cart);
  const count  = items.reduce((a, b) => a + b.qty, 0);
  document.getElementById('cart-badge').textContent = count;

  const wrap  = document.getElementById('cart-items');
  const sumEl = document.getElementById('cart-summary');

  if (!items.length) {
    wrap.innerHTML = `<div class="empty-cart">
      <div class="empty-cart-icon">🛒</div>
      <div class="empty-cart-title">Keranjang kosong</div>
      <div style="font-size:12px;color:var(--text3)">Klik produk di kiri untuk menambahkan</div>
    </div>`;
    sumEl.style.display = 'none';
    document.getElementById('checkout-btn').disabled = true;
    return;
  }

  wrap.innerHTML = items.map(i => `
  <div class="cart-item">
    <div class="cart-item-emoji">${i.emoji ?? '📦'}</div>
    <div class="cart-item-info">
      <div class="cart-item-name">${i.name}</div>
      <div class="cart-item-subtotal">${fmt(i.price)} × ${i.qty} = ${fmt(i.price * i.qty)}</div>
    </div>
    <div class="qty-ctrl">
      <button class="qty-btn" onclick="changeQty(${i.id}, -1)">−</button>
      <span class="qty-num">${i.qty}</span>
      <button class="qty-btn" onclick="changeQty(${i.id}, 1)">+</button>
      <button class="del-item-btn" onclick="removeItem(${i.id})" title="Hapus">✕</button>
    </div>
  </div>`).join('');

  const sub   = getTotal();
  const ppn   = Math.round(sub * 0.11);
  const total = sub + ppn;

  document.getElementById('s-subtotal').textContent = fmt(sub);
  document.getElementById('s-ppn').textContent      = fmt(ppn);
  document.getElementById('s-total').textContent    = fmt(total);

  sumEl.style.display = 'block';
  document.getElementById('checkout-btn').disabled = false;
}

/* =====================================================
   PAYMENT METHOD
===================================================== */
document.getElementById('pay-methods').addEventListener('click', e => {
  const btn = e.target.closest('.pay-method-btn');
  if (!btn) return;
  payMethod = btn.dataset.method;
  document.querySelectorAll('.pay-method-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
});

/* =====================================================
   CHECKOUT MODAL
===================================================== */
function openCheckout() {
  const items = Object.values(cart);
  if (!items.length) return;
  const sub   = getTotal();
  const ppn   = Math.round(sub * 0.11);
  const total = sub + ppn;
  const cust  = document.getElementById('cust-name').value || 'Umum';

  document.getElementById('modal-checkout-body').innerHTML = `
  <p style="margin-bottom:14px;color:var(--text2);font-size:13px">Periksa detail sebelum memproses pembayaran.</p>
  <div style="background:var(--bg3);border-radius:var(--radius);padding:14px;margin-bottom:14px">
    <div class="flex between center gap-8" style="margin-bottom:6px">
      <span style="font-size:12px;color:var(--text2)">Pelanggan</span>
      <strong>${cust}</strong>
    </div>
    <div class="flex between center gap-8" style="margin-bottom:6px">
      <span style="font-size:12px;color:var(--text2)">Total Item</span>
      <strong>${items.reduce((a,b)=>a+b.qty,0)} item</strong>
    </div>
    <div class="flex between center gap-8">
      <span style="font-size:12px;color:var(--text2)">Metode Bayar</span>
      <strong>${payMethod}</strong>
    </div>
  </div>
  ${items.map(i => `
    <div class="flex between" style="font-size:13px;margin-bottom:6px">
      <span>${i.emoji ?? '📦'} ${i.name} ×${i.qty}</span>
      <span class="mono" style="color:var(--text2)">${fmt(i.price * i.qty)}</span>
    </div>`).join('')}
  <hr style="border:none;border-top:1px dashed var(--border);margin:10px 0">
  <div class="flex between" style="font-size:13px;margin-bottom:4px">
    <span style="color:var(--text2)">Subtotal</span><span>${fmt(sub)}</span>
  </div>
  <div class="flex between" style="font-size:13px;margin-bottom:4px">
    <span style="color:var(--text2)">PPN 11%</span><span>${fmt(ppn)}</span>
  </div>
  <div class="flex between" style="font-size:16px;font-weight:700;margin-top:8px">
    <span>TOTAL</span>
    <span style="color:var(--acc);font-family:'Space Mono',monospace">${fmt(total)}</span>
  </div>`;

  openModal('modal-checkout');
}

/* =====================================================
   PROSES PEMBAYARAN — KIRIM KE API
===================================================== */
async function processPayment() {
  const items = Object.values(cart);
  const cust  = document.getElementById('cust-name').value || 'Umum';

  // Siapkan payload
  const payload = {
    customer: cust,
    method:   payMethod,
    items:    items.map(i => ({
      product_id: i.id,
      qty:        i.qty,
    })),
  };

  // Disable tombol sementara
  const btn = document.querySelector('#modal-checkout .btn-primary');
  if (btn) { btn.disabled = true; btn.textContent = 'Memproses...'; }

  try {
    const res  = await fetch(API.transactions, {
      method:  'POST',
      headers: {
        'Content-Type':  'application/json',
        'Accept':        'application/json',
        'X-CSRF-TOKEN':  CSRF,
      },
      body: JSON.stringify(payload),
    });

    const data = await res.json();

    if (!res.ok) {
      showToast('Gagal', data.message ?? 'Terjadi kesalahan', 'danger');
      if (btn) { btn.disabled = false; btn.textContent = '✔ Konfirmasi & Bayar'; }
      return;
    }

    // Sukses!
    closeModal('modal-checkout');

    // Reload produk agar stok terupdate
    await loadProducts();

    // Tampilkan struk
    showStruk(data);

    // Reset cart
    cart = {};
    document.getElementById('cust-name').value = '';
    renderCart();

    showToast('Transaksi Berhasil! 🎉', `${data.code} — ${fmt(data.total)}`, 'success');

  } catch (err) {
    showToast('Error', 'Koneksi ke server gagal', 'danger');
    if (btn) { btn.disabled = false; btn.textContent = '✔ Konfirmasi & Bayar'; }
  }
}

/* =====================================================
   STRUK
===================================================== */
function showStruk(data) {
  const now      = new Date().toLocaleString('en-US', { timeZone: 'Asia/Jakarta' });
  const d        = new Date(now);
  const dateStr  = d.toLocaleDateString('id-ID', { day:'2-digit', month:'2-digit', year:'numeric', timeZone:'Asia/Jakarta' });
  const timeStr  = d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit', timeZone:'Asia/Jakarta' });

  const tx    = data.transaction;
  const items = tx.items ?? [];

  document.getElementById('modal-struk-body').innerHTML = `
  <div class="receipt" id="print-receipt">
    <div class="receipt-header">
    <div class="receipt-logo">
      <img src="/assets/img/logo1.png" alt="Logo" 
          style="width:50px;height:50px;object-fit:contain;display:block;margin:0 auto 2px;">
      <div>Setia Adhiguna</div>
    </div>
      <div style="font-size:10px;color:var(--text2)">Senen Jaya Blok 1&2 Lt.2 No.A7-15 Senen, Jakarta Pusat</div>
      <div style="font-size:10px;color:var(--text2)">Telp: 0813 8232 8474</div>
    </div>
    <hr class="receipt-divider">
    <div class="receipt-row"><span class="receipt-row-name">ID</span><span>${data.code}</span></div>
    <div class="receipt-row"><span class="receipt-row-name">Tanggal</span><span>${dateStr} ${timeStr}</span></div>
    <div class="receipt-row"><span class="receipt-row-name">Pelanggan</span><span>${tx.customer}</span></div>
    <div class="receipt-row"><span class="receipt-row-name">Metode</span><span>${tx.method}</span></div>
    <hr class="receipt-divider">
    ${items.map(i => `
      <div style="margin-bottom:6px">
        <div>${i.product?.emoji ?? '📦'} ${i.product?.name ?? 'Produk'}</div>
        <div class="receipt-row">
          <span class="receipt-row-name" style="padding-left:12px">${i.qty} × ${fmt(i.price)}</span>
          <span>${fmt(i.subtotal)}</span>
        </div>
      </div>`).join('')}
    <hr class="receipt-divider">
    <div class="receipt-row" style="margin-bottom:4px">
      <span class="receipt-row-name">Subtotal</span><span>${fmt(data.subtotal)}</span>
    </div>
    <div class="receipt-row" style="margin-bottom:4px">
      <span class="receipt-row-name">PPN 11%</span><span>${fmt(data.tax)}</span>
    </div>
    <hr class="receipt-divider">
    <div class="receipt-total-row"><span>TOTAL</span><span>${fmt(data.total)}</span></div>
    <hr class="receipt-divider">
    <div style="text-align:center;color:var(--text3);font-size:10px;margin-top:6px">
      Terima kasih telah berbelanja!<br>Barang yang sudah dibeli tidak dapat dikembalikan.
    </div>
  </div>`;

  openModal('modal-struk');
}

function printStruk() {
  const receipt = document.getElementById('print-receipt');
  
  const clone = receipt.cloneNode(true);
  
  const logo = clone.querySelector('.receipt-logo img');
  if (logo) logo.src = '/assets/img/logo2.png';

  const w = window.open('', '_blank');
  w.document.write(`<!DOCTYPE html><html><head><title>Struk</title>
  <style>
    body { font-family:'Courier New',monospace; font-size:12px; padding:10px; width:300px; }
    .receipt-divider { border:none; border-top:1px dashed #ccc; margin:8px 0; }
    .receipt-logo { font-weight:bold; font-size:15px; text-align:center; }
    .receipt-logo img { width:50px; height:50px; object-fit:contain; display:block; margin:0 auto 4px; }
    .receipt-header { text-align:center; margin-bottom:10px; }
    .receipt-row { display:flex; justify-content:space-between; margin-bottom:3px; }
    .receipt-row-name { flex:1; }
    .receipt-total-row { display:flex; justify-content:space-between; font-weight:bold; font-size:14px; }
  </style></head><body>`);
  w.document.write(clone.innerHTML);
  w.document.write('</body></html>');
  w.document.close();
  w.print();
}

/* =====================================================
   INIT
===================================================== */
loadProducts();