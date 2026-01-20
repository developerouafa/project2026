<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Promotions extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'product_id',
        'merchant_id',
        'start_time',
        'end_time',
        'created_at',
        'updated_at'
    ];



    /*-------------------- Scope --------------------*/
    public function scopeSelectpromotion(mixed $query)
    {
        return $query->select('id', 'price', 'expired', 'product_id', 'merchant_id', 'start_time', 'end_time', 'created_at', 'updated_at');
    }

    public function scopeWithpromotion(mixed $query)
    {
        return $query->with('product');
    }

    /*-------------------- Relations --------------------*/

    public function merchant()
    {
        return $this->belongsTo(merchant::class, 'merchant_id');
    }

    public function product()
    {
        return $this->belongsTo(product::class);
    }

}
