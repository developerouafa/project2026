<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class color_variants extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'code',
        'product_color_id',
    ];

    protected $dates = ['deleted_at'];

    public $translatable = ['name'];

    // Relations
    public function productColor()
    {
        return $this->belongsTo(Product_colors::class, 'product_color_id');
    }

}
