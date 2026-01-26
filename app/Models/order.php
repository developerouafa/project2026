<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'merchant_id',
        'total',
        'status',
        'final_notification_sent_at',
        // pending
        // confirmed
        // Paid
        // completed
        // cancelled
    ];

    // 🔗 Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // 🔗 Merchant (إذا بغيت order لتاجر واحد)
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // 🔗 Order Items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // 🔗 Addresse Order
    public function addresse()
    {
        return $this->hasOne(Addresse::class);
    }

    // 🔗 Payment Order
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // 🔗 Merchant Orders
    public function merchantOrders()
    {
        return $this->hasMany(MerchantOrder::class);
    }

    // 🔗 Invoice
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

}
