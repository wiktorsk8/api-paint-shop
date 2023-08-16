<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_price',
        'description',
        'image',
        'in_stock',
        'discount',
        'discounted_price'
    ];

    
    public function orders(){
        return $this->hasMany(Order::class);
    }

}
