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

    /* =========================
           SCOPES
    ========================= */

            // كل العلاقات مرة وحدة
            public function scopeWithAll($query)
            {
                return $query->with([
                    'color_variant_id',
                    'size_id',
                ]);
            }

            // فقط الأعمدة المهمة
            public function scopeSelectBasic($query)
            {
                return $query->select([
                    'color_variant_id',
                    'size_id',
                    'quantity',
                    'price',
                    'in_stock',
                    'sku',
                    'created_at',
                    'updated_at'
                ]);
            }

            // جلب جميع Sizes المتوفرة فقط
            public function scopeInStock($query)
            {
                return $query->where('in_stock', 1)->where('quantity', '>', 0);
            }

            public function scopeByColorVariant($query, $colorVariantId)
            {
                return $query->where('color_variant_id', $colorVariantId);
            }

            public function scopeBySize($query, $sizeId)
            {
                return $query->where('size_id', $sizeId);
            }

    // Relations

            public function colorVariant()
            {
                return $this->belongsTo(Color_variants::class);
            }

            public function size()
            {
                return $this->belongsTo(Sizes::class);
            }

            public function promotions()
            {
                return $this->hasMany(Promotions::class, 'color_variant_sizes_id');
            }

}
