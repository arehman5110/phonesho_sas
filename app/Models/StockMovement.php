<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'product_id',
        'user_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'reference_type',
        'reference_id',
        'note',
    ];

    protected $casts = [
        'quantity'     => 'integer',
        'stock_before' => 'integer',
        'stock_after'  => 'integer',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Polymorphic — links to repair, sale etc
    public function reference()
    {
        return $this->morphTo();
    }

    // -----------------------------------------------
    // Scopes
    // -----------------------------------------------

    public function scopeForShop($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }

    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeStockIn($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeStockOut($query)
    {
        return $query->where('quantity', '<', 0);
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    public function isStockIn(): bool
    {
        return $this->quantity > 0;
    }

    public function isStockOut(): bool
    {
        return $this->quantity < 0;
    }

    public function getFormattedQuantityAttribute(): string
    {
        return $this->quantity > 0
            ? '+' . $this->quantity
            : (string) $this->quantity;
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'purchase' => 'Purchase',
            'sale'     => 'Sale',
            'repair'   => 'Repair',
            'manual'   => 'Manual Adjustment',
            'return'   => 'Return',
            default    => ucfirst($this->type),
        };
    }

    public function getTypeBadgeColorAttribute(): string
    {
        return match($this->type) {
            'purchase' => 'green',
            'sale'     => 'blue',
            'repair'   => 'orange',
            'manual'   => 'gray',
            'return'   => 'purple',
            default    => 'gray',
        };
    }
}