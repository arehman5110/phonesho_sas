<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Shop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'phone',
        'email',
        'address',
        'city',
        'country',
        'currency',
        'currency_symbol',
        'timezone',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // -----------------------------------------------
    // Auto-generate slug from name
    // -----------------------------------------------
    protected static function booted(): void
    {
        static::creating(function (Shop $shop) {
            if (empty($shop->slug)) {
                $shop->slug = Str::slug($shop->name);
            }
        });
    }

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    // A shop has many users (through pivot)
    public function users()
    {
        return $this->belongsToMany(User::class, 'shop_user')
                    ->withPivot('role', 'is_active')
                    ->withTimestamps();
    }

    // A shop has one owner (super admin or shop admin)
    public function activeUsers()
    {
        return $this->belongsToMany(User::class, 'shop_user')
                    ->withPivot('role', 'is_active')
                    ->wherePivot('is_active', true)
                    ->withTimestamps();
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------
    public function hasUser(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }

    public function getCurrencySymbolAttribute(): string
    {
        return $this->attributes['currency_symbol'] ?? '£';
    }
}