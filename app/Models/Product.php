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
        'size',
        'in_stock',
        'year',
        'technique'
    ];

    
    public function orders(){
        return $this->hasMany(Order::class);
    }

}
