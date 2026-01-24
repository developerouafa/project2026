<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'client_id',
        'invoice_id',
        'payment_id',
        'debit',
        'credit',
        'source',
    ];

    // 🔗 Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
