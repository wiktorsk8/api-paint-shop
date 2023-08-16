<?php

namespace App\Models;

use App\Enums\OrderStateEnum;
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

    protected $cast = [
        'is_paid' => 'boolean',
        'state' => OrderStateEnum::class
    ];

    public function orderedProducts(){
        return $this->hasMany(OrderedProduct::class, 'order_id');
    }

    public function orderDetails(){
        return $this->belongsTo(OrderDetails::class, 'order_details_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
