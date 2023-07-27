<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'city',
        'postal_code',
        'street_name',
        'street_number',
        'flat_number',
        'company_name',
        'NIP',
        'extra_info'
    ];

    public function order(){
        return $this->hasOne(Order::class);
    }
}
