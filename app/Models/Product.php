<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'section_id',
        'parent_id',
        'merchant_id',
        'quantity',
        'in_stock',
        'price',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];

    public $translatable = ['name', 'description'];


        /*-------------------- Relations --------------------*/

        public function merchant()
        {
            return $this->belongsTo(Merchant::class);
        }

        public function subsections(): BelongsTo
        {
            return $this->BelongsTo(Sections::class, 'parent_id')->child();
        }

        public function section(): BelongsTo
        {
            return $this->BelongsTo(Sections::class);
        }




}
