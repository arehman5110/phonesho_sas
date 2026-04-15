<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- Create Permissions ---
        $permissions = [
            // Repairs
            'view repairs', 'create repairs', 'edit repairs', 'delete repairs',
            // Sales
            'view sales', 'create sales', 'edit sales', 'delete sales',
            // Products
            'view products', 'create products', 'edit products', 'delete products',
            // Customers
            'view customers', 'create customers', 'edit customers', 'delete customers',
            // Buy & Sell
            'view buy_sell', 'create buy_sell', 'edit buy_sell', 'delete buy_sell',
            // Vouchers
            'view vouchers', 'create vouchers', 'edit vouchers', 'delete vouchers',
            // Reports
            'view reports',
            // Settings
            'view settings', 'edit settings',
            // Users
            'view users', 'create users', 'edit users', 'delete users',
            // Shops
            'view shops', 'create shops', 'edit shops', 'delete shops',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // --- Create Roles & Assign Permissions ---

        // Staff — limited access
        $staff = Role::firstOrCreate(['name' => 'staff']);
        $staff->syncPermissions([
            'view repairs', 'create repairs', 'edit repairs',
            'view sales', 'create sales',
            'view products',
            'view customers', 'create customers', 'edit customers',
            'view buy_sell', 'create buy_sell',
        ]);

        // Shop Admin — full shop access
        $shopAdmin = Role::firstOrCreate(['name' => 'shop_admin']);
        $shopAdmin->syncPermissions([
            'view repairs', 'create repairs', 'edit repairs', 'delete repairs',
            'view sales', 'create sales', 'edit sales', 'delete sales',
            'view products', 'create products', 'edit products', 'delete products',
            'view customers', 'create customers', 'edit customers', 'delete customers',
            'view buy_sell', 'create buy_sell', 'edit buy_sell', 'delete buy_sell',
            'view vouchers', 'create vouchers', 'edit vouchers', 'delete vouchers',
            'view reports',
            'view settings', 'edit settings',
            'view users', 'create users', 'edit users',
        ]);

        // Super Admin — everything
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->syncPermissions(Permission::all());

        $this->command->info('✅ Roles and permissions seeded successfully!');
    }
}