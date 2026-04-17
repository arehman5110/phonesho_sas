<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairDevice extends Model
{
    use HasFactory;

    protected $fillable = [
    'repair_id',
    'device_name',
    'device_type_id',
    'status_id',
    'imei',
    'color',
    'issue',
    'repair_type',
    'notes',
    'warranty_status',
    'warranty_days',          // ← add
    'warranty_expiry_date',   // ← add
    'price',
];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    // RepairDevice belongs to a repair
    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }

    // RepairDevice belongs to a device type
    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class);
    }

    // RepairDevice has a status
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // RepairDevice has many parts
    public function parts()
    {
        return $this->hasMany(RepairPart::class);
    }

    // -----------------------------------------------
    // Scopes
    // -----------------------------------------------

    public function scopeByWarranty($query, $status)
    {
        return $query->where('warranty_status', $status);
    }

    public function scopeActive($query)
    {
        return $query->where('warranty_status', 'active');
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    public function getTotalPartsValueAttribute(): float
    {
        return (float) $this->parts->sum(
            fn($p) => $p->price * $p->quantity
        );
    }

    public function getFormattedPriceAttribute(): string
    {
        return '£' . number_format($this->price, 2);
    }

    public function getWarrantyLabelAttribute(): string
    {
        return match($this->warranty_status) {
            'active'          => 'Under Warranty',
            'under_warranty'  => 'Under Warranty',
            'expired'         => 'Warranty Expired',
            'none'            => 'No Warranty',
            default           => 'No Warranty',
        };
    }

    public function getWarrantyColorAttribute(): string
    {
        return match($this->warranty_status) {
            'active'          => 'green',
            'under_warranty'  => 'blue',
            'expired'         => 'red',
            'none'            => 'gray',
            default           => 'gray',
        };
    }

    public function getDisplayNameAttribute(): string
    {
        $parts = array_filter([
            $this->deviceType?->name,
            $this->color,
            $this->imei ? "IMEI: {$this->imei}" : null,
        ]);

        return implode(' — ', $parts) ?: 'Device';
    }

    // Is device currently under warranty?
public function isUnderWarranty(): bool
{
    if ($this->warranty_status !== 'active') return false;
    if (!$this->warranty_expiry_date)        return true;
    return $this->warranty_expiry_date->isFuture();
}

// Days remaining on warranty
public function warrantyDaysRemaining(): int
{
    if (!$this->warranty_expiry_date) return 0;
    return max(0, now()->diffInDays($this->warranty_expiry_date, false));
}

// Set warranty expiry when warranty_days is provided
public function calculateWarrantyExpiry(): void
{
    if ($this->warranty_days && $this->repair) {
        $this->warranty_expiry_date = $this->repair->created_at
            ->addDays($this->warranty_days);
        $this->save();
    }
}

public function getWarrantyExpiryLabelAttribute(): string
{
    if (!$this->warranty_expiry_date) return '—';
    return $this->warranty_expiry_date->format('d/m/Y');
}
}