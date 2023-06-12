<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $with = [
        'product',
        'address',
        'customer'
    ];


    protected $fillable = [
        'product_id',
        'customer_address_id',
        'customer_id'
    ];


    public function product(){
        return $this->belongsTo(Product::class);
    }


    public function address(){
        return $this->belongsTo(Address::class);
    }


    public function customer(){
        return $this->belongsTo(User::class, 'custom_user_id');
    }

}
