<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'package_product_id',
        'color',
        'size',
        'qty',
        'price',
    ];

    // 🔗 Order
    public function order()
    {
        return $this->belongsTo(Order::class);
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
