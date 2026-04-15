<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    // DeviceType belongs to a shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // DeviceType has many repair devices
    public function repairDevices()
    {
        return $this->hasMany(RepairDevice::class);
    }

    // -----------------------------------------------
    // Scopes
    // -----------------------------------------------

    public function scopeForShop($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    public function getIconEmojiAttribute(): string
    {
        return match($this->icon) {
            'mobile'  => '📱',
            'laptop'  => '💻',
            'tablet'  => '📟',
            'watch'   => '⌚',
            'console' => '🎮',
            'camera'  => '📷',
            'other'   => '🔧',
            default   => '📱',
        };
    }
}