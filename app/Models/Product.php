<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'category_id',
        'brand_id',
        'name',
        'sku',
        'description',
        'cost_price',
        'sell_price',
        'stock',
        'low_stock_alert',
        'is_active',
    ];

    protected $casts = [
        'cost_price'      => 'decimal:2',
        'sell_price'      => 'decimal:2',
        'stock'           => 'integer',
        'low_stock_alert' => 'integer',
        'is_active'       => 'boolean',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    // Product belongs to a shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product belongs to a brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Product has many stock movements
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
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

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'low_stock_alert')
                     ->where('stock', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('sku', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%");
        });
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    public function isLowStock(): bool
    {
        return $this->stock <= $this->low_stock_alert
               && $this->stock > 0;
    }

    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function getFormattedSellPriceAttribute(): string
    {
        $symbol = $this->shop->currency_symbol ?? '£';
        return $symbol . number_format($this->sell_price, 2);
    }

    public function getFormattedCostPriceAttribute(): string
    {
        $symbol = $this->shop->currency_symbol ?? '£';
        return $symbol . number_format($this->cost_price, 2);
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->isOutOfStock()) return 'out_of_stock';
        if ($this->isLowStock())   return 'low_stock';
        return 'in_stock';
    }

    public function getStockStatusLabelAttribute(): string
    {
        return match($this->stock_status) {
            'out_of_stock' => 'Out of Stock',
            'low_stock'    => 'Low Stock',
            default        => 'In Stock',
        };
    }
}