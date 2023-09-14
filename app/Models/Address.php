<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'street',
        'building_number',
        'city',
        'postal_code',
        'country_code',
        'extra_info',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
