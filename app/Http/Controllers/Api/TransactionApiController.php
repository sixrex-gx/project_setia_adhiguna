<?php
namespace App\Http\Controllers\Api;

use App\Mail\LowStockAlert;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionApiController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['items.product', 'user'])
            ->latest()
            ->get();
        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'    => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty'        => 'required|integer|min:1',
            'method'   => 'required|in:Tunai,QRIS,Transfer,Kartu',
            'customer' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Hitung subtotal
            $subtotal = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Cek stok cukup
                if ($product->stock < $item['qty']) {
                    return response()->json([
                        'message' => "Stok {$product->name} tidak cukup. Sisa: {$product->stock}"
                    ], 422);
                }

                $subtotal += $product->price * $item['qty'];
            }

            $tax   = round($subtotal * 0.11);
            $total = $subtotal + $tax;

            // Buat kode transaksi
            $code = 'TRX-' . strtoupper(uniqid());

            // Simpan transaksi
            $transaction = Transaction::create([
                'transaction_code' => $code,
                'user_id'          => Auth::id(),
                'customer'         => $request->customer ?? 'Umum',
                'subtotal'         => $subtotal,
                'tax'              => $tax,
                'total'            => $total,
                'method'           => $request->method,
                'status'           => 'Lunas',
            ]);

            // Simpan item & kurangi stok
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $product->id,
                    'qty'            => $item['qty'],
                    'price'          => $product->price,
                    'subtotal'       => $product->price * $item['qty'],
                ]);

                // Kurangi stok
                $product->decrement('stock', $item['qty']);
            }

            DB::commit();
            // Cek stok kritis & kirim email
            $lowStockItems = [];
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if ($product && $product->stock <= 5) {
                    $lowStockItems[] = [
                        'name'     => $product->name,
                        'emoji'    => $product->emoji,
                        'category' => $product->category,
                        'stock'    => $product->stock,
                        'unit'     => $product->unit,
                    ];
                }
            }

            if (!empty($lowStockItems)) {
                Mail::to(env('ADMIN_EMAIL'))->send(new LowStockAlert($lowStockItems));
            }

            return response()->json([
                'message'     => 'Transaksi berhasil',
                'transaction' => $transaction->load('items.product'),
                'code'        => $code,
                'subtotal'    => $subtotal,
                'tax'         => $tax,
                'total'       => $total,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}