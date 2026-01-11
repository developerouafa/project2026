<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

class Merchant extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens, HasTranslations, HasRoles;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'email_verified_at',
        'password',
        'image',
        'can_login',
        'account_state',
    ];

    public array $translatable = ['name'];
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* =========================
           SCOPES
    ========================= */

            // فقط الأعمدة المهمة
            public function scopeSelectBasic($query)
            {
                return $query->select([
                    'id',
                    'name',
                    'phone',
                    'email',
                    'email_verified_at',
                    'password',
                    'image',
                    'can_login',
                    'account_state',
                    'created_at',
                    'updated_at',
                ]);
            }

            // جلب التجار المفعلين فقط
            public function scopeActive($query)
            {
                return $query->where('can_login', 1)
                            ->where('account_state', 'active');
            }

            // جلب التجار حسب البريد الإلكتروني
            public function scopeByEmail($query, $email)
            {
                return $query->where('email', $email);
            }

            // جلب التجار الذين لم يتحققوا من البريد الإلكتروني
            public function scopeUnverified($query)
            {
                return $query->whereNull('email_verified_at');
            }

            // جلب التجار الذين يمكنهم تسجيل الدخول فقط
            public function scopeCanLogin($query)
            {
                return $query->where('can_login', 1);
            }

            // جلب التجار حسب حالة الحساب (مثلاً active, suspended, closed)
            public function scopeByAccountState($query, $state)
            {
                return $query->where('account_state', $state);
            }

    /* =========================
           RELATIONS
    ========================= */

            // Products Relation
            public function products()
            {
                return $this->hasMany(Product::class);
            }

            // Packageproducts Relation
            public function packageproducts()
            {
                return $this->hasMany(Packageproducts::class);
            }
}
