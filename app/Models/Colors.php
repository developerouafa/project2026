<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Colors extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    /* =========================
           SCOPES
    ========================= */

        // اختيار الأعمدة الأساسية فقط
        public function scopeSelectBasic($query)
        {
            return $query->select(['id', 'name', 'code', 'created_at', 'updated_at']);
        }

    // Relations

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
