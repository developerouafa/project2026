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

    /* =========================
            SCOPES
    ========================= */

            // كل العلاقات مرة وحدة
            public function scopeWithAll($query)
            {
                return $query->with([
                    'product_color_id',
                    'size_id',
                ]);
            }

            // فقط الأعمدة المهمة
            public function scopeSelectBasic($query)
            {
                return $query->select([
                    'id',
                    'product_color_id',
                    'size_id',
                    'quantity',
                    'price',
                    'in_stock',
                    'sku',
                    'created_at',
                    'updated_at',
                ]);
            }

            // المنتجات المتوفرة في المخزون
            public function scopeInStock($query)
            {
                return $query->where('in_stock', 1)
                            ->where('quantity', '>', 0);
            }

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
