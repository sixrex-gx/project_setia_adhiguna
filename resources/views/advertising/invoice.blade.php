<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nota — {{ $order->transaction_code }}</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #1a1a1a;
      background: #fff;
      padding: 20px;
      max-width: 700px;
      margin: 0 auto;
    }

    /* Header */
    .header { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:3px solid #f59e0b; padding-bottom:14px; margin-bottom:14px; }
    .company-name { font-size:22px; font-weight:900; color:#1a1a1a; letter-spacing:0.5px; }
    .company-sub { font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px; margin-top:2px; }
    .company-contact { font-size:11px; color:#555; margin-top:6px; line-height:1.6; }
    .nota-label { text-align:right; }
    .nota-label .title { font-size:18px; font-weight:900; color:#f59e0b; }
    .nota-label .code { font-size:13px; font-weight:700; color:#1a1a1a; font-family:monospace; margin-top:4px; }

    /* Meta info */
    .meta-bar { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; background:#fef9c3; border:1px solid #f59e0b; border-radius:8px; padding:10px 14px; margin-bottom:14px; }
    .meta-item .label { font-size:10px; color:#92400e; text-transform:uppercase; margin-bottom:2px; }
    .meta-item .value { font-size:12px; font-weight:700; color:#1a1a1a; }

    /* Status badge */
    .status { display:inline-block; padding:3px 10px; border-radius:20px; font-size:10px; font-weight:700; text-transform:uppercase; }
    .status-Pending { background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; }
    .status-Design  { background:#dbeafe; color:#1d4ed8; border:1px solid #93c5fd; }
    .status-Cetak   { background:#fef9c3; color:#92400e; border:1px solid #fde68a; }
    .status-Selesai { background:#dcfce7; color:#15803d; border:1px solid #86efac; }
    .status-Diambil { background:#ede9fe; color:#6d28d9; border:1px solid #c4b5fd; }

    /* Tabel item */
    .items-table { width:100%; border-collapse:collapse; margin-bottom:14px; }
    .items-table thead th {
      background:#1a1a1a; color:#f59e0b; padding:8px 10px;
      text-align:left; font-size:10px; text-transform:uppercase; letter-spacing:0.3px;
    }
    .items-table thead th:last-child { text-align:right; }
    .items-table tbody td { padding:10px 10px; border-bottom:1px solid #e5e7eb; vertical-align:top; font-size:12px; }
    .items-table tbody tr:nth-child(even) { background:#fafafa; }

    /* UKURAN — prioritas operator cetak */
    .ukuran-badge {
      display:inline-block;
      background:#fef9c3; border:2px solid #f59e0b;
      border-radius:6px; padding:4px 12px;
      font-size:16px; font-weight:900; color:#92400e;
      letter-spacing:0.5px;
    }
    .luas-info { font-size:10px; color:#666; margin-top:3px; }
    .finishing-tag { display:inline-block; background:#ede9fe; color:#5b21b6; border-radius:3px; padding:1px 6px; font-size:10px; margin:1px; }

    /* Total */
    .total-section { display:flex; justify-content:flex-end; margin-bottom:14px; }
    .total-box { width:240px; }
    .total-row { display:flex; justify-content:space-between; padding:4px 0; font-size:12px; }
    .grand-row { background:#1a1a1a; color:#f59e0b; padding:10px 12px; border-radius:6px; display:flex; justify-content:space-between; font-size:15px; font-weight:900; margin-top:6px; }

    /* Ringkasan ukuran untuk operator */
    .operator-box { background:#f0fdf4; border:1px solid #86efac; border-left:4px solid #16a34a; border-radius:6px; padding:10px 14px; margin-bottom:14px; }
    .operator-box .title { font-weight:700; color:#15803d; font-size:12px; margin-bottom:6px; }
    .operator-row { font-size:12px; margin-bottom:4px; }
    .operator-size { background:#fef9c3; border:1px solid #f59e0b; padding:1px 8px; border-radius:4px; font-weight:900; font-size:13px; }

    /* Catatan -->
    .notes-box { background:#fff7ed; border:1px solid #fed7aa; border-left:4px solid #f97316; border-radius:6px; padding:10px 14px; margin-bottom:14px; }

    /* Footer TTD */
    .footer { display:flex; justify-content:space-between; margin-top:20px; border-top:1px dashed #d1d5db; padding-top:14px; font-size:11px; color:#666; }
    .sign-box { text-align:center; width:110px; }
    .sign-line { height:40px; border-bottom:1px solid #374151; margin-bottom:5px; }

    /* Print button */
    .print-btn { display:block; background:#f59e0b; color:#1a1a1a; text-align:center; padding:12px; border-radius:8px; font-weight:700; font-size:14px; text-decoration:none; margin-bottom:20px; cursor:pointer; border:none; width:100%; }
    .back-btn { display:block; text-align:center; padding:10px; border-radius:8px; font-size:13px; color:#666; text-decoration:none; border:1px solid #d1d5db; margin-bottom:30px; }
    @media print {
      .print-btn, .back-btn { display:none; }
      body { padding:0; }
    }
  </style>
</head>
<body>

  <!-- Tombol Print -->
  <button class="print-btn" onclick="window.print()">🖨️ Cetak Nota Ini</button>
  <a href="{{ route('advertising.show', $order->id) }}" class="back-btn">← Kembali ke Detail Order</a>

  <!-- Header Perusahaan -->
  <div class="header">
    <div>
      <div class="company-name">Setia Adhiguna</div>
      <div class="company-sub">Advertising & Percetakan</div>
      <div class="company-contact">
        📍 Alamat Toko Kamu<br>
        📞 Nomor HP Toko
      </div>
    </div>
    <div class="nota-label">
      <div class="title">NOTA ORDER</div>
      <div class="code">{{ $order->transaction_code }}</div>
    </div>
  </div>

  <!-- Meta Info -->
  <div class="meta-bar">
    <div class="meta-item">
      <div class="label">Customer</div>
      <div class="value">{{ $order->customer }}</div>
    </div>
    <div class="meta-item">
      <div class="label">No. HP</div>
      <div class="value">{{ $order->customer_phone ?? '-' }}</div>
    </div>
    <div class="meta-item">
      <div class="label">Tanggal</div>
      <div class="value">{{ $order->created_at->format('d M Y') }}</div>
    </div>
    <div class="meta-item">
      <div class="label">Status</div>
      <div class="value">
        <span class="status status-{{ $order->production_status }}">
          {{ $order->production_status }}
        </span>
      </div>
    </div>
  </div>

  <!-- Tabel Item -->
  <table class="items-table">
    <thead>
      <tr>
        <th style="width:4%">#</th>
        <th style="width:25%">Deskripsi</th>
        <th style="width:24%">📐 Ukuran</th>
        <th style="width:15%">Finishing</th>
        <th style="width:12%">Harga/m²</th>
        <th style="width:5%">Qty</th>
        <th style="width:15%; text-align:right">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($order->advertisingDetails as $i => $detail)
      <tr>
        <td style="color:#999;">{{ $i+1 }}</td>
        <td>
          <strong>{{ $detail->item_name }}</strong>
          @if($detail->material_name)
            <div style="font-size:10px; color:#666;">{{ $detail->material_name }}</div>
          @endif
          @if($detail->keterangan)
            <div style="font-size:10px; color:#888; margin-top:2px;">{{ $detail->keterangan }}</div>
          @endif
        </td>
        <td>
          {{-- UKURAN — elemen terpenting untuk operator cetak --}}
          <span class="ukuran-badge">{{ $detail->panjang }} × {{ $detail->lebar }} m</span>
          <div class="luas-info">Luas: {{ number_format($detail->luas_total, 2) }} m²</div>
        </td>
        <td>
          @if($detail->finishing && count($detail->finishing) > 0)
            @foreach($detail->finishing as $f)
              <span class="finishing-tag">{{ $detail->finishing_label }}</span>
            @endforeach
          @else
            <span style="color:#999; font-size:10px;">–</span>
          @endif
        </td>
        <td>Rp {{ number_format($detail->harga_per_meter, 0, ',', '.') }}</td>
        <td style="text-align:center;">{{ $detail->quantity }}</td>
        <td style="text-align:right; font-weight:700; color:#1a1a1a;">
          Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Total -->
  <div class="total-section">
    <div class="total-box">
      <div class="total-row">
        <span style="color:#666;">Subtotal ({{ $order->advertisingDetails->count() }} item)</span>
        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
      </div>
      <div class="grand-row">
        <span>TOTAL</span>
        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
      </div>
    </div>
  </div>

  <!-- Catatan Produksi -->
  @if($order->production_notes)
  <div class="notes-box">
    <strong style="color:#c2410c;">📋 Catatan Produksi:</strong>
    <div style="margin-top:4px;">{{ $order->production_notes }}</div>
  </div>
  @endif

  <!-- RINGKASAN UKURAN — Khusus Operator Bengkel -->
  <div class="operator-box">
    <div class="title">🖨️ RINGKASAN UKURAN — Untuk Operator Cetak</div>
    @foreach($order->advertisingDetails as $i => $detail)
    <div class="operator-row">
      <strong>{{ $i+1 }}. {{ $detail->item_name }}</strong> →
      <span class="operator-size">{{ $detail->panjang }} × {{ $detail->lebar }} m</span>
      <span style="color:#666; font-size:11px;">
        ({{ number_format($detail->luas_total,2) }} m²) × {{ $detail->quantity }} pcs
        @if($detail->material_name) — {{ $detail->material_name }} @endif
      </span>
    </div>
    @endforeach
  </div>

  <!-- Footer TTD -->
  <div class="footer">
    <div>
      <div>Dicetak: {{ now()->format('d M Y, H:i') }} WIB</div>
      <div style="margin-top:4px;">Terima kasih 🙏</div>
    </div>
    <div style="display:flex; gap:24px;">
      <div class="sign-box">
        <div class="sign-line"></div>
        <div>Operator</div>
      </div>
      <div class="sign-box">
        <div class="sign-line"></div>
        <div>Customer</div>
      </div>
      <div class="sign-box">
        <div class="sign-line"></div>
        <div>Admin</div>
      </div>
    </div>
  </div>

</body>
</html>