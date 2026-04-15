<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'key',
        'value',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // -----------------------------------------------
    // Static Helpers
    // -----------------------------------------------

    // Get a single setting value for a shop
    public static function get(int $shopId, string $key, mixed $default = null): mixed
    {
        $setting = static::where('shop_id', $shopId)
                         ->where('key', $key)
                         ->first();

        return $setting?->value ?? $default;
    }

    // Set a setting value for a shop
    public static function set(int $shopId, string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['shop_id' => $shopId, 'key' => $key],
            ['value'   => $value]
        );
    }

    // Get all settings for a shop as key => value array
    public static function getAllForShop(int $shopId): array
    {
        return static::where('shop_id', $shopId)
                     ->pluck('value', 'key')
                     ->toArray();
    }

    // -----------------------------------------------
    // Default Settings
    // -----------------------------------------------

    public static function defaults(): array
    {
        return [
            'receipt_footer'    => 'Thank you for your business!',
            'receipt_terms'     => 'All sales are final. No refunds without receipt.',
            'receipt_show_logo' => 'true',
            'email_subject'     => 'Your Receipt — {reference}',
            'email_footer'      => 'Thank you for choosing us!',
            'currency_symbol'   => '£',
            'tax_number'        => '',
            'website'           => '',
        ];
    }

    // Get setting with fallback to defaults
    public static function getWithDefault(
        int    $shopId,
        string $key
    ): mixed {
        $value = static::get($shopId, $key);

        if ($value === null) {
            return static::defaults()[$key] ?? null;
        }

        return $value;
    }
}