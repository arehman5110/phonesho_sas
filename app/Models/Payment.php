<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'user_id',
        'payable_type',
        'payable_id',
        'method',
        'amount',
        'split_part',
        'reference',
        'note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    // Payment belongs to a shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Payment taken by a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Polymorphic — links to Sale, Repair, BuySell
    public function payable()
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

    public function scopeByMethod($query, $method)
    {
        return $query->where('method', $method);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at',  now()->year);
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    public function getFormattedAmountAttribute(): string
    {
        return '£' . number_format($this->amount, 2);
    }

    public function getMethodLabelAttribute(): string
    {
        return match($this->method) {
            'cash'  => 'Cash',
            'card'  => 'Card',
            'split' => 'Split',
            'trade' => 'Trade-in',
            'other' => 'Other',
            default => ucfirst($this->method),
        };
    }

    public function getMethodIconAttribute(): string
    {
        return match($this->method) {
            'cash'  => '💵',
            'card'  => '💳',
            'split' => '✂️',
            'trade' => '🔄',
            'other' => '💰',
            default => '💰',
        };
    }
}