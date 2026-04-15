<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'code',
        'type',
        'value',
        'usage_limit',
        'used_count',
        'min_order_amount',
        'assigned_to',
        'expiry_date',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'value'            => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'usage_limit'      => 'integer',
        'used_count'       => 'integer',
        'is_active'        => 'boolean',
        'expiry_date'      => 'date',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function assignedCustomer()
    {
        return $this->belongsTo(Customer::class, 'assigned_to');
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

    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                  ->orWhere('expiry_date', '>=', now()->toDateString());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                  ->orWhereColumn('used_count', '<', 'usage_limit');
            });
    }

    // -----------------------------------------------
    // Validation Helpers
    // -----------------------------------------------

    public function isExpired(): bool
    {
        if (!$this->expiry_date) return false;
        return $this->expiry_date->isPast();
    }

    public function isUsageLimitReached(): bool
    {
        if (!$this->usage_limit) return false;
        return $this->used_count >= $this->usage_limit;
    }

    public function isValidForCustomer(?int $customerId): bool
    {
        if (!$this->assigned_to) return true;
        return $this->assigned_to === $customerId;
    }

    public function isValidForAmount(float $amount): bool
    {
        if (!$this->min_order_amount) return true;
        return $amount >= (float) $this->min_order_amount;
    }

    public function canBeUsed(?int $customerId = null, float $amount = 0): array
    {
        // Not active
        if (!$this->is_active) {
            return [
                'valid'   => false,
                'message' => 'This voucher is inactive.',
            ];
        }

        // Expired
        if ($this->isExpired()) {
            return [
                'valid'   => false,
                'message' => 'This voucher has expired.',
            ];
        }

        // Usage limit reached
        if ($this->isUsageLimitReached()) {
            return [
                'valid'   => false,
                'message' => 'This voucher has reached its usage limit.',
            ];
        }

        // Wrong customer
        if (!$this->isValidForCustomer($customerId)) {
            return [
                'valid'   => false,
                'message' => 'This voucher is assigned to a different customer.',
            ];
        }

        // Min order amount
        if (!$this->isValidForAmount($amount)) {
            return [
                'valid'   => false,
                'message' => 'Minimum order amount of £'
                    . number_format($this->min_order_amount, 2)
                    . ' required.',
            ];
        }

        return ['valid' => true, 'message' => 'Voucher is valid.'];
    }

    // -----------------------------------------------
    // Calculate discount amount
    // -----------------------------------------------
    public function calculateDiscount(float $total): float
    {
        if ($this->type === 'percentage') {
            $discount = ($total * (float) $this->value) / 100;
        } else {
            $discount = (float) $this->value;
        }

        // Cannot exceed total
        return min($discount, $total);
    }

    // -----------------------------------------------
    // Increment usage
    // -----------------------------------------------
    public function redeem(): void
    {
        $this->increment('used_count');
    }

    // -----------------------------------------------
    // Computed attributes
    // -----------------------------------------------

    public function getFormattedValueAttribute(): string
    {
        if ($this->type === 'percentage') {
            return number_format($this->value, 0) . '%';
        }
        return '£' . number_format($this->value, 2);
    }

    public function getRemainingUsesAttribute(): ?int
    {
        if (!$this->usage_limit) return null;
        return max(0, $this->usage_limit - $this->used_count);
    }

    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_active)           return 'Inactive';
        if ($this->isExpired())          return 'Expired';
        if ($this->isUsageLimitReached()) return 'Used Up';
        return 'Active';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status_label) {
            'Active'   => 'green',
            'Inactive' => 'gray',
            'Expired'  => 'red',
            'Used Up'  => 'orange',
            default    => 'gray',
        };
    }
}