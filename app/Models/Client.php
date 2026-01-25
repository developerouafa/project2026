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

class Client extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, HasTranslations, HasRoles;

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

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function Addresse() // ✅ plural and lowercase
    {
        return $this->hasMany(Addresse::class);
    }
}
