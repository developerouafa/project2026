<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Packageproducts extends Model
{
    use HasFactory, HasTranslations;

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

    public $translatable = ['name'];

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
