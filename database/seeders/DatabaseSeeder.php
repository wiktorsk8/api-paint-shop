<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\AddressSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OrderedProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Product::factory(10)->create();

        User::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('123123123'),
            'is_admin' => true
        ]);
        
        $this->call(AddressSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderedProductSeeder::class);
        \App\Models\UserDetails::factory(5)->create();
    }

}
