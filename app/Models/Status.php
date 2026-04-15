<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'type',
        'name',
        'color',
        'is_default',
        'is_completed',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_default'   => 'boolean',
        'is_completed' => 'boolean',
        'is_active'    => 'boolean',
    ];

    // -----------------------------------------------
    // Relationships
    // -----------------------------------------------

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Status has many repairs
    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    // -----------------------------------------------
    // Scopes
    // -----------------------------------------------

    public function scopeForShop($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------

    public function getBadgeColorAttribute(): string
    {
        return match($this->color) {
            'green'  => 'bg-green-100 text-green-800',
            'red'    => 'bg-red-100 text-red-800',
            'blue'   => 'bg-blue-100 text-blue-800',
            'yellow' => 'bg-yellow-100 text-yellow-800',
            'orange' => 'bg-orange-100 text-orange-800',
            'purple' => 'bg-purple-100 text-purple-800',
            'gray'   => 'bg-gray-100 text-gray-800',
            default  => 'bg-gray-100 text-gray-800',
        };
    }

    public function getHexColorAttribute(): string
    {
        return match($this->color) {
            'green'  => '#10b981',
            'red'    => '#ef4444',
            'blue'   => '#3b82f6',
            'yellow' => '#f59e0b',
            'orange' => '#f97316',
            'purple' => '#8b5cf6',
            'gray'   => '#6b7280',
            default  => '#6b7280',
        };
    }
}