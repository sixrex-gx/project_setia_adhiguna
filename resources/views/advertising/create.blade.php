@extends('layouts.app')

@section('title', 'TokoAdv — Order Baru')

@section('content')
<div id="app" style="display:flex;flex-direction:column;height:100vh;overflow:hidden;">

  <!-- ====== TOP NAV ====== -->
   <nav class="top-nav no-print" style="flex-shrink:0;">
    <div class="nav-logo">
      <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo Setia Adhiguna" class="logo-img">
      <span>Setia Adhiguna</span>
    </div>
    <a href="{{ route('kasir.index') }}"
       class="nav-tab"
       style="text-decoration:none;">
       🖥 Kasir / POS
    </a>
    <button class="nav-tab active" style="background:#f59e0b; color:#1a1a2e; font-weight:bold;">
      🖨️ Advertising
    </button>
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

  <!-- ====== PAGE CONTENT ====== -->
  <div style="flex:1; overflow-y:auto; padding:20px 24px;" x-data="orderForm()">

    <!-- Header -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
      <div>
        <div style="font-size:12px; color:var(--text3); margin-bottom:4px;">
          <a href="{{ route('advertising.index') }}" style="color:var(--text3); text-decoration:none;">🖨️ Advertising</a>
          <span style="margin:0 6px;">›</span>
          <span style="color:var(--text1);">Order Baru</span>
        </div>
        <h1 style="font-size:20px; font-weight:700; color:var(--text1); margin:0;">📋 Buat Order Baru</h1>
      </div>
      <a href="{{ route('advertising.index') }}"
         style="background:#f59e0b; color:#1a1a2e; font-weight:700; padding:10px 20px;
                border-radius:8px; text-decoration:none; font-size:14px; display:flex;
                align-items:center; gap:6px;">
        ← Kembali
      </a>
    </div>

    @if($errors->any())
    <div style="background:#2d1515; border:1px solid #7f1d1d; border-left:4px solid #ef4444;
                border-radius:8px; padding:12px 16px; margin-bottom:16px;">
      <div style="color:#fca5a5; font-weight:600; margin-bottom:6px;">⚠️ Mohon periksa input:</div>
      @foreach($errors->all() as $error)
        <div style="color:#fca5a5; font-size:13px;">• {{ $error }}</div>
      @endforeach
    </div>
    @endif

    <form action="{{ route('advertising.store') }}" method="POST" @submit.prevent="submitForm">
      @csrf

      <div style="display:grid; grid-template-columns:1fr 320px; gap:16px; align-items:start;">

        <!-- ============ KOLOM KIRI ============ -->
        <div style="display:flex; flex-direction:column; gap:14px;">

          <!-- SECTION: Data Customer -->
          <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:18px;">
            <div style="font-size:12px; font-weight:700; color:var(--text3); text-transform:uppercase;
                        letter-spacing:1px; margin-bottom:14px;">
              👤 Informasi Customer
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
              <div>
                <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:6px;">
                  Nama Customer <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                       placeholder="Nama / perusahaan"
                       class="adv-input" required>
              </div>
              <div>
                <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:6px;">No. HP</label>
                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                       placeholder="0812-xxxx-xxxx" class="adv-input">
              </div>
              <div style="grid-column:span 2;">
                <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:6px;">Catatan Order</label>
                <textarea name="catatan_order" rows="2"
                          placeholder="Catatan untuk tim produksi..."
                          class="adv-input" style="resize:vertical;">{{ old('catatan_order') }}</textarea>
              </div>
            </div>
          </div>

          <!-- SECTION: Item Order -->
          <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:18px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
              <div style="font-size:12px; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:1px;">
                🖼️ Detail Item Order
              </div>
              <button type="button" @click="addItem"
                      style="background:#f59e0b; color:#1a1a2e; border:none; border-radius:8px;
                             padding:7px 14px; font-size:12px; font-weight:700; cursor:pointer;">
                + Tambah Item
              </button>
            </div>

            <template x-for="(item, i) in items" :key="i">
              <div style="border:1px solid var(--border); border-radius:10px; padding:16px;
                          margin-bottom:12px; background:var(--bg);">

                <!-- Header item -->
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                  <div style="font-size:11px; font-weight:700; color:#f59e0b; text-transform:uppercase; letter-spacing:0.5px;">
                    Item #<span x-text="i+1"></span>
                  </div>
                  <button type="button" @click="removeItem(i)" x-show="items.length > 1"
                          style="background:#2d1515; border:1px solid #7f1d1d; color:#fca5a5;
                                 border-radius:6px; padding:3px 10px; font-size:11px; cursor:pointer;">
                    ✕ Hapus
                  </button>
                </div>

                <!-- Nama Item -->
                <div style="margin-bottom:12px;">
                  <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:5px;">
                    Nama / Deskripsi Item <span style="color:#ef4444;">*</span>
                  </label>
                  <input type="text"
                         :name="`items[${i}][item_name]`"
                         x-model="item.item_name"
                         placeholder="Contoh: Spanduk Banner, Sticker Dinding, Brosur A5..."
                         class="adv-input" required>
                </div>

                <!-- ✅ SHORTCUT HARGA MATERIAL -->
                <div style="margin-bottom:12px;">
                  <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:7px;">
                    ⚡ Pilih Material <span style="color:var(--text3); font-weight:400;">(isi harga otomatis)</span>
                  </label>
                  <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    <template x-for="mat in materials" :key="mat.nama">
                      <button type="button"
                              @click="pilihMaterial(i, mat)"
                              :style="item.material === mat.nama
                                ? 'background:#f59e0b; color:#1a1a2e; border-color:#f59e0b; font-weight:700;'
                                : 'background:var(--card); color:var(--text2); border-color:var(--border);'"
                              style="border:1px solid; border-radius:6px; padding:5px 10px;
                                     font-size:11px; cursor:pointer; transition:all 0.15s; white-space:nowrap;">
                        <span x-text="mat.nama"></span>
                        <span style="opacity:0.75; margin-left:3px;"
                              x-text="'Rp'+mat.harga.toLocaleString('id-ID')+'/ m²'"></span>
                      </button>
                    </template>
                  </div>
                </div>

                <!-- Dimensi + Harga + Qty -->
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr 80px; gap:10px; margin-bottom:12px;">
                  <div>
                    <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:5px;">
                      Panjang (m) <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="number" step="0.01" min="0.01"
                           :name="`items[${i}][panjang]`"
                           x-model.number="item.panjang"
                           @input="recalc(i)"
                           placeholder="0.00"
                           class="adv-input" required>
                  </div>
                  <div>
                    <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:5px;">
                      Lebar (m) <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="number" step="0.01" min="0.01"
                           :name="`items[${i}][lebar]`"
                           x-model.number="item.lebar"
                           @input="recalc(i)"
                           placeholder="0.00"
                           class="adv-input" required>
                  </div>
                  <div>
                    <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:5px;">
                      Harga / m² (Rp) <span style="color:#ef4444;">*</span>
                    </label>
                    <!-- ✅ Harga otomatis dari shortcut, tapi tetap bisa diedit -->
                    <input type="number" step="500" min="0"
                           :name="`items[${i}][harga_per_meter]`"
                           x-model.number="item.harga"
                           @input="recalc(i); item.material = null"
                           placeholder="18000"
                           :style="item.material ? 'border-color:#f59e0b; color:#f59e0b;' : ''"
                           class="adv-input" required>
                    <div x-show="item.material"
                         style="font-size:10px; color:#f59e0b; margin-top:3px;"
                         x-text="'📌 ' + item.material"></div>
                  </div>
                  <div>
                    <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:5px;">Qty</label>
                    <input type="number" min="1"
                           :name="`items[${i}][quantity]`"
                           x-model.number="item.qty"
                           @input="recalc(i)"
                           placeholder="1"
                           class="adv-input" required>
                  </div>
                </div>

                <!-- Preview Kalkulasi -->
                <div style="background:#1a1a0a; border:1px solid #3d3000; border-radius:8px;
                            padding:12px 14px; margin-bottom:12px; display:grid;
                            grid-template-columns:1fr 1fr 1fr; gap:8px; text-align:center;">
                  <div>
                    <div style="font-size:11px; color:var(--text3); margin-bottom:3px;">Luas</div>
                    <div style="font-size:14px; font-weight:600; color:var(--text2);"
                         x-text="((item.panjang||0)*(item.lebar||0)).toFixed(2) + ' m²'"></div>
                    <div style="font-size:10px; color:var(--text3);"
                         x-text="(item.panjang||0)+' × '+(item.lebar||0)+' m'"></div>
                  </div>
                  <div>
                    <div style="font-size:11px; color:var(--text3); margin-bottom:3px;">× Qty</div>
                    <div style="font-size:14px; font-weight:600; color:var(--text2);"
                         x-text="(item.qty||1)+' pcs'"></div>
                    <div style="font-size:10px; color:var(--text3);">jumlah cetak</div>
                  </div>
                  <div>
                    <div style="font-size:11px; color:var(--text3); margin-bottom:3px;">Subtotal</div>
                    <div style="font-size:16px; font-weight:700; color:#f59e0b;"
                         x-text="'Rp '+(item.subtotal||0).toLocaleString('id-ID')"></div>
                    <div style="font-size:10px; color:var(--text3);">= (luas × harga) × qty</div>
                  </div>
                </div>

                <!-- Finishing -->
                <div style="margin-bottom:12px;">
                  <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:8px;">Finishing</label>
                  <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    @foreach([
                      'mata_ayam'         => 'Mata Ayam',
                      'laminating_glossy' => 'Laminasi Glossy',
                      'laminating_doff'   => 'Laminasi Doff',
                      'grommets'          => 'Grommets',
                      'cutting'           => 'Cutting',
                      'framing'           => 'Framing',
                    ] as $val => $label)
                    <label style="display:inline-flex; align-items:center; gap:6px; cursor:pointer;
                                  background:var(--card); border:1px solid var(--border); border-radius:6px;
                                  padding:5px 10px; font-size:12px; color:var(--text2);">
                      <input type="checkbox"
                             :name="`items[${i}][finishing][]`"
                             value="{{ $val }}"
                             style="accent-color:#f59e0b;">
                      {{ $label }}
                    </label>
                    @endforeach
                  </div>
                </div>

                <!-- Keterangan -->
                <div>
                  <label style="font-size:12px; color:var(--text3); display:block; margin-bottom:5px;">
                    Keterangan Tambahan
                  </label>
                  <textarea :name="`items[${i}][keterangan]`"
                            x-model="item.keterangan" rows="2"
                            placeholder="Misal: desain via WA, warna biru dongker, file PNG..."
                            class="adv-input" style="resize:vertical;"></textarea>
                </div>

              </div>
            </template>

            <button type="button" @click="addItem"
                    style="width:100%; background:transparent; border:2px dashed var(--border);
                           border-radius:10px; padding:12px; color:var(--text3); font-size:13px;
                           cursor:pointer; margin-top:4px;"
                    onmouseover="this.style.borderColor='#f59e0b';this.style.color='#f59e0b'"
                    onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text3)'">
              + Tambah Item Lagi
            </button>
          </div>

        </div><!-- /kolom kiri -->

        <!-- ============ KOLOM KANAN ============ -->
        <div style="position:sticky; top:0; display:flex; flex-direction:column; gap:14px;">

          <!-- Ringkasan -->
          <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:18px;">
            <div style="font-size:12px; font-weight:700; color:var(--text3); text-transform:uppercase;
                        letter-spacing:1px; margin-bottom:16px;">
              💰 Ringkasan Order
            </div>
            <template x-for="(item, i) in items" :key="i">
              <div style="display:flex; justify-content:space-between; align-items:start;
                          padding:8px 0; border-bottom:1px solid var(--border);">
                <div style="font-size:12px; color:var(--text2); flex:1; padding-right:8px;">
                  <span x-text="item.item_name || ('Item #'+(i+1))"
                        style="display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"></span>
                  <span style="color:var(--text3); font-size:11px;"
                        x-text="(item.panjang||0)+'×'+(item.lebar||0)+'m × '+(item.qty||1)+'pcs'"></span>
                  <span x-show="item.material"
                        style="color:#f59e0b; font-size:10px; display:block;"
                        x-text="item.material"></span>
                </div>
                <div style="font-size:12px; font-weight:600; color:var(--text1); white-space:nowrap;"
                     x-text="'Rp '+(item.subtotal||0).toLocaleString('id-ID')"></div>
              </div>
            </template>
            <div style="background:#1a1a0a; border:1px solid #3d3000; border-radius:8px;
                        padding:14px; text-align:center; margin-top:14px;">
              <div style="font-size:11px; color:var(--text3); margin-bottom:4px;">GRAND TOTAL</div>
              <div style="font-size:24px; font-weight:700; color:#f59e0b;"
                   x-text="'Rp ' + grandTotal.toLocaleString('id-ID')"></div>
              <div style="font-size:11px; color:var(--text3); margin-top:4px;"
                   x-text="items.length + ' item'"></div>
            </div>
          </div>

          <!-- Tombol Simpan -->
          <button type="submit"
                  :disabled="grandTotal <= 0"
                  :style="grandTotal > 0
                    ? 'background:#f59e0b; color:#1a1a2e; cursor:pointer;'
                    : 'background:#3d3000; color:#78716c; cursor:not-allowed; opacity:0.6;'"
                  style="width:100%; border:none; border-radius:12px; padding:14px;
                         font-size:15px; font-weight:700;">
            💾 Simpan Order
          </button>

          <a href="{{ route('advertising.index') }}"
             style="display:block; text-align:center; background:transparent;
                    border:1px solid var(--border); border-radius:12px; padding:12px;
                    font-size:13px; color:var(--text3); text-decoration:none;">
            Batal
          </a>

          <!-- Info formula -->
          <div style="background:var(--card); border:1px solid var(--border); border-radius:10px;
                      padding:12px 14px; font-size:11px; color:var(--text3); line-height:1.8;">
            <div style="font-weight:600; color:var(--text2); margin-bottom:4px;">📐 Formula Harga</div>
            (Panjang × Lebar × Harga/m²) × Qty
            <div style="margin-top:6px; color:var(--text3);">
              Contoh: 2×3m × Rp18.000 × 2pcs =
              <span style="color:#f59e0b; font-weight:700;">Rp 216.000</span>
            </div>
          </div>

        </div><!-- /kolom kanan -->

      </div>

      <input type="hidden" name="grand_total" :value="grandTotal">
    </form>
  </div>
</div>

<style>
.adv-input {
  width: 100%;
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 9px 12px;
  color: var(--text1);
  font-size: 13px;
  box-sizing: border-box;
  outline: none;
  transition: border-color 0.15s;
}
.adv-input:focus { border-color: #f59e0b; }
</style>

<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('orderForm', () => ({

    // ✅ Daftar shortcut material + harga — ubah sesuai harga toko kamu
    materials: [
      { nama: 'Flexi China',       harga: 18000  },
      { nama: 'Flexi Korea',       harga: 25000  },
      { nama: 'Vinyl Sticker',     harga: 35000  },
      { nama: 'Canvas',            harga: 45000  },
      { nama: 'Kertas Foto',       harga: 12000  },
      { nama: 'Sticker Cromo',     harga: 28000  },
      { nama: 'One Way Vision',    harga: 55000  },
      { nama: 'Backlit Film',      harga: 60000  },
    ],

    items: [newItem()],

    get grandTotal() {
      return this.items.reduce((sum, item) => sum + (item.subtotal || 0), 0);
    },

    // ✅ Klik shortcut → isi harga, highlight tombol, recalculate
    pilihMaterial(i, mat) {
      this.items[i].material = mat.nama;
      this.items[i].harga    = mat.harga;
      this.recalc(i);
    },

    addItem()      { this.items.push(newItem()); },
    removeItem(i)  { if (this.items.length > 1) this.items.splice(i, 1); },

    // Formula: (Panjang × Lebar × Harga/m²) × Qty
    recalc(i) {
      const it = this.items[i];
      const p  = parseFloat(it.panjang) || 0;
      const l  = parseFloat(it.lebar)   || 0;
      const h  = parseFloat(it.harga)   || 0;
      const q  = parseInt(it.qty)       || 1;
      it.subtotal = Math.round((p * l * h) * q);
    },

    submitForm(e) {
      const invalid = this.items.some(x => !x.item_name || !x.panjang || !x.lebar || !x.harga);
      if (invalid) {
        alert('Mohon lengkapi semua field yang wajib diisi (*)');
        return;
      }
      e.target.submit();
    }
  }));
});

function newItem() {
  return { item_name:'', panjang:null, lebar:null, harga:null,
           qty:1, subtotal:0, keterangan:'', material:null };
}

// Jam navbar
function tick() {
  const n = new Date(), pad = v => String(v).padStart(2,'0');
  const el = document.getElementById('nav-time');
  if (el) el.textContent = pad(n.getHours())+':'+pad(n.getMinutes())+':'+pad(n.getSeconds());
}
tick(); setInterval(tick, 1000);
</script>
@endsection