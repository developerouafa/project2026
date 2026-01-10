<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Multi_image_pr extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $table = 'multi_image_prs';

    protected $fillable = [
        'multi_image',
        'product_id',
    ];

    // علاقة الصورة مع المنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
