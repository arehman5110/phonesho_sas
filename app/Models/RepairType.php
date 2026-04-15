<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairType extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'used_count',
    ];

    protected $casts = [
        'used_count' => 'integer',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // -----------------------------------------------
    // Scopes
    // -----------------------------------------------

    public function scopeForShop($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }

    public function scopePopular($query)
    {
        return $query->orderByDesc('used_count')
                     ->orderBy('name');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%");
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    // Find or create repair type for shop
    public static function findOrCreateForShop(
        int    $shopId,
        string $name
    ): self {
        return static::firstOrCreate(
            [
                'shop_id' => $shopId,
                'name'    => trim($name),
            ],
            ['used_count' => 0]
        );
    }

    // Increment usage count
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }
}