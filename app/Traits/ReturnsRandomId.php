<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ReturnsRandomId
{
    private function randomId(string $modelClass, string $idType = null){
        if (!is_subclass_of($modelClass, Model::class)) {
            throw new \InvalidArgumentException('Invalid model class provided.');
        }

        $model = new $modelClass;

        $ids = $model->select('id')
            ->limit(10)
            ->pluck('id')
            ->toArray();

        $result = $ids[array_rand($ids)];
        
        if ($idType == 'uuid') return $result;

        return (int)$result;
    }
}
