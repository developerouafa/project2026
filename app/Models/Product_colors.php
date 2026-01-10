<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Symfony\Component\Console\Color;

class Product_colors extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'has_variants',
    ];

    protected $dates = ['deleted_at'];

    // Relations
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function colors()
    {
        return $this->belongsTo(Colors::class);
    }

    public function variants()
    {
        return $this->hasMany(Color_variants::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Sizes::class, 'product_color_sizes')
                    ->withPivot('sku')
                    ->withTimestamps();
    }
}
