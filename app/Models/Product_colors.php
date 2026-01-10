<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product_colors extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'has_variants',
    ];

    protected $dates = ['deleted_at'];


}
