@extends('layouts.app')

@section('title', 'Detail Order — {{ $order->transaction_code }}')

@section('content')
<div id="app" style="display:flex;flex-direction:column;height:100vh;overflow:hidden;">

  <!-- NAV -->
  <nav class="top-nav no-print" style="flex-shrink:0; display:flex; align-items:center; width:100%;">
    <div class="nav-logo">
      <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo" class="logo-img">
      <span>Setia Adhiguna</span>
    </div>
    <a href="{{ route('kasir.index') }}" class="nav-tab" style="text-decoration:none;">🖥 Kasir / POS</a>
    <a href="{{ route('advertising.index') }}" class="nav-tab" style="text-decoration:none; background:#f59e0b; color:#1a1a2e; font-weight:bold;">🖨️ Advertising</a>
    <div style="flex:1;"></div>
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

    <!-- Breadcrumb -->
    <div style="font-size:12px; color:var(--text3); margin-bottom:16px;">
      <a href="{{ route('advertising.index') }}" style="color:var(--text3); text-decoration:none;">🖨️ Advertising</a>
      <span style="margin:0 6px;">›</span>
      <span style="color:var(--text1);">{{ $order->transaction_code }}</span>
    </div>

    <div style="display:grid; grid-template-columns:1fr 300px; gap:16px; align-items:start;">

      <!-- KIRI: Detail Item -->
      <div style="display:flex; flex-direction:column; gap:14px;">

        <!-- Info Customer -->
        <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:18px;">
          <div style="font-size:12px; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:1px; margin-bottom:14px;">
            👤 Informasi Customer
          </div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
            <div>
              <div style="font-size:11px; color:var(--text3); margin-bottom:3px;">Nama Customer</div>
              <div style="font-size:14px; font-weight:600; color:var(--text1);">{{ $order->customer }}</div>
            </div>
            <div>
              <div style="font-size:11px; color:var(--text3); margin-bottom:3px;">No. HP</div>
              <div style="font-size:14px; color:var(--text2);">{{ $order->customer_phone ?? '-' }}</div>
            </div>
            @if($order->production_notes)
            <div style="grid-column:span 2;">
              <div style="font-size:11px; color:var(--text3); margin-bottom:3px;">Catatan</div>
              <div style="font-size:13px; color:var(--text2);">{{ $order->production_notes }}</div>
            </div>
            @endif
          </div>
        </div>

        <!-- Item-item Order -->
        <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:18px;">
          <div style="font-size:12px; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:1px; margin-bottom:16px;">
            🖼️ Detail Item
          </div>

          @foreach($order->advertisingDetails as $i => $detail)
          <div style="border:1px solid var(--border); border-radius:10px; padding:14px;
                      margin-bottom:10px; background:var(--bg);">

            <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:12px;">
              <div>
                <div style="font-size:11px; color:#f59e0b; font-weight:700; text-transform:uppercase; margin-bottom:3px;">
                  Item #{{ $i + 1 }}
                </div>
                <div style="font-size:15px; font-weight:600; color:var(--text1);">{{ $detail->item_name }}</div>
                @if($detail->material_name)
                <div style="font-size:11px; color:var(--text3); margin-top:2px;">📦 {{ $detail->material_name }}</div>
                @endif
              </div>
              <div style="text-align:right;">
                <div style="font-size:11px; color:var(--text3);">Subtotal</div>
                <div style="font-size:16px; font-weight:700; color:#f59e0b;">
                  Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                </div>
              </div>
            </div>

            <!-- Ukuran (highlight untuk operator) -->
            <div style="background:#1a1a0a; border:2px solid #f59e0b; border-radius:8px;
                        padding:10px 14px; margin-bottom:10px; display:grid;
                        grid-template-columns:1fr 1fr 1fr 1fr; gap:8px; text-align:center;">
              <div>
                <div style="font-size:10px; color:var(--text3); margin-bottom:2px;">Panjang</div>
                <div style="font-size:16px; font-weight:700; color:#f59e0b;">{{ $detail->panjang }} m</div>
              </div>
              <div>
                <div style="font-size:10px; color:var(--text3); margin-bottom:2px;">Lebar</div>
                <div style="font-size:16px; font-weight:700; color:#f59e0b;">{{ $detail->lebar }} m</div>
              </div>
              <div>
                <div style="font-size:10px; color:var(--text3); margin-bottom:2px;">Luas</div>
                <div style="font-size:16px; font-weight:700; color:var(--text2);">{{ number_format($detail->luas_total, 2) }} m²</div>
              </div>
              <div>
                <div style="font-size:10px; color:var(--text3); margin-bottom:2px;">Qty</div>
                <div style="font-size:16px; font-weight:700; color:var(--text2);">{{ $detail->quantity }} pcs</div>
              </div>
            </div>

            <div style="display:flex; justify-content:space-between; font-size:12px; color:var(--text3);">
              <div>
                Harga: <span style="color:var(--text2);">Rp {{ number_format($detail->harga_per_meter, 0, ',', '.') }}/m²</span>
              </div>
              @if($detail->finishing && count($detail->finishing) > 0)
              <div>
                Finishing: <span style="color:var(--text2);">{{ $detail->finishing_label }}</span>
              </div>
              @endif
            </div>

            @if($detail->keterangan)
            <div style="margin-top:8px; font-size:12px; color:var(--text3); border-top:1px solid var(--border); padding-top:8px;">
              📝 {{ $detail->keterangan }}
            </div>
            @endif
          </div>
          @endforeach
        </div>

      </div>

      <!-- KANAN: Summary & Status -->
      <div style="display:flex; flex-direction:column; gap:14px;">

        <!-- Kode & Total -->
        <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:18px;">
          <div style="font-size:11px; color:var(--text3); margin-bottom:3px;">Kode Order</div>
          <div style="font-family:monospace; font-size:15px; font-weight:700; color:#f59e0b; margin-bottom:12px;">
            {{ $order->transaction_code }}
          </div>
          <div style="font-size:11px; color:var(--text3); margin-bottom:3px;">Tanggal</div>
          <div style="font-size:13px; color:var(--text2); margin-bottom:12px;">
            {{ $order->created_at->format('d M Y, H:i') }} WIB
          </div>
          <div style="background:#1a1a0a; border:1px solid #3d3000; border-radius:8px; padding:14px; text-align:center;">
            <div style="font-size:11px; color:var(--text3); margin-bottom:4px;">TOTAL</div>
            <div style="font-size:22px; font-weight:700; color:#f59e0b;">
              Rp {{ number_format($order->total, 0, ',', '.') }}
            </div>
            <div style="font-size:11px; color:var(--text3); margin-top:3px;">
              {{ $order->advertisingDetails->count() }} item
            </div>
          </div>
        </div>

        <!-- Update Status -->
        <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:18px;">
          <div style="font-size:12px; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:1px; margin-bottom:12px;">
            🔄 Status Produksi
          </div>
          @php
            $statusList  = ['Pending'=>'⏳','Design'=>'🎨','Cetak'=>'🖨️','Selesai'=>'✅','Diambil'=>'📦'];
            $statusColors = ['Pending'=>'#94a3b8','Design'=>'#60a5fa','Cetak'=>'#fbbf24','Selesai'=>'#34d399','Diambil'=>'#a78bfa'];
          @endphp
          <form method="POST" action="{{ route('advertising.status', $order->id) }}">
            @csrf @method('PATCH')
            <div style="display:flex; flex-direction:column; gap:6px; margin-bottom:12px;">
              @foreach($statusList as $status => $icon)
              <label style="display:flex; align-items:center; gap:8px; cursor:pointer;
                            background:{{ $order->production_status === $status ? '#1a1a0a' : 'transparent' }};
                            border:1px solid {{ $order->production_status === $status ? '#f59e0b' : 'var(--border)' }};
                            border-radius:8px; padding:8px 12px;">
                <input type="radio" name="production_status" value="{{ $status }}"
                       {{ $order->production_status === $status ? 'checked' : '' }}
                       style="accent-color:#f59e0b;">
                <span style="font-size:13px; color:{{ $statusColors[$status] }}; font-weight:{{ $order->production_status === $status ? '700' : '400' }};">
                  {{ $icon }} {{ $status }}
                </span>
              </label>
              @endforeach
            </div>
            <button type="submit"
                    style="width:100%; background:#f59e0b; color:#1a1a2e; border:none;
                           border-radius:8px; padding:10px; font-size:13px; font-weight:700; cursor:pointer;">
              Simpan Status
            </button>
          </form>
        </div>

        <!-- Tombol Aksi -->
        <a href="{{ route('advertising.invoice', $order->id) }}"
           style="display:block; background:#1d4ed8; color:#fff; text-align:center;
                  border-radius:12px; padding:12px; font-size:13px; font-weight:700;
                  text-decoration:none;">
          🖨️ Cetak Nota / Invoice
        </a>

        <a href="{{ route('advertising.index') }}"
           style="display:block; text-align:center; background:transparent;
                  border:1px solid var(--border); border-radius:12px; padding:12px;
                  font-size:13px; color:var(--text3); text-decoration:none;">
          ← Kembali ke Daftar
        </a>

      </div>
    </div>
  </div>
</div>

<script>
function tick() {
  const n = new Date(), pad = v => String(v).padStart(2,'0');
  const el = document.getElementById('nav-time');
  if (el) el.textContent = pad(n.getHours())+':'+pad(n.getMinutes())+':'+pad(n.getSeconds());
}
tick(); setInterval(tick, 1000);
</script>
@endsection