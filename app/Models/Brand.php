<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'slug',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    // -----------------------------------------------
    // Boot — auto generate slug
    // -----------------------------------------------
    protected static function booted(): void
    {
        static::creating(function (Brand $brand) {
            if (empty($brand->slug)) {
                $brand->slug = static::_generateSlug(
                    $brand->name,
                    $brand->shop_id
                );
            }
        });

        static::updating(function (Brand $brand) {
            if ($brand->isDirty('name')) {
                $brand->slug = static::_generateSlug(
                    $brand->name,
                    $brand->shop_id,
                    $brand->id
                );
            }
        });
    }

    private static function _generateSlug(
        string $name,
        int    $shopId,
        ?int   $excludeId = null
    ): string {
        $slug  = Str::slug($name);
        $base  = $slug;
        $count = 1;

        while (
            static::where('shop_id', $shopId)
                ->where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
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
    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }
}