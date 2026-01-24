<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'client_id',
        'amount',
        'method',
        'reference',
        'description',
    ];

    // 🔗 Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
