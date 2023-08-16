<?php

namespace App\Enums;

enum OrderStateEnum: string {
    case Placed = 'placed';
    case Preparation = 'preparation';
    case Delivery = 'delivery';
    case Delivered = 'delivered';
    case Canceled = 'canceled';

    public static function randomValue(){
        $values = array_column(self::cases(), 'value');

        return $values[array_rand($values)];
    }
}
