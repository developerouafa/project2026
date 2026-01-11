<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'section_id',
        'parent_id',
        'merchant_id',
        'quantity',
        'in_stock',
        'price',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];

    public $translatable = ['name', 'description'];

    /* =========================
            SCOPES
    ========================= */

            // كل العلاقات مرة وحدة
            public function scopeWithAll($query)
            {
                return $query->with([
                    'merchant',
                    'section',
                    'subsections',
                    'images',
                    'productColors',
                    'colors',
                    'product_groups',
                ]);
            }

            // فقط الأعمدة المهمة
            public function scopeSelectBasic($query)
            {
                return $query->select([
                    'id',
                    'name',
                    'description',
                    'image',
                    'status',
                    'section_id',
                    'parent_id',
                    'merchant_id',
                    'quantity',
                    'in_stock',
                    'price',
                    'created_at',
                ]);
            }

            // المنتجات الرئيسية (ماشي sub product)
            public function scopeParent($query)
            {
                return $query->whereNull('parent_id');
            }

            // المنتجات الفرعية (variants)
            public function scopeChild($query)
            {
                return $query->whereNotNull('parent_id');
            }

            // فقط المنتجات المفعلة
            public function scopeActive($query)
            {
                return $query->where('status', 1);
            }

            // المنتجات المتوفرة في المخزون
            public function scopeInStock($query)
            {
                return $query->where('in_stock', 1)
                            ->where('quantity', '>', 0);
            }

            // منتجات تاجر معين
            public function scopeByMerchant($query, $merchantId)
            {
                return $query->where('merchant_id', $merchantId);
            }
        /*-------------------- Relations --------------------*/

        // Merchant Relation
        public function merchant()
        {
            return $this->belongsTo(Merchant::class);
        }

        // Section Relation
        public function subsections(): BelongsTo
        {
            return $this->BelongsTo(Sections::class, 'parent_id')->child();
        }

        public function section(): BelongsTo
        {
            return $this->BelongsTo(Sections::class);
        }

        // Multi Images Relation
        public function images()
        {
            return $this->hasMany(Multi_image_pr::class, 'product_id');
        }

        // Product Colors Relation
        public function productColors()
        {
            return $this->hasMany(Product_colors::class);
        }

        //  Colors Relation
        public function colors()
        {
            return $this->belongsToMany(Colors::class, 'product_colors')
                        ->withPivot('has_variants')
                        ->withTimestamps();
        }

        // Product_Groups Relation
        public function product_groups()
        {
            return $this->hasMany(Product_Group::class);
        }

}
