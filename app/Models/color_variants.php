<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class color_variants extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'product_color_id',
    ];

    protected $dates = ['deleted_at'];

    /* =========================
           SCOPES
    ========================= */

        // Scope لجلب كل الفاريانتز لمنتج لون معين
        public function scopeByProductColor($query, $productColorId)
        {
            return $query->where('product_color_id', $productColorId);
        }

        // Scope لجلب كل الفاريانتز بلون محدد
        public function scopeByColorCode($query, $code)
        {
            return $query->where('code', $code);
        }

    // Relations
    public function productColor()
    {
        return $this->belongsTo(Product_colors::class, 'product_color_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Sizes::class, 'color_variant_sizes')
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
