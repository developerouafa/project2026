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
                    'multiImages'
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

            // Product Colors Relation
            public function productColors()
            {
                return $this->hasMany(Product_colors::class);
            }

            public function product_colors()
            {
                return $this->hasMany(Product_colors::class);
            }

            //  Colors Relation
            public function colors()
            {
                return $this->belongsToMany(
                    Colors::class,
                    'product_colors',
                    'product_id', // foreign key على جدول Product_colors
                    'color_id'    // foreign key على جدول Colors
                )
                ->withPivot('has_variants')
                ->withTimestamps();
            }

            // Product_Groups Relation
            public function product_groups()
            {
                return $this->hasMany(pivot_product_group::class);
            }

            // Multi images
            public function multiImages()
            {
                return $this->hasMany(Multi_image_pr::class, 'product_id');
            }

            // Ratings
            public function ratings()
            {
                return $this->hasMany(Rating::class);
            }

            // ⭐ حساب متوسط التقييم يدوياً
            public function getAverageRatingAttribute()
            {
                if ($this->ratings_count == 0) {
                    return 0;
                }

                return round($this->ratings_sum_stars / $this->ratings_count, 1);
            }


            // Promotions
            public function promotions()
            {
                return $this->hasMany(Promotions::class);
            }

            // 🔹 تخفيض فعال دابا
            public function currentPromotion()
            {
                return $this->hasOne(Promotions::class)
                            ->where('start_time', '<=', now())
                            ->where('end_time', '>=', now());
            }

            // 🔹 السعر بعد التخفيض
            public function priceAfterPromotion()
            {
                if ($this->currentPromotion) {
                    return $this->currentPromotion->price;
                }
                return $this->price; // السعر العادي
            }

            /**
             * الحصول على السعر النهائي للمنتج
             */
            public function finalPrice()
            {
                // 1️⃣ إذا المنتج عنده ألوان
                if ($this->colors()->exists()) {

                    // نجيب أول لون + أول variant + أول size
                    $firstColor = $this->colors()->first();
                    if (!$firstColor) return $this->price; // fallback للسعر العادي

                    $firstProductColor = $this->productColors()->where('color_id', $firstColor->id)->first();
                    if (!$firstProductColor) return $this->price;

                    // 2️⃣ إذا عندو variant sizes
                    $variantSize = $firstProductColor->variants()
                                        ->with('sizes')
                                        ->first()?->sizes()
                                        ->first();

                    if ($variantSize) {
                        return $variantSize->price;
                    }

                    // 3️⃣ fallback: سعر Product_color_sizes بدون variant
                    $colorSize = $firstProductColor->sizes()->first();
                    if ($colorSize) {
                        return $colorSize->price;
                    }

                    // fallback للسعر العادي
                    return $this->price;
                }

                // 2️⃣ إذا المنتج بدون ألوان
                $productSize = $this->product_colors()->with('sizes')->first()?->sizes()->first();
                if ($productSize) {
                    return $productSize->price;
                }

                // fallback للسعر العادي
                return $this->price;
            }

            public function finalQuantity()
            {
                // 🟢 إذا المنتج عنده ألوان
                if ($this->colors()->exists()) {

                    // أول لون
                    $firstColor = $this->colors()->first();
                    if (!$firstColor) {
                        return $this->quantity;
                    }

                    // product_color
                    $productColor = $this->productColors()
                        ->where('color_id', $firstColor->id)
                        ->first();

                    if (!$productColor) {
                        return $this->quantity;
                    }

                    // 🟢 إذا عنده variants
                    if ($productColor->variants()->exists()) {

                        $variantSize = $productColor->variants()
                            ->with('sizes')
                            ->first()
                            ?->sizes()
                            ->first();

                        if ($variantSize) {
                            return $variantSize->quantity;
                        }
                    }

                    // 🟢 بدون variants → sizes مباشرة
                    $colorSize = $productColor->sizes()->first();
                    if ($colorSize) {
                        return $colorSize->quantity;
                    }

                    // fallback
                    return $this->quantity;
                }

                // 🟢 إذا المنتج بدون ألوان ولكن عنده sizes مباشرة
                $size = $this->productColors()
                    ->with('sizes')
                    ->first()
                    ?->sizes()
                    ->first();

                if ($size) {
                    return $size->quantity;
                }

                // 🟢 fallback النهائي
                return $this->quantity;
            }


            public function scopeByMainColor($query, $colorId)
            {
                return $query->whereHas('productColors', function ($q) use ($colorId) {
                    $q->where('color_id', $colorId);
                });
            }

            public function scopeWithoutColors($query)
            {
                return $query->whereDoesntHave('productColors');
            }

            public function scopeBySize($query, $sizeId)
            {
                return $query->where(function ($q) use ($sizeId) {

                    // 🔹 مقاسات بلا variants
                    $q->whereHas('productColors.productColorSizes', function ($qq) use ($sizeId) {
                        $qq->where('size_id', $sizeId)
                        ->where('in_stock', 1)
                        ->where('quantity', '>', 0);
                    })

                    // 🔹 مقاسات مع variants
                    ->orWhereHas('productColors.colorVariants.colorVariantSizes', function ($qq) use ($sizeId) {
                        $qq->where('size_id', $sizeId)
                        ->where('in_stock', 1)
                        ->where('quantity', '>', 0);
                    });

                });
            }



            public function getAvailableSizes()
            {
                $available = [];

                foreach ($this->productColors as $productColor) {

                    // إذا المنتج عنده variant
                    if($productColor->has_variants) {
                        foreach($productColor->variants as $variant){
                            foreach($variant->sizes as $size){
                                if($size->in_stock > 0){
                                    $available[$productColor->color->name]['variants'][$variant->name][] = [
                                        'size' => $size->size->name,
                                        'price' => $size->price,
                                        'quantity' => $size->quantity,
                                    ];
                                }
                            }
                        }
                    }
                    // إذا المنتج بدون variant
                    else {
                        foreach($productColor->sizes as $size){
                            if($size->in_stock > 0){
                                $available[$productColor->color->name]['sizes'][] = [
                                    'size' => $size->size->name,
                                    'price' => $size->price,
                                    'quantity' => $size->quantity,
                                ];
                            }
                        }
                    }
                }

                return $available; // مصفوفة: اللون → variant → sizes
            }


            public function getTotalQtyProperty()
            {
                return array_sum($this->selected);
            }

            public function getTotalPriceProperty()
            {
                $total = 0;

                foreach ($this->selected as $key => $qty) {
                    [$color, $variant, $size] = array_pad(explode('|', $key), 3, null);

                    // هنا جيب السعر من DB حسب size الحقيقي
                    $price = 100; // مثال
                    $total += $price * $qty;
                }

                return $total;
            }



            // package
            public function packages()
            {
                return $this->belongsToMany(
                    Packageproducts::class,
                    'Product_Group',
                    'product_id',
                    'packageproducts_id'
                )->withPivot('quantity');
            }

}
