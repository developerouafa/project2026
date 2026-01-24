<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'merchant_id',
        'status', //pending, accepted, rejected, processing, delivered
        'accepted_at',
    ];

    // 🔗 Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // 🔗 Merchant
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
