<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index()
    {
        return response()->json(Product::where('is_active', true)->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::create([
            'name'     => $request->name,
            'emoji'    => $request->emoji    ?? '📦',
            'category' => $request->category ?? 'Lainnya',
            'unit'     => $request->unit     ?? 'pcs',
            'price'    => $request->price,
            'cost'     => $request->cost     ?? 0,
            'stock'    => $request->stock,
        ]);

        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->only([
            'name','emoji','category','unit','price','cost','stock','is_active'
        ]));
        return response()->json($product);
    }

    public function restock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->increment('stock', $request->qty ?? 0);
        return response()->json([
            'message' => 'Restock berhasil',
            'stock'   => $product->fresh()->stock,
        ]);
    }
}