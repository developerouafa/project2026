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

    /* =========================
           SCOPES
    ========================= */

            // Eager load كل العلاقات
            public function scopeWithAll($query)
            {
                return $query->with(['product', 'color']);
            }

            // اختيار الأعمدة الأساسية فقط
            public function scopeSelectBasic($query)
            {
                return $query->select(['id', 'product_id', 'color_id', 'has_variants', 'created_at', 'updated_at']);
            }

            // Scope لكل المنتجات ديال color معين
            public function scopeByColor($query, $colorId)
            {
                return $query->where('color_id', $colorId);
            }

            // Scope لكل الألوان لمنتج معين
            public function scopeByProduct($query, $productId)
            {
                return $query->where('product_id', $productId);
            }

            // Scope للمنتجات اللي عندها variants
            public function scopeWithVariants($query)
            {
                return $query->where('has_variants', 1);
            }

            // Scope للمنتجات اللي ماعندهاش variants
            public function scopeWithoutVariants($query)
            {
                return $query->where('has_variants', 0);
            }


    // Relations
            public function product()
            {
                return $this->belongsTo(Product::class);
            }

            public function colors()
            {
                return $this->belongsTo(Colors::class);
            }

            public function color()
            {
                return $this->belongsTo(Colors::class, 'color_id');
            }

            public function variants()
            {
                return $this->hasMany(Color_variants::class,
                        'product_color_id');
            }

            public function sizes()
            {
                return $this->belongsToMany(
                    Sizes::class,           // Model المرتبط
                    'product_color_sizes',  // اسم جدول pivot
                    'product_color_id',     // العمود اللي يشير لـ Product_colors
                    'size_id'               // العمود اللي يشير لـ Sizes
                )
                ->withPivot(['quantity', 'price', 'in_stock', 'sku'])
                ->withTimestamps();
            }

            public function productColorSizes()
            {
                return $this->hasMany(Product_color_sizes::class, 'product_color_id');
            }

            public function colorVariants()
            {
                return $this->hasMany(Color_variants::class, 'product_color_id');
            }


}
