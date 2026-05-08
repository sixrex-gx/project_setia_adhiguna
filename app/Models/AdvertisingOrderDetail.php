<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertisingOrderDetail extends Model
{
    protected $table = 'advertising_order_details';

    protected $fillable = [
        'transaction_id',
        'item_name',
        'panjang',
        'lebar',
        'luas_total',
        'harga_per_meter',
        'material_name',
        'quantity',
        'subtotal',
        'finishing',
        'keterangan',
    ];

    protected $casts = [
        'finishing'       => 'array',
        'panjang'         => 'float',
        'lebar'           => 'float',
        'luas_total'      => 'float',
        'harga_per_meter' => 'float',
        'subtotal'        => 'float',
    ];

    // "2 × 3 m"
    public function getDimensiAttribute(): string
    {
        return "{$this->panjang} × {$this->lebar} m";
    }

    // Finishing sebagai string untuk invoice
    public function getFinishingLabelAttribute(): string
    {
        if (empty($this->finishing)) return 'Tanpa Finishing';

        $map = [
            'mata_ayam'         => 'Mata Ayam',
            'laminating_glossy' => 'Laminasi Glossy',
            'laminating_doff'   => 'Laminasi Doff',
            'grommets'          => 'Grommets',
            'cutting'           => 'Cutting',
            'framing'           => 'Framing',
        ];

        return collect($this->finishing)
            ->map(fn($f) => $map[$f] ?? ucfirst($f))
            ->implode(', ');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}