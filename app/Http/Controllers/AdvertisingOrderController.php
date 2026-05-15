<?php

namespace App\Http\Controllers;

use App\Models\AdvertisingOrderDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvertisingOrderController extends Controller
{
    // ── INDEX ────────────────────────────────────────────────
    public function index()
    {
        $orders = Transaction::with('advertisingDetails')
            ->where('order_type', 'advertising')
            ->latest()
            ->get();

        return view('advertising.index', compact('orders'));
    }

    // ── CREATE ───────────────────────────────────────────────
    public function create()
    {
        return view('advertising.create');
    }

    // ── STORE ────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'           => 'required|string|max:255',
            'customer_phone'          => 'nullable|string|max:20',
            'catatan_order'           => 'nullable|string',
            'items'                   => 'required|array|min:1',
            'items.*.item_name'       => 'required|string|max:255',
            'items.*.panjang'         => 'required|numeric|min:0.01',
            'items.*.lebar'           => 'required|numeric|min:0.01',
            'items.*.harga_per_meter' => 'required|numeric|min:0',
            'items.*.quantity'        => 'required|integer|min:1',
            'payment_method'          => 'nullable|in:Tunai,QRIS,Transfer,Kartu',
        ], [
            'items.*.item_name.required'  => 'Nama item wajib diisi',
            'items.*.panjang.numeric'     => 'Panjang harus angka',
            'items.*.lebar.numeric'       => 'Lebar harus angka',
            'items.*.panjang.min'         => 'Panjang minimal 0.01 m',
            'items.*.lebar.min'           => 'Lebar minimal 0.01 m',
        ]);

        // Hitung total
        $grandTotal = 0;
        $itemsData  = [];

        foreach ($request->items as $item) {
            $panjang   = (float) $item['panjang'];
            $lebar     = (float) $item['lebar'];
            $harga     = (float) $item['harga_per_meter'];
            $qty       = (int)   $item['quantity'];
            $luasTotal = $panjang * $lebar;
            $subtotal  = round(($luasTotal * $harga) * $qty, 2);
            $grandTotal += $subtotal;

            $itemsData[] = [
                'item_name'       => $item['item_name'],
                'panjang'         => $panjang,
                'lebar'           => $lebar,
                'luas_total'      => round($luasTotal, 4),
                'harga_per_meter' => $harga,
                'material_name'   => $item['material_name'] ?? null,
                'quantity'        => $qty,
                'subtotal'        => $subtotal,
                'finishing'       => $item['finishing'] ?? [],
                'keterangan'      => $item['keterangan'] ?? null,
            ];
        }

        DB::transaction(function () use ($request, $itemsData, $grandTotal) {
            // Sesuai kolom Transaction: customer, subtotal, tax, total, method, status
            $trx = Transaction::create([
                'transaction_code'  => $this->generateCode(),
                'user_id'           => auth()->id(),
                'customer'          => $request->customer_name,
                'customer_phone'    => $request->customer_phone,
                'subtotal'          => $grandTotal,
                'tax'               => 0,
                'total'             => $grandTotal,
                'method'            => $request->payment_method ?? 'Tunai',
                'status'            => 'Lunas',
                'order_type'        => 'advertising',
                'production_status' => 'Pending',
                'production_notes'  => $request->catatan_order,
            ]);

            foreach ($itemsData as $item) {
                AdvertisingOrderDetail::create(
                    array_merge($item, ['transaction_id' => $trx->id])
                );
            }
        });

        return redirect()
            ->route('advertising.index')
            ->with('success', '✅ Order berhasil disimpan!');
    }

    // ── SHOW ─────────────────────────────────────────────────
    public function show($id)
    {
        $order = Transaction::with('advertisingDetails')
            ->where('order_type', 'advertising')
            ->findOrFail($id);

        return view('advertising.show', compact('order'));
    }

    // ── UPDATE STATUS ────────────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'production_status' => 'required|in:Pending,Design,Cetak,Selesai,Diambil',
        ]);

        $order = Transaction::where('order_type', 'advertising')->findOrFail($id);
        $order->update(['production_status' => $request->production_status]);

        return back()->with('success', 'Status diperbarui ke: ' . $request->production_status);
    }

    // ── INVOICE ──────────────────────────────────────────────
    public function invoice($id)
    {
        $order = Transaction::with('advertisingDetails')
            ->where('order_type', 'advertising')
            ->findOrFail($id);

        return view('advertising.invoice', compact('order'));
    }

    // ── HELPER ───────────────────────────────────────────────
    private function generateCode(): string
    {
        $prefix = 'ADV-' . now()->format('Ymd') . '-';
        $last   = Transaction::where('transaction_code', 'like', $prefix . '%')
                             ->latest('id')
                             ->value('transaction_code');

        $seq = $last ? ((int) substr($last, -4) + 1) : 1;

        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}