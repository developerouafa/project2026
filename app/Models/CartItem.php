<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'package_product_id',
        'color',
        'variant',
        'size',
        'qty',
        'price',
    ];

    // 🔗 Cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // 🔗 Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // 🔗 Package Product
    public function packageProduct()
    {
        return $this->belongsTo(Packageproducts::class, 'package_product_id');
    }

    public function getProductStock()
    {
        $sizeId = Sizes::where('name', $this->size)->value('id');
        if (!$sizeId) return 0;

        $productColorId = Product_colors::where('product_id', $this->product_id)
            ->whereHas('color', function ($q) {
                $q->where('name', $this->color);
            })
            ->value('id');

        if (!$productColorId) return 0;

        return Product_color_sizes::where('product_color_id', $productColorId)
            ->where('size_id', $sizeId)
            ->value('quantity') ?? 0;
    }

    public function getAvailableStock(): int
    {
        return $this->getProductStock(); // كتجيب الستوك الفعلي
    }

    public function isOutOfStock(): bool
    {
        return $this->getAvailableStock() <= 0;
    }
}
