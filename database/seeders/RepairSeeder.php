<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\DeviceType;
use App\Models\Status;

class RepairSeeder extends Seeder
{
    public function run(): void
    {
        $shops = Shop::all();

        if ($shops->isEmpty()) {
            $this->command->warn('No shops found. Run TestDataSeeder first.');
            return;
        }

        foreach ($shops as $shop) {

            // ── Device Types ──────────────────────────
            $deviceTypes = [
                ['name' => 'Mobile Phone', 'icon' => 'mobile',  'sort_order' => 1],
                ['name' => 'Laptop',       'icon' => 'laptop',  'sort_order' => 2],
                ['name' => 'Tablet',       'icon' => 'tablet',  'sort_order' => 3],
                ['name' => 'Smart Watch',  'icon' => 'watch',   'sort_order' => 4],
                ['name' => 'Games Console','icon' => 'console', 'sort_order' => 5],
                ['name' => 'Camera',       'icon' => 'camera',  'sort_order' => 6],
                ['name' => 'Other',        'icon' => 'other',   'sort_order' => 7],
            ];

            foreach ($deviceTypes as $type) {
                DeviceType::firstOrCreate(
                    [
                        'shop_id' => $shop->id,
                        'name'    => $type['name'],
                    ],
                    [
                        'icon'       => $type['icon'],
                        'is_active'  => true,
                        'sort_order' => $type['sort_order'],
                    ]
                );
            }

            $this->command->info(
                "✅ Device types seeded for: {$shop->name}"
            );

            // ── Repair Statuses ───────────────────────
            $statuses = [
                [
                    'name'         => 'Booked In',
                    'color'        => 'blue',
                    'is_default'   => true,
                    'is_completed' => false,
                    'sort_order'   => 1,
                ],
                [
                    'name'         => 'Diagnosing',
                    'color'        => 'yellow',
                    'is_default'   => false,
                    'is_completed' => false,
                    'sort_order'   => 2,
                ],
                [
                    'name'         => 'Awaiting Parts',
                    'color'        => 'orange',
                    'is_default'   => false,
                    'is_completed' => false,
                    'sort_order'   => 3,
                ],
                [
                    'name'         => 'In Repair',
                    'color'        => 'purple',
                    'is_default'   => false,
                    'is_completed' => false,
                    'sort_order'   => 4,
                ],
                [
                    'name'         => 'Repaired',
                    'color'        => 'green',
                    'is_default'   => false,
                    'is_completed' => false,
                    'sort_order'   => 5,
                ],
                [
                    'name'         => 'Ready for Collection',
                    'color'        => 'green',
                    'is_default'   => false,
                    'is_completed' => false,
                    'sort_order'   => 6,
                ],
                [
                    'name'         => 'Collected',
                    'color'        => 'green',
                    'is_default'   => false,
                    'is_completed' => true,
                    'sort_order'   => 7,
                ],
                [
                    'name'         => 'Cannot Repair',
                    'color'        => 'red',
                    'is_default'   => false,
                    'is_completed' => true,
                    'sort_order'   => 8,
                ],
                [
                    'name'         => 'Returned',
                    'color'        => 'gray',
                    'is_default'   => false,
                    'is_completed' => true,
                    'sort_order'   => 9,
                ],
            ];

            foreach ($statuses as $status) {
                Status::firstOrCreate(
                    [
                        'shop_id' => $shop->id,
                        'type'    => 'repair',
                        'name'    => $status['name'],
                    ],
                    [
                        'color'        => $status['color'],
                        'is_default'   => $status['is_default'],
                        'is_completed' => $status['is_completed'],
                        'is_active'    => true,
                        'sort_order'   => $status['sort_order'],
                    ]
                );
            }

            $this->command->info(
                "✅ Repair statuses seeded for: {$shop->name}"
            );
        }

        // ── Summary ───────────────────────────────
        $this->command->newLine();
        $this->command->table(
            ['Type', 'Count'],
            [
                ['Device Types', DeviceType::count()],
                ['Repair Statuses', Status::where('type', 'repair')->count()],
            ]
        );
    }
}