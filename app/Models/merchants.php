<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

class merchants extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens, HasTranslations, HasRoles;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
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

}
