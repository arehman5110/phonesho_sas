<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'customer_id',
        'created_by',
        'reference',
        'total_amount',
        'discount',
        'final_amount',
        'payment_status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount'     => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    // -----------------------------------------------
    // Boot — auto generate reference number
    // -----------------------------------------------
    protected static function booted(): void
    {
        static::creating(function (Sale $sale) {
            if (empty($sale->reference)) {
                $last = Sale::where('shop_id', $sale->shop_id)
                            ->latest()
                            ->first();

                $nextNumber   = $last
                    ? (intval(substr($last->reference, -5)) + 1)
                    : 1;

                $sale->reference = 'SALE-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Polymorphic payments
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function stockMovements()
    {
        return $this->morphMany(StockMovement::class, 'reference');
    }

    public function customerTransactions()
    {
        return $this->morphMany(CustomerTransaction::class, 'reference');
    }

    // -----------------------------------------------
    // Computed Attributes
    // -----------------------------------------------

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function getOutstandingAttribute(): float
    {
        return max(0, (float) $this->final_amount - $this->total_paid);
    }

    // -----------------------------------------------
    // Scopes
    // -----------------------------------------------

    public function scopeForShop($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopePartial($query)
    {
        return $query->where('payment_status', 'partial');
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

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function isPartial(): bool
    {
        return $this->payment_status === 'partial';
    }

    public function isFullyPaid(): bool
    {
        return $this->total_paid >= (float) $this->final_amount;
    }

    public function getFormattedTotalAttribute(): string
    {
        return '£' . number_format($this->final_amount, 2);
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            'paid'     => 'Paid',
            'pending'  => 'Pending',
            'partial'  => 'Partial',
            'refunded' => 'Refunded',
            default    => ucfirst($this->payment_status),
        };
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            'paid'     => 'green',
            'pending'  => 'yellow',
            'partial'  => 'blue',
            'refunded' => 'red',
            default    => 'gray',
        };
    }
}