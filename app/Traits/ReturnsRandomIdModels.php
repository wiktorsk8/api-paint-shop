<?php

namespace App\Traits;

trait ReturnsRandomIdModels
{
    public static function randomId(): int{
        $ids = self::select('id')
        ->limit(10)
        ->pluck('id')
        ->toArray();

        return $ids[array_rand($ids)];
    }
}
