<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'order_id',
        'merchant_id',
        'client_id',
        'subtotal',
        'tax',
        'total',
        'status',
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

    // 🔗 Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
