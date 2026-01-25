<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'client_id',
        'amount',
        'method',
        'status',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
        'reference',
        'description',
    ];

    // 🔗 Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
