<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'cost_price',
        'line_total',
    ];

    protected $casts = [
        'quantity'   => 'integer',
        'price'      => 'decimal:2',
        'cost_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    // -----------------------------------------------
    // Boot — auto calculate line total
    // -----------------------------------------------
    protected static function booted(): void
    {
        static::creating(function (SaleItem $item) {
            $item->line_total = $item->quantity * $item->price;
        });

        static::updating(function (SaleItem $item) {
            $item->line_total = $item->quantity * $item->price;
        });
    }

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    // Item belongs to a sale
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // -----------------------------------------------
    // Scopes
    // -----------------------------------------------

    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    public function getFormattedPriceAttribute(): string
    {
        $symbol = $this->sale->shop->currency_symbol ?? '£';
        return $symbol . number_format($this->price, 2);
    }

    public function getFormattedLineTotalAttribute(): string
    {
        $symbol = $this->sale->shop->currency_symbol ?? '£';
        return $symbol . number_format($this->line_total, 2);
    }

    public function getProfitAttribute(): float
    {
        return ($this->price - $this->cost_price) * $this->quantity;
    }
}