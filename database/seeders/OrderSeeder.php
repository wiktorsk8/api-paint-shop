<?php

namespace Database\Seeders;

use App\Models\Order\Order;
use Illuminate\Database\Seeder;


class OrderSeeder extends Seeder
{

    public function run(): void
    {
        Order::factory(5)->create();
    }
}
