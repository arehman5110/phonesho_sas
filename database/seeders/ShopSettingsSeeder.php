<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\ShopSetting;

class ShopSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $shops = Shop::all();

        if ($shops->isEmpty()) {
            $this->command->warn('No shops found. Run TestDataSeeder first.');
            return;
        }

        foreach ($shops as $shop) {
            $settings = [
                // ── Receipt Settings ──────────────────────
                'receipt_footer'     => 'Thank you for your business!',
                'receipt_terms'      => 'All sales are final. No refunds without receipt.',
                'receipt_show_logo'  => 'true',
                'receipt_header'     => $shop->name,

                // ── Email Settings ────────────────────────
                'email_subject'      => 'Your Receipt — {reference}',
                'email_footer'       => "Thank you for choosing {$shop->name}!",

                // ── Shop Info ─────────────────────────────
                'currency_symbol'    => '£',
                'tax_number'         => '',
                'website'            => '',

                // ── Repair Settings ───────────────────────
                'repair_warranty'    => '30 days warranty on all repairs.',
                'repair_terms'       => 'We are not responsible for data loss.',
            ];

            foreach ($settings as $key => $value) {
                ShopSetting::updateOrCreate(
                    [
                        'shop_id' => $shop->id,
                        'key'     => $key,
                    ],
                    ['value' => $value]
                );
            }

            $this->command->info(
                "✅ Settings seeded for shop: {$shop->name}"
            );
        }

        $this->command->newLine();
        $this->command->table(
            ['Key', 'Description'],
            [
                ['receipt_footer',  'Text shown at bottom of receipt'],
                ['receipt_terms',   'Terms shown on receipt'],
                ['receipt_header',  'Header text on receipt'],
                ['email_subject',   'Email subject line'],
                ['email_footer',    'Email footer text'],
                ['currency_symbol', 'Currency symbol (£, $, €)'],
                ['tax_number',      'VAT/Tax registration number'],
                ['website',         'Shop website URL'],
                ['repair_warranty', 'Warranty text on repair receipts'],
                ['repair_terms',    'Repair terms and conditions'],
            ]
        );
    }
}