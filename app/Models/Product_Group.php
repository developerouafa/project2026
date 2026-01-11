<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'packageproduct_id',
        'quantity',
        'totalprice',
    ];

    /* =========================
            SCOPES
    ========================= */

            // كل العلاقات مرة وحدة
            public function scopeWithAll($query)
            {
                return $query->with([
                    'product_id',
                    'packageproduct_id',
                ]);
            }

            // فقط الأعمدة المهمة
            public function scopeSelectBasic($query)
            {
                return $query->select([
                    'id',
                    'product_id',
                    'packageproduct_id',
                    'quantity',
                    'totalprice',
                    'created_at',
                    'updated_at',
                ]);
            }

            // منتجات لحزمة معينة
            public function scopeByPackageproduct($query, $packageproductId)
            {
                return $query->where('packageproduct_id', $packageproductId);
            }

            public function scopeByProduct($query, $productId)
            {
                return $query->where('product_id', $productId);
            }

    // Relations

            // Product Relation
            public function product()
            {
                return $this->belongsTo(Product::class);
            }

            // Packageproducts Relation
            public function packageproduct()
            {
                return $this->belongsTo(Packageproducts::class);
            }
}
