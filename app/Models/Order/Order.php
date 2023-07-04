<?php

namespace App\Models\Order;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $with = [
        'product',
        'address',
        'customer',
        'credentials',
        'state'
    ];
    protected $fillable = [
        'product_id',
        'customer_address_id',
        'customer_id',
        'user_credentials'
    ];


    public function credentials(){
        return $this->belongsTo(Credentials::class, 'user_credentials');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }


    public function address(){
        return $this->belongsTo(Address::class, 'customer_address_id');
    }


    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function state(){
        return $this->hasOne(State::class, 'order_id');
    }

}
