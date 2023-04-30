<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'password',
        'google2fa_secret',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    public function getGoogle2faSecretAttribute($value)
    {
        if(strlen($value) >= 100)
        {
            return decrypt($value);
        }
        else
        {
            return $value;
        }
    }

    public function setGoogle2faSecretAttribute($value)
    {
        if(strlen($value) >= 100)
        {
            $this->attributes['google2fa_secret'] = encrypt($value);
        }
        else
        {
            $this->attributes['google2fa_secret'] = $value;
        }
    }

}
