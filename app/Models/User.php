<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'active_shop_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    // All shops this user belongs to
    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'shop_user')
                    ->withPivot('role', 'is_active')
                    ->withTimestamps();
    }

    // Only active shops for this user
    public function activeShops()
    {
        return $this->belongsToMany(Shop::class, 'shop_user')
                    ->withPivot('role', 'is_active')
                    ->wherePivot('is_active', true)
                    ->withTimestamps();
    }

    // Currently selected shop
    public function activeShop()
    {
        return $this->belongsTo(Shop::class, 'active_shop_id');
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    // Check if user belongs to a shop
    public function belongsToShop(Shop $shop): bool
    {
        return $this->shops()->where('shop_id', $shop->id)->exists();
    }

    // Check if user has an active shop set
    public function hasActiveShop(): bool
    {
        return !is_null($this->active_shop_id);
    }

    // Get active shop or first available shop
    public function getCurrentShop(): ?Shop
    {
        if ($this->hasActiveShop()) {
            return $this->activeShop;
        }

        return $this->activeShops()->first();
    }

    // Is this user a super admin?
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    // Is this user a shop admin?
    public function isShopAdmin(): bool
    {
        return $this->hasRole('shop_admin');
    }
}