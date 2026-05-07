<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','emoji','category','unit','price','cost','stock','is_active'
    ];

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}