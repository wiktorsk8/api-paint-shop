<?php

namespace Tests;

use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function __get($name)
    {
        if ($name === 'faker'){
            return Factory::create();
        }

        throw new Exception('Invalid name requested.');
    }
}
