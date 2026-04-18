<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id', 'product_id', 'brand_id',
        'model_name', 'imei', 'serial_number',
        'condition', 'storage', 'color',
        'purchase_price', 'selling_price',
        'status', 'notes',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price'  => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────
    public function shop()         { return $this->belongsTo(Shop::class); }
    public function brand()        { return $this->belongsTo(Brand::class); }
    public function product()      { return $this->belongsTo(Product::class); }
    public function transactions() { return $this->hasMany(DeviceTransaction::class); }
    public function buyTransaction()
    {
        return $this->hasOne(DeviceTransaction::class)->where('type', 'buy')->latest();
    }

    // ── Scopes ────────────────────────────────────────────
    public function scopeForShop($q, $shopId)  { return $q->where('shop_id', $shopId); }
    public function scopeInStock($q)           { return $q->where('status', 'in_stock'); }
    public function scopeSold($q)              { return $q->where('status', 'sold'); }

    // ── Helpers ───────────────────────────────────────────
    public function getConditionLabelAttribute(): string
    {
        return match($this->condition) {
            'new'         => 'A — New',
            'used'        => 'B — Good',
            'refurbished' => 'C — Average',
            'faulty'      => 'D — Faulty',
            default       => ucfirst($this->condition),
        };
    }

    public function getProfitAttribute(): float
    {
        if (!$this->selling_price) return 0;
        return (float) $this->selling_price - (float) $this->purchase_price;
    }
}