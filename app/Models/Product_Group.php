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
