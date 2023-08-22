<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ReturnsRandomIdModels;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ReturnsRandomIdModels;

    // protected $with = [
    //     'address',
    //     'details'
    // ];

    protected $fillable = [
        'email',
        'password',
        'is_admin',
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

    public function details(){
        return $this->hasOne(UserDetails::class);
    }
}
