<?php

namespace App\Enums;

enum OrderStatusEnum: string {
    case Preparation = 'preparation';
    case Delivery = 'delivery';
    case Delivered = 'delivered';
    case Canceled = 'canceled';
}
