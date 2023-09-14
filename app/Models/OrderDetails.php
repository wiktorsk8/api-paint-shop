<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'building_number',
        'city',
        'postal_code',
        'first_name',
        'last_name',
        'phone',
        'email',
        'company_name',
        'NIP',
        'extra_info'
    ];

    public function order(){
        return $this->hasOne(Order::class);
    }
}
