<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Customer;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // -----------------------------------------------
        // 1. Create Test Shop
        // -----------------------------------------------
        $shop = Shop::firstOrCreate(
            ['slug' => 'main-shop'],
            [
                'name'            => 'PhoneShop Main',
                'phone'           => '07700 900000',
                'email'           => 'main@phoneshop.com',
                'address'         => '123 High Street',
                'city'            => 'London',
                'country'         => 'UK',
                'currency'        => 'GBP',
                'currency_symbol' => '£',
                'is_active'       => true,
            ]
        );

        $this->command->info("✅ Shop created: {$shop->name}");

        // -----------------------------------------------
        // 2. Assign All Users to Shop
        // -----------------------------------------------
        $users = User::all();
        foreach ($users as $user) {
            $shop->users()->syncWithoutDetaching([
                $user->id => [
                    'is_active' => true,
                    'role'      => $user->getRoleNames()->first(),
                ]
            ]);

            // Set active shop
            $user->update(['active_shop_id' => $shop->id]);
        }

        $this->command->info("✅ All users assigned to shop");

        // -----------------------------------------------
        // 3. Create Categories
        // -----------------------------------------------
        $categories = [
            ['name' => 'Screen Protectors', 'slug' => 'screen-protectors'],
            ['name' => 'Phone Cases',        'slug' => 'phone-cases'],
            ['name' => 'Cables & Chargers',  'slug' => 'cables-chargers'],
            ['name' => 'Repair Parts',       'slug' => 'repair-parts'],
            ['name' => 'Accessories',        'slug' => 'accessories'],
            ['name' => 'Second Hand Phones', 'slug' => 'second-hand-phones'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[$cat['slug']] = Category::firstOrCreate(
                ['shop_id' => $shop->id, 'slug' => $cat['slug']],
                [
                    'name'      => $cat['name'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info("✅ " . count($categories) . " categories created");

        // -----------------------------------------------
        // 4. Create Brands
        // -----------------------------------------------
        $brands = [
            ['name' => 'Apple',   'slug' => 'apple'],
            ['name' => 'Samsung', 'slug' => 'samsung'],
            ['name' => 'Google',  'slug' => 'google'],
            ['name' => 'OnePlus', 'slug' => 'oneplus'],
            ['name' => 'Xiaomi',  'slug' => 'xiaomi'],
            ['name' => 'Generic', 'slug' => 'generic'],
        ];

        $createdBrands = [];
        foreach ($brands as $brand) {
            $createdBrands[$brand['slug']] = Brand::firstOrCreate(
                ['shop_id' => $shop->id, 'slug' => $brand['slug']],
                [
                    'name'      => $brand['name'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info("✅ " . count($brands) . " brands created");

        // -----------------------------------------------
        // 5. Create Products
        // -----------------------------------------------
        $products = [

            // Screen Protectors
            [
                'category' => 'screen-protectors',
                'brand'    => 'apple',
                'name'     => 'iPhone 15 Pro Tempered Glass',
                'sku'      => 'SP-IP15P-TG',
                'cost'     => 2.50,
                'price'    => 9.99,
                'stock'    => 50,
                'alert'    => 10,
            ],
            [
                'category' => 'screen-protectors',
                'brand'    => 'samsung',
                'name'     => 'Samsung S24 Ultra Screen Protector',
                'sku'      => 'SP-S24U-TG',
                'cost'     => 2.00,
                'price'    => 8.99,
                'stock'    => 35,
                'alert'    => 10,
            ],
            [
                'category' => 'screen-protectors',
                'brand'    => 'generic',
                'name'     => 'Universal Matte Screen Protector',
                'sku'      => 'SP-UNI-MT',
                'cost'     => 1.00,
                'price'    => 4.99,
                'stock'    => 100,
                'alert'    => 20,
            ],

            // Phone Cases
            [
                'category' => 'phone-cases',
                'brand'    => 'apple',
                'name'     => 'iPhone 15 Clear Case',
                'sku'      => 'PC-IP15-CLR',
                'cost'     => 3.00,
                'price'    => 14.99,
                'stock'    => 25,
                'alert'    => 5,
            ],
            [
                'category' => 'phone-cases',
                'brand'    => 'apple',
                'name'     => 'iPhone 14 Silicone Case',
                'sku'      => 'PC-IP14-SIL',
                'cost'     => 4.00,
                'price'    => 19.99,
                'stock'    => 20,
                'alert'    => 5,
            ],
            [
                'category' => 'phone-cases',
                'brand'    => 'samsung',
                'name'     => 'Samsung S24 Leather Wallet Case',
                'sku'      => 'PC-S24-LTH',
                'cost'     => 5.00,
                'price'    => 24.99,
                'stock'    => 15,
                'alert'    => 5,
            ],
            [
                'category' => 'phone-cases',
                'brand'    => 'generic',
                'name'     => 'Shockproof Heavy Duty Case',
                'sku'      => 'PC-HD-BLK',
                'cost'     => 3.50,
                'price'    => 12.99,
                'stock'    => 4,  // Low stock
                'alert'    => 5,
            ],

            // Cables & Chargers
            [
                'category' => 'cables-chargers',
                'brand'    => 'apple',
                'name'     => 'USB-C to Lightning Cable 1m',
                'sku'      => 'CC-USBC-LTN',
                'cost'     => 3.00,
                'price'    => 12.99,
                'stock'    => 40,
                'alert'    => 10,
            ],
            [
                'category' => 'cables-chargers',
                'brand'    => 'generic',
                'name'     => 'USB-C Cable 2m Braided',
                'sku'      => 'CC-USBC-2M',
                'cost'     => 2.00,
                'price'    => 7.99,
                'stock'    => 60,
                'alert'    => 15,
            ],
            [
                'category' => 'cables-chargers',
                'brand'    => 'samsung',
                'name'     => '65W Super Fast Charger',
                'sku'      => 'CC-65W-SFC',
                'cost'     => 8.00,
                'price'    => 29.99,
                'stock'    => 0,  // Out of stock
                'alert'    => 5,
            ],
            [
                'category' => 'cables-chargers',
                'brand'    => 'generic',
                'name'     => 'Wireless Charging Pad 15W',
                'sku'      => 'CC-WCP-15W',
                'cost'     => 6.00,
                'price'    => 19.99,
                'stock'    => 18,
                'alert'    => 5,
            ],

            // Repair Parts
            [
                'category' => 'repair-parts',
                'brand'    => 'apple',
                'name'     => 'iPhone 13 LCD Screen Assembly',
                'sku'      => 'RP-IP13-LCD',
                'cost'     => 45.00,
                'price'    => 89.99,
                'stock'    => 8,
                'alert'    => 3,
            ],
            [
                'category' => 'repair-parts',
                'brand'    => 'apple',
                'name'     => 'iPhone 12 Battery 2815mAh',
                'sku'      => 'RP-IP12-BAT',
                'cost'     => 12.00,
                'price'    => 29.99,
                'stock'    => 15,
                'alert'    => 5,
            ],
            [
                'category' => 'repair-parts',
                'brand'    => 'samsung',
                'name'     => 'Samsung S21 OLED Screen',
                'sku'      => 'RP-S21-OLED',
                'cost'     => 55.00,
                'price'    => 99.99,
                'stock'    => 5,
                'alert'    => 3,
            ],
            [
                'category' => 'repair-parts',
                'brand'    => 'generic',
                'name'     => 'Repair Tool Kit 25-in-1',
                'sku'      => 'RP-TLK-25',
                'cost'     => 8.00,
                'price'    => 19.99,
                'stock'    => 10,
                'alert'    => 3,
            ],

            // Accessories
            [
                'category' => 'accessories',
                'brand'    => 'generic',
                'name'     => 'Pop Socket Phone Grip',
                'sku'      => 'AC-POP-GRP',
                'cost'     => 1.50,
                'price'    => 6.99,
                'stock'    => 45,
                'alert'    => 10,
            ],
            [
                'category' => 'accessories',
                'brand'    => 'generic',
                'name'     => 'Car Phone Mount Magnetic',
                'sku'      => 'AC-CAR-MNT',
                'cost'     => 4.00,
                'price'    => 14.99,
                'stock'    => 22,
                'alert'    => 5,
            ],
            [
                'category' => 'accessories',
                'brand'    => 'apple',
                'name'     => 'AirPods Case Cover',
                'sku'      => 'AC-AP-CVR',
                'cost'     => 2.00,
                'price'    => 8.99,
                'stock'    => 3, // Low stock
                'alert'    => 5,
            ],

            // Second Hand Phones
            [
                'category' => 'second-hand-phones',
                'brand'    => 'apple',
                'name'     => 'iPhone 12 64GB - Grade A',
                'sku'      => 'SH-IP12-64A',
                'cost'     => 150.00,
                'price'    => 249.99,
                'stock'    => 3,
                'alert'    => 1,
            ],
            [
                'category' => 'second-hand-phones',
                'brand'    => 'samsung',
                'name'     => 'Samsung S22 128GB - Grade B',
                'sku'      => 'SH-S22-128B',
                'cost'     => 180.00,
                'price'    => 299.99,
                'stock'    => 2,
                'alert'    => 1,
            ],
            [
                'category' => 'second-hand-phones',
                'brand'    => 'google',
                'name'     => 'Google Pixel 7 128GB - Grade A',
                'sku'      => 'SH-GP7-128A',
                'cost'     => 200.00,
                'price'    => 329.99,
                'stock'    => 1,
                'alert'    => 1,
            ],
        ];

        $productCount = 0;
        foreach ($products as $p) {
            Product::firstOrCreate(
                ['shop_id' => $shop->id, 'sku' => $p['sku']],
                [
                    'category_id'     => $createdCategories[$p['category']]->id,
                    'brand_id'        => $createdBrands[$p['brand']]->id,
                    'name'            => $p['name'],
                    'sku'             => $p['sku'],
                    'cost_price'      => $p['cost'],
                    'sell_price'      => $p['price'],
                    'stock'           => $p['stock'],
                    'low_stock_alert' => $p['alert'],
                    'is_active'       => true,
                ]
            );
            $productCount++;
        }

        $this->command->info("✅ {$productCount} products created");

        // -----------------------------------------------
        // 6. Create Test Customers
        // -----------------------------------------------
        $customers = [
            [
                'name'    => 'John Smith',
                'phone'   => '07700 100001',
                'email'   => 'john.smith@email.com',
                'address' => '10 Baker Street, London',
                'balance' => 0,
            ],
            [
                'name'    => 'Sarah Johnson',
                'phone'   => '07700 100002',
                'email'   => 'sarah.j@email.com',
                'address' => '25 Oxford Road, Manchester',
                'balance' => 0,
            ],
            [
                'name'    => 'Mohammed Ali',
                'phone'   => '07700 100003',
                'email'   => 'mali@email.com',
                'address' => '8 Park Lane, Birmingham',
                'balance' => 45.00, // Has outstanding balance
            ],
            [
                'name'    => 'Emma Wilson',
                'phone'   => '07700 100004',
                'email'   => 'emma.w@email.com',
                'address' => '3 Queens Road, Leeds',
                'balance' => 0,
            ],
            [
                'name'    => 'David Brown',
                'phone'   => '07700 100005',
                'email'   => null,
                'address' => null,
                'balance' => 120.00, // Has outstanding balance
            ],
            [
                'name'    => 'Priya Patel',
                'phone'   => '07700 100006',
                'email'   => 'priya.p@email.com',
                'address' => '15 Maple Avenue, Bristol',
                'balance' => 0,
            ],
        ];

        $customerCount = 0;
        foreach ($customers as $c) {
            Customer::firstOrCreate(
                ['shop_id' => $shop->id, 'phone' => $c['phone']],
                [
                    'name'    => $c['name'],
                    'email'   => $c['email'],
                    'address' => $c['address'],
                    'balance' => $c['balance'],
                ]
            );
            $customerCount++;
        }

        $this->command->info("✅ {$customerCount} customers created");

        // -----------------------------------------------
        // Summary Table
        // -----------------------------------------------
        $this->command->newLine();
        $this->command->table(
            ['Item', 'Count'],
            [
                ['Shops',      Shop::count()],
                ['Users',      User::count()],
                ['Categories', Category::where('shop_id', $shop->id)->count()],
                ['Brands',     Brand::where('shop_id', $shop->id)->count()],
                ['Products',   Product::where('shop_id', $shop->id)->count()],
                ['Customers',  Customer::where('shop_id', $shop->id)->count()],
            ]
        );

        $this->command->newLine();
        $this->command->info('🎉 Test data seeded successfully!');
        $this->command->newLine();
        $this->command->line('Login credentials:');
        $this->command->table(
            ['Email', 'Password', 'Role'],
            [
                ['superadmin@phoneshop.com', 'password', 'Super Admin'],
                ['shopadmin@phoneshop.com',  'password', 'Shop Admin'],
                ['staff@phoneshop.com',      'password', 'Staff'],
            ]
        );
    }
}