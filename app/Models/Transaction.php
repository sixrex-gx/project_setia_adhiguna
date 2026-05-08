<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_code','user_id','customer',
        'subtotal','tax','total','method','status',
        'order_type', 'production_status',
        'production_notes', 'customer_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function advertisingDetails()
    {
    return $this->hasMany(\App\Models\AdvertisingOrderDetail::class, 'transaction_id');
    }

}