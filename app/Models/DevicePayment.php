<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DevicePayment extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'method', 'amount', 'note'];

    protected $casts = ['amount' => 'decimal:2'];

    public function transaction()
    {
        return $this->belongsTo(DeviceTransaction::class, 'transaction_id');
    }
}