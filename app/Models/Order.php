<?php

namespace App\Models;

use App\Models\OrderedProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $with = [
        'user',
        'orderedProducts',
    ];
    protected $fillable = [
        'order_details_id',
        'user_id',
        'is_paid',
    ];

    public function orderedProducts(){
        return $this->hasMany(OrderedProduct::class);
    }

    public function orderDetails(){
        return $this->hasOne(OrderDetailsModel::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
