<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_device_id',
        'product_id',
        'user_id',
        'name',
        'quantity',
        'price',
        'stock_deducted',
        'notes',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'quantity'       => 'integer',
        'stock_deducted' => 'boolean',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    // Part belongs to a repair device
    public function repairDevice()
    {
        return $this->belongsTo(RepairDevice::class);
    }

    // Part links to a product in inventory (optional)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Part added by a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // -----------------------------------------------
    // Scopes
    // -----------------------------------------------

    public function scopeFromInventory($query)
    {
        return $query->whereNotNull('product_id');
    }

    public function scopeManual($query)
    {
        return $query->whereNull('product_id');
    }

    public function scopeStockDeducted($query)
    {
        return $query->where('stock_deducted', true);
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    public function getLineTotalAttribute(): float
    {
        return (float) $this->price * $this->quantity;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '£' . number_format($this->price, 2);
    }

    public function getFormattedLineTotalAttribute(): string
    {
        return '£' . number_format($this->line_total, 2);
    }

    public function isFromInventory(): bool
    {
        return !is_null($this->product_id);
    }
}