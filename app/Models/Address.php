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
        'city',
        'postal_code',
        'street_name',
        'street_number',
        'flat_number',
        'company_name',
        'NIP',
        'extra_info'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
