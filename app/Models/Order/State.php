<?php

namespace App\Models\Order;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class State extends Model
{
    use HasFactory;

    protected $table = 'order_states';

    protected $fillable = [
        'order_id',
        'value'
    ];

    protected $casts = [
        'value' => OrderStatusEnum::class
    ];

    protected function value(): Attribute{
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }

}
