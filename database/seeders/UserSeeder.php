<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Clear permission cache
        app()['cache']->forget('spatie.permission.cache');

        // Define permissions
        $permissions = [
            'manage users',
            'manage roles',
            'view dashboard',
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'process orders',
            'place orders',
            'view own orders',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $sellerRole = Role::firstOrCreate(['name' => 'seller']);
        $sellerRole->givePermissionTo([
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'process orders',
        ]);

        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customerRole->givePermissionTo([
            'place orders',
            'view own orders',
        ]);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@shop.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->assignRole($adminRole);

        // Create seller user
        $seller = User::firstOrCreate(
            ['email' => 'seller@shop.com'],
            [
                'name' => 'Shop Seller',
                'password' => Hash::make('seller123'),
            ]
        );
        $seller->assignRole($sellerRole);

        // Create customer user
        $customer = User::firstOrCreate(
            ['email' => 'customer@shop.com'],
            [
                'name' => 'John Customer',
                'password' => Hash::make('customer123'),
            ]
        );
        $customer->assignRole($customerRole);
    }
}
