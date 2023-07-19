<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ReturnsRandomId
{
    private function randomId(string $modelClass): int{
        if (!is_subclass_of($modelClass, Model::class)) {
            throw new \InvalidArgumentException('Invalid model class provided.');
        }

        $model = new $modelClass;

        $ids = $model->select('id')
            ->limit(10)
            ->pluck('id')
            ->toArray();

        return $ids[array_rand($ids)];
    }
}
