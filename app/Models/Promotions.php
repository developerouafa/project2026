<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Promotions extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'amount',
        'percent',
        'start_date',
        'end_date',
        'status',
        'product_color_sizes_id',
        'color_variant_sizes_id',
        'created_at',
        'updated_at'
    ];

    // relations
    public function productColorSize()
    {
        return $this->belongsTo(Product_color_sizes::class, 'product_color_sizes_id');
    }

    public function colorVariantSize()
    {
        return $this->belongsTo(Color_variant_sizes::class, 'color_variant_sizes_id');
    }
}
