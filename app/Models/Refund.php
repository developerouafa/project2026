<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'merchant_id',
        'payment_id',
        'client_id',
        'amount',
        'reason',
        'status',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    // 🔗 Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // 🔗 Merchant (في حالة partial refund)
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // 🔗 Payment
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // 🔗 Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
