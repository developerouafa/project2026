<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
