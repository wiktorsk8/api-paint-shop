<?php

namespace App\Models\Order;

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
        'details',
        'user_id',
        'is_paid',
    ];

    protected function details(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value),
        );
    }

    public function orderedProducts(){
        return $this->hasMany(OrderedProduct::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
