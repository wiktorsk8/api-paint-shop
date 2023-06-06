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

        // Create permissions
        Permission::create(['name' => 'view product']);
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'edit product']);
        Permission::create(['name' => 'delete product']);
        Permission::create(['name' => 'store product']);

        // Create admin roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);

        $adminRole->syncPermissions([
            'view product',
            'create product',
            'edit product',
            'delete product',
            'store product'
        ]);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '123456789', // password
            'remember_token' => Str::random(10),
        ]);

        $user->assignRole('admin');

        // Create user roles and assign permissions
        $userRole = Role::create(['name' => 'user']);

        $userRole->givePermissionTo('view product');
    }
}
