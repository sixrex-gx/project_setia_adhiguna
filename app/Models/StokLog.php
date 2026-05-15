<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokLog extends Model
{
    protected $fillable = [
        'produk_id',
        'tipe',
        'qty',
        'nilai',
        'referensi_tipe',
        'referensi_id',
        'keterangan',
    ];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaction::class, 'referensi_id');
    }
}
