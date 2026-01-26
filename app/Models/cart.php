<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'merchant_id'
    ];

    // 🔗 Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // 🔗 Merchant
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // 🔗 Cart Items
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
