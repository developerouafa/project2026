<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;

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
                    'parent',
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
                    'updated_at',
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

            public function scopeBySection($query, $sectionId)
            {
                return $query->where('section_id', $sectionId);
            }

            public function scopeByParent($query, $parentId)
            {
                return $query->where('parent_id', $parentId);
            }

            public function scopeByStatus($query, $status)
            {
                return $query->where('status', $status);
            }

            public function scopePriceBetween($query, $minPrice, $maxPrice)
            {
                return $query->whereBetween('price', [$minPrice, $maxPrice]);
            }

            public function scopeSearchByName($query, $name)
            {
                return $query->where('name', 'LIKE', "%$name%");
            }

            public function scopeSearchByDescription($query, $description)
            {
                return $query->where('description', 'LIKE', "%$description%");
            }

            public function scopePriceGreaterThan($query, $price)
            {
                return $query->where('price', '>', $price);
            }

            public function scopePriceLessThan($query, $price)
            {
                return $query->where('price', '<', $price);
            }

            public function scopeRecentlyAdded($query)
            {
                return $query->orderBy('created_at', 'desc');
            }

            public function scopeOldestFirst($query)
            {
                return $query->orderBy('created_at', 'asc');
            }

        /*-------------------- Relations --------------------*/

            // Merchant Relation
            public function merchant()
            {
                return $this->belongsTo(Merchant::class);
            }

            public function section()
            {
                return $this->belongsTo(Sections::class, 'section_id');
            }

            public function parent()
            {
                return $this->belongsTo(Sections::class, 'parent_id');
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
