<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Order\Address;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ReturnsRandomIdModels;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ReturnsRandomIdModels;


    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function address(){
        return $this->hasOne(Address::class);
    }
}
