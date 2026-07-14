<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $fillable = [
        'user_id',
        'periode',
        'gaji_pokok',
        'tunjangan',
        'lembur_jam',
        'lembur_rate',
        'potongan',
        'gaji_bersih',
        'tanggal_bayar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   public static function hitungGajiBersih(
    float $gajiPokok,
    float $tunjangan,
    float $lemburJam,
    float $lemburRate,
    float $potongan
    
    ): float {
        return $gajiPokok + $tunjangan + ($lemburJam * $lemburRate) - $potongan;
    }
}