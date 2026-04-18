<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id', 'type', 'customer_id',
        'price', 'discount', 'final_amount',
        'payment_status', 'notes',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'discount'     => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────
    public function device()   { return $this->belongsTo(Device::class); }
    public function customer() { return $this->belongsTo(Customer::class); }
    public function payments() { return $this->hasMany(DevicePayment::class, 'transaction_id'); }

    // ── Helpers ───────────────────────────────────────────
    public function getPaidAttribute(): float
    {
        return (float) $this->payments->sum('amount');
    }

    public function getOutstandingAttribute(): float
    {
        return max(0, (float) $this->final_amount - $this->paid);
    }
}