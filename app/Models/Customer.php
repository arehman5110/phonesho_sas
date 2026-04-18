<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Repair;
use App\Models\Sale;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'name',
        'phone',
        'email',
        'address',
        'notes',
        'balance',
        'notes',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    // Customer belongs to a shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Customer has many transactions
    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    // -----------------------------------------------
    // Scopes
    // -----------------------------------------------

    // Always filter by active shop
    public function scopeForShop($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }

    // Search by name, phone or email
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%");
        });
    }

    // Customers with outstanding balance
    public function scopeWithBalance($query)
    {
        return $query->where('balance', '>', 0);
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    // Check if customer has outstanding balance
    public function hasOutstandingBalance(): bool
    {
        return $this->balance > 0;
    }

    // Get formatted balance
    public function getFormattedBalanceAttribute(): string
    {
        $symbol = $this->shop->currency_symbol ?? '£';
        return $symbol . number_format(abs($this->balance), 2);
    }

    // Get balance status label
    public function getBalanceStatusAttribute(): string
    {
        if ($this->balance > 0) return 'outstanding';
        if ($this->balance < 0) return 'credit';
        return 'clear';
    }
    // User created many customer transactions
    public function customerTransactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    // Customer has many repairs
    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    // Customer has many sales
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}