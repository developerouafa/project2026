<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresse extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',     // الربط مع العميل
        'order_id',     // الربط مع الطلبية
        'title',         // عنوان مثل: "المنزل" أو "العمل"
        'street',        // الشارع
        'city',          // المدينة
        'state',         // الولاية أو المنطقة
        'postal_code',   // الرمز البريدي
        'country',       // الدولة
        'phone',         // رقم الهاتف إذا كان مختلف
        'default',       // boolean إذا كان هذا العنوان الافتراضي
    ];

    protected $casts = [
        'default' => 'boolean',
    ];

    // 🔗 العلاقة مع العميل
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // 🔗 العلاقة مع الطلبية
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
