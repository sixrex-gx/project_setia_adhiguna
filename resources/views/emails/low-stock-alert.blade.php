<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
    .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,.1); }
    .header { background: #1a1a1a; padding: 24px; text-align: center; }
    .logo { color: #f59e0b; font-size: 22px; font-weight: bold; font-family: monospace; }
    .body { padding: 28px; }
    .alert-badge { background: #450a0a; color: #fca5a5; padding: 10px 16px; border-radius: 8px; font-size: 14px; font-weight: bold; margin-bottom: 20px; display: inline-block; }
    .product-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #f9f9f9; border-radius: 8px; margin-bottom: 8px; border-left: 4px solid #ef4444; }
    .product-name { font-size: 14px; font-weight: 600; color: #111; }
    .product-stock { font-size: 13px; color: #ef4444; font-weight: bold; }
    .footer { background: #f5f5f5; padding: 16px; text-align: center; font-size: 12px; color: #888; }
    .btn { display: inline-block; background: #f59e0b; color: #000; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold; margin-top: 20px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
  <img src="{{ asset('assets/img/logo1.png') }}" 
       alt="Setia Adhiguna Adv" 
       style="height:50px;margin-bottom:10px;display:block;margin-left:auto;margin-right:auto">
  <div class="logo" style="color:#f59e0b;font-size:20px;font-weight:bold;font-family:monospace">
    Setia Adhiguna Adv
  </div>
  <div style="color:#a3a3a3;font-size:13px;margin-top:4px">Sistem POS ATK & Advertising</div>
</div>
    <div class="body">
      <div class="alert-badge">⚠️ PERINGATAN STOK KRITIS</div>
      <h2 style="font-size:18px;color:#111;margin:0 0 8px">Segera Lakukan Restock!</h2>
      <p style="font-size:14px;color:#555;margin:0 0 20px">
        Produk berikut memiliki stok yang sangat rendah dan perlu segera diisi ulang:
      </p>

      @foreach($lowStockProducts as $product)
      <div class="product-item">
        <div>
          <div class="product-name">{{ $product['emoji'] ?? '📦' }} {{ $product['name'] }}</div>
          <div style="font-size:12px;color:#888">Kategori: {{ $product['category'] ?? '-' }}</div>
        </div>
        <div class="product-stock">{{ $product['stock'] }} {{ $product['unit'] }} tersisa</div>
      </div>
      @endforeach

      <p style="font-size:13px;color:#555;margin-top:20px">
        Silakan login ke dashboard admin untuk melakukan restock produk.
      </p>
      <a href="{{ url('/admin') }}" class="btn">Buka Dashboard Admin →</a>
    </div>
    <div class="footer">
      Email ini dikirim otomatis oleh Sistem POS TokoAdv<br>
      {{ now()->format('d M Y H:i') }} WIB
    </div>
  </div>
</body>
</html>