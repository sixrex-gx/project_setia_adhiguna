<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StokLog;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $products     = Product::all();
        $transactions = Transaction::with('user')->latest()->get();
        $lowStock     = Product::where('stock', '<=', 5)->count();

        $lowStockProducts = Product::where('stock', '<=', 5)->where('is_active', true)->get();

        // Laporan harian (7 hari terakhir dalam timezone Jakarta)
        $dailyReport = Transaction::select(
            DB::raw('DATE(created_at) as trx_date'),  
            DB::raw('COUNT(*) as total_trx'),
            DB::raw('SUM(total) as total_omzet'),
            DB::raw('SUM(subtotal) as total_subtotal'),
            DB::raw('SUM(tax) as total_tax')
        )
        ->where('status', 'Lunas')
        ->where('created_at', '>=', \Carbon\Carbon::now('Asia/Jakarta')->subDays(7)->startOfDay())
        ->groupByRaw('DATE(created_at)')  
        ->orderByRaw('DATE(created_at) desc')
        ->get();

        // Laporan bulanan
        $monthlyReport = Transaction::select(
                \Illuminate\Support\Facades\DB::raw('YEAR(created_at) as year'),
                \Illuminate\Support\Facades\DB::raw('MONTH(created_at) as month'),
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total_trx'),
                \Illuminate\Support\Facades\DB::raw('SUM(total) as total_omzet')
            )
            ->where('status', 'Lunas')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function($item) {
                $item->label = \Carbon\Carbon::create($item->year, $item->month, 1)
                    ->translatedFormat('M Y');
                return $item;
            });

        // Stat hari ini & kemarin (timezone Jakarta)
        $todayStart = \Carbon\Carbon::now('Asia/Jakarta')->startOfDay();
        $todayEnd   = \Carbon\Carbon::now('Asia/Jakarta')->endOfDay();
        $yesterdayStart = \Carbon\Carbon::now('Asia/Jakarta')->subDay()->startOfDay()->setTimezone('UTC');
        $yesterdayEnd   = \Carbon\Carbon::now('Asia/Jakarta')->subDay()->endOfDay()->setTimezone('UTC');

        $todayStat = Transaction::whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('status', 'Lunas')
            ->selectRaw('COUNT(*) as trx, SUM(total) as omzet')
            ->first();

        $yesterdayStat = Transaction::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
            ->where('status', 'Lunas')
            ->selectRaw('COUNT(*) as trx, SUM(total) as omzet')
            ->first();

        // Data performa kasir (timezone Jakarta)
        $kasirs = User::where('role', 'kasir')->get()->map(function($user) use ($todayStart, $todayEnd) {
            $todayTx = Transaction::where('user_id', $user->id)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->with('items')
            ->get();
            $allTx = Transaction::where('user_id', $user->id)->get();

            return [
                'id'          => $user->id,
                'name'        => $user->name,
                'email'       => $user->email,
                'trx_today'   => $todayTx->count(),
                'omzet_today' => $todayTx->sum('total'),
                'items_today' => $todayTx->sum(fn($t) => $t->items->sum('qty')),
                'trx_all'     => $allTx->count(),
                'omzet_all'   => $allTx->sum('total'),
                'last_active' => $allTx->first()?->created_at,
                'status'      => $todayTx->count() > 0 ? 'Aktif' : 'Belum Mulai',
            ];
        });

        \Carbon\Carbon::setLocale('id'); 
        \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        
        $omzetMingguan = [];
        $labels = [];

        // Ambil awal minggu ini (Senin) dalam timezone Jakarta
        $startOfWeek = \Carbon\Carbon::now('Asia/Jakarta')->startOfWeek();

        for ($i = 0; $i <= 6; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            
            $daftarHari = [
                'Sunday' => 'Min', 'Monday' => 'Sen', 'Tuesday' => 'Sel', 
                'Wednesday' => 'Rab', 'Thursday' => 'Kam', 'Friday' => 'Jum', 'Saturday' => 'Sab'
            ];
            $labels[] = $daftarHari[$date->format('l')];

            $dayData = $dailyReport->firstWhere('trx_date', $date->format('Y-m-d'));
            $omzetMingguan[] = $dayData ? (float)$dayData->total_omzet : 0;
        }
        
        $topProducts = \Illuminate\Support\Facades\DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->whereMonth('transactions.created_at', now()->month)
            ->whereYear('transactions.created_at', now()->year)
            ->select('products.name as product_name', \Illuminate\Support\Facades\DB::raw('SUM(transaction_items.qty) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Pergerakan Stok
        $filterBulan = now()->month;
        $filterTahun = now()->year;

        $stokLogs = StokLog::with('produk')
            ->latest()
            ->get();

        $totalBarangMasuk = StokLog::where('tipe', 'masuk')
            ->whereMonth('created_at', $filterBulan)
            ->whereYear('created_at', $filterTahun)
            ->sum('qty');

        $totalBarangTerjual = StokLog::where('tipe', 'keluar')
            ->whereMonth('created_at', $filterBulan)
            ->whereYear('created_at', $filterTahun)
            ->sum('qty');

        $totalMasuk = StokLog::where('tipe', 'masuk')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('qty');

        $totalKeluar = StokLog::where('tipe', 'keluar')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('qty');

        $restokHariIni = StokLog::where('tipe', 'masuk')
            ->whereDate('created_at', today())
            ->sum('qty');

        $terjualHariIni = StokLog::where('tipe', 'keluar')
            ->whereDate('created_at', today())
            ->sum('qty');

        $skuKritis = Product::where('stock', '<=', 5)->count();
        $totalStok = Product::sum('stock');

        $topProductsByMonth = \Illuminate\Support\Facades\DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->select(
                \Illuminate\Support\Facades\DB::raw('YEAR(transactions.created_at) as year'),
                \Illuminate\Support\Facades\DB::raw('MONTH(transactions.created_at) as month'),
                'products.id as product_id',
                'products.name as product_name',
                'products.emoji as product_emoji',
                \Illuminate\Support\Facades\DB::raw('SUM(transaction_items.qty) as total_sold')
            )
            ->groupBy('year', 'month', 'products.id', 'products.name', 'products.emoji')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('total_sold', 'desc')
            ->get()
            ->groupBy(fn($item) => $item->year . '-' . $item->month)
            ->map(fn($items) => $items->take(5));

        return view('admin.dashboard', compact(
            'products', 'transactions', 'lowStock', 'kasirs',
            'lowStockProducts', 'dailyReport', 'monthlyReport',
            'todayStat', 'yesterdayStat', 'omzetMingguan', 'labels',
            'topProducts',
            'stokLogs', 'totalBarangMasuk', 'totalBarangTerjual',
            'totalMasuk', 'totalKeluar', 'restokHariIni',
            'terjualHariIni', 'skuKritis', 'totalStok', 'topProductsByMonth'
        ));
    }

    public function exportCSV()
    {
        $transactions = Transaction::with(['user', 'items.product'])
            ->latest()
            ->get();

        $filename = 'transaksi_tokoadv_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            // BOM untuk Excel agar bisa baca karakter Indonesia
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header kolom
            fputcsv($file, [
                'Kode Transaksi',
                'Tanggal',
                'Jam',
                'Pelanggan',
                'Item (Produk × Qty)',
                'Subtotal',
                'PPN',
                'Total',
                'Metode Pembayaran',
                'Kasir',
                'Status',
            ]);

            // Data transaksi
            foreach ($transactions as $tx) {
                $itemList = $tx->items->map(function ($item) {
                    return ($item->product->name ?? 'Produk dihapus') . ' ×' . $item->qty;
                })->implode(' | ');

                fputcsv($file, [
                    $tx->transaction_code,
                    $tx->created_at->format('d/m/Y'),
                    $tx->created_at->format('H:i:s'),
                    $tx->customer,
                    $itemList,
                    'Rp ' . number_format($tx->subtotal, 0, ',', '.'),
                    'Rp ' . number_format($tx->tax, 0, ',', '.'),
                    'Rp ' . number_format($tx->total, 0, ',', '.'),
                    $tx->method,
                    $tx->user->name ?? '-',
                    $tx->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}