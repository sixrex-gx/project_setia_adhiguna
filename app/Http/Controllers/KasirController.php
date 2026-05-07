<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();

        // Statistik kasir hari ini
        $todayTx = Transaction::where('user_id', Auth::id())
            ->whereDate('created_at', today())
            ->with('items')
            ->latest()
            ->get();

        $stats = [
            'total_trx'    => $todayTx->count(),
            'total_omzet'  => $todayTx->sum('total'),
            'total_items'  => $todayTx->sum(fn($t) => $t->items->sum('qty')),
            'transactions' => $todayTx,
        ];

        return view('kasir.index', compact('products', 'stats'));
    }
}