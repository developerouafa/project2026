<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Colors extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = [
        'name',
        'code',
    ];

    protected $dates = ['deleted_at'];

    public function productColors()
    {
        return $this->hasMany(Product_colors::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_colors')
                    ->withPivot('has_variants')
                    ->withTimestamps();
    }
}
