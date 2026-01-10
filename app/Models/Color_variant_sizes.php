<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color_variant_sizes extends Model
{
    use HasFactory;

    protected $fillable = [
        'color_variant_id',
        'size_id',
        'quantity',
        'price',
        'in_stock',
        'sku',
    ];

    // Relations
    public function colorVariant()
    {
        return $this->belongsTo(Color_variants::class);
    }

    public function size()
    {
        return $this->belongsTo(Sizes::class);
    }

}
