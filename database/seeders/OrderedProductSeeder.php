<?php

namespace Database\Seeders;

use App\Models\OrderedProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderedProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderedProduct::factory(5)->create();
    }
}
