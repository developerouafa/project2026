<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Packageproducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'Total_before_discount',
        'discount_value',
        'Total_after_discount',
        'tax_rate',
        'Total_with_tax',
        'merchant_id',
    ];

    /* =========================
           SCOPES
    ========================= */

            // كل العلاقات مرة وحدة
            public function scopeWithAll($query)
            {
                return $query->with([
                    'merchant_id',
                ]);
            }

            // فقط الأعمدة المهمة
            public function scopeSelectBasic($query)
            {
                return $query->select([
                    'id',
                    'name',
                    'notes',
                    'Total_before_discount',
                    'discount_value',
                    'Total_after_discount',
                    'tax_rate',
                    'Total_with_tax',
                    'merchant_id',
                    'created_at',
                    'updated_at',
                ]);
            }

            // جلب الباكيجات الخاصة بتاجر محدد
            public function scopeByMerchant($query, $merchantId)
            {
                return $query->where('merchant_id', $merchantId);
            }

    // Relations

            // Merchant Relation
            public function merchant()
            {
                return $this->belongsTo(Merchant::class);
            }

            // Product_Group Relation
            public function product_groups()
            {
                return $this->hasMany(Product_Group::class, 'packageproduct_id');
            }
}
