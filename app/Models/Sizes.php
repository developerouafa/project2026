<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Color;

class Sizes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Relations
    public function productColors()
    {
        return $this->belongsToMany(Product_colors::class, 'product_color_sizes')
                    ->withPivot('sku')
                    ->withTimestamps();
    }

    public function colorVariants()
    {
        return $this->belongsToMany(color_variants::class, 'color_variant_sizes')
                    ->withPivot('sku')
                    ->withTimestamps();
    }
}
