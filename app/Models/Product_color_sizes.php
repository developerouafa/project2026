<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_color_sizes extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_color_id',
        'size_id',
        'quantity',
        'price',
        'in_stock',
        'sku',
    ];

    // Relations

    public function productColor()
    {
        return $this->belongsTo(Product_colors::class);
    }

    public function size()
    {
        return $this->belongsTo(Sizes::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotions::class, 'product_color_sizes_id');
    }
}
