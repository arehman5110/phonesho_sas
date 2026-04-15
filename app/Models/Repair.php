<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repair extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    'shop_id',
    'parent_repair_id',      
    'is_warranty_return',    
    'customer_id',
    'status_id',
    'created_by',
    'assigned_to',
    'reference',
    'total_price',
    'discount',
    'final_price',
    'book_in_date',
    'completion_date',
    'delivery_type',
    'notes',
];

    protected $casts = [
    'total_price'       => 'decimal:2',
    'discount'          => 'decimal:2',
    'final_price'       => 'decimal:2',
    'book_in_date'      => 'date',
    'completion_date'   => 'date',
    'is_warranty_return'=> 'boolean', 
];

    // -----------------------------------------------
    // Boot — auto generate reference number
    // -----------------------------------------------
    protected static function booted(): void
    {
        static::creating(function (Repair $repair) {
            if (empty($repair->reference)) {
                $last = Repair::where('shop_id', $repair->shop_id)
                              ->latest()
                              ->first();

                $nextNumber      = $last
                    ? (intval(substr($last->reference, -5)) + 1)
                    : 1;

                $repair->reference = 'REP-' . str_pad(
                    $nextNumber, 5, '0', STR_PAD_LEFT
                );
            }
        });
    }

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    // Repair belongs to a shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Repair belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Repair has a status
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Repair created by a user
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Repair assigned to a user
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Repair has many devices
    public function devices()
    {
        return $this->hasMany(RepairDevice::class);
    }

    // Repair has many payments (polymorphic)
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    // Repair has many customer transactions
    public function customerTransactions()
    {
        return $this->morphMany(CustomerTransaction::class, 'reference');
    }

    // Original repair this is a warranty return of
public function parentRepair()
{
    return $this->belongsTo(Repair::class, 'parent_repair_id');
}

// Warranty returns created from this repair
public function warrantyReturns()
{
    return $this->hasMany(Repair::class, 'parent_repair_id');
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
        return max(0, (float) $this->final_price - $this->total_paid);
    }

    public function getTotalPartsAttribute(): float
    {
        return (float) $this->devices()
            ->with('parts')
            ->get()
            ->sum(fn($d) => $d->parts->sum(
                fn($p) => $p->price * $p->quantity
            ));
    }

    // -----------------------------------------------
    // Scopes
    // -----------------------------------------------

    public function scopeForShop($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }

    public function scopeByStatus($query, $statusId)
    {
        return $query->where('status_id', $statusId);
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

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('reference', 'like', "%{$term}%")
              ->orWhereHas('customer', fn($c) =>
                  $c->where('name', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%")
              )
              ->orWhereHas('devices', fn($d) =>
                  $d->where('imei', 'like', "%{$term}%")
                    ->orWhere('issue', 'like', "%{$term}%")
              );
        });
    }

    public function scopeWarrantyReturns($query)
{
    return $query->where('is_warranty_return', true);
}

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    public function isCompleted(): bool
    {
        return $this->status?->is_completed ?? false;
    }

    public function isFullyPaid(): bool
    {
        return $this->total_paid >= (float) $this->final_price;
    }

    public function getFormattedFinalPriceAttribute(): string
    {
        return '£' . number_format($this->final_price, 2);
    }

    public function getDeliveryTypeLabelAttribute(): string
    {
        return match($this->delivery_type) {
            'delivery'   => 'Delivery',
            'collection' => 'Collection',
            default      => ucfirst($this->delivery_type),
        };
    }

    // Is this a warranty return?
public function isWarrantyReturn(): bool
{
    return (bool) $this->is_warranty_return;
}

// Does this repair have warranty returns?
public function hasWarrantyReturns(): bool
{
    return $this->warrantyReturns()->exists();
}
}