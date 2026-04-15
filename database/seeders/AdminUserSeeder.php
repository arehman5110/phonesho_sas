<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@phoneshop.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $superAdmin->assignRole('super_admin');

        // Shop Admin
        $shopAdmin = User::firstOrCreate(
            ['email' => 'shopadmin@phoneshop.com'],
            [
                'name'     => 'Shop Admin',
                'password' => Hash::make('password'),
            ]
        );
        $shopAdmin->assignRole('shop_admin');

        // Staff
        $staff = User::firstOrCreate(
            ['email' => 'staff@phoneshop.com'],
            [
                'name'     => 'Staff Member',
                'password' => Hash::make('password'),
            ]
        );
        $staff->assignRole('staff');

        $this->command->info('✅ Admin users seeded successfully!');
        $this->command->table(
            ['Name', 'Email', 'Role', 'Password'],
            [
                ['Super Admin', 'superadmin@phoneshop.com', 'super_admin', 'password'],
                ['Shop Admin',  'shopadmin@phoneshop.com',  'shop_admin',  'password'],
                ['Staff',       'staff@phoneshop.com',      'staff',       'password'],
            ]
        );
    }
}