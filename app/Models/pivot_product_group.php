<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pivot_product_group extends Model
{
    use HasFactory;
    protected $table = 'Product_Group';

    protected $fillable = [
        'id',
        'product_id',
        'packageproducts_id',
        'quantity'
    ];

    /* =========================
            SCOPES
    ========================= */

            // كل العلاقات مرة وحدة
            public function scopeWithAll($query)
            {
                return $query->with([
                    'product_id',
                    'packageproducts_id',
                ]);
            }

            // فقط الأعمدة المهمة
            public function scopeSelectBasic($query)
            {
                return $query->select([
                    'id',
                    'product_id',
                    'packageproducts_id',
                    'quantity',
                    'totalprice',
                    'created_at',
                    'updated_at',
                ]);
            }

            // منتجات لحزمة معينة
            public function scopeByPackageproduct($query, $packageproductId)
            {
                return $query->where('packageproducts_id', $packageproductId);
            }

            public function scopeByProduct($query, $productId)
            {
                return $query->where('product_id', $productId);
            }

    public function product()
    {
        return $this->BelongsTo(product::class);
    }

    public function packageproduct()
    {
        return $this->BelongsTo(Packageproducts::class);
    }
}
