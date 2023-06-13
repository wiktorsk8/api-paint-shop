<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Product::factory(10)->create();

        // Seed premisstions
        $this->call(OrderPermissionsSeeder::class);
        $this->call(ProductPermissionsSeeder::class);

        // Create customer role and assign permissions
        $customerRole = Role::create(['name' => 'customer']);

        $customerRole->syncPermissions([
            'view product',
            'view order'
            ]);

        $this->seedAdmin();

        $this->call(AddressSeeder::class);
        $this->call(OrderSeeder::class);

    }

    private function seedAdmin(){
        $adminRole = Role::create(['name' => 'admin']);

        $adminRole->syncPermissions([
            // products
            'view any product',
            'view product',
            'create product',
            'edit product',
            'delete product',
            'store product',
            // orders
            'view any order',
            'view order',
            'create order',
            'edit order',
            'delete order',
            'store order'
        ]);

        $adminUser = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '123456789', // password
            'remember_token' => Str::random(10),
        ]);

        $adminUser->assignRole('admin');
    }
}
