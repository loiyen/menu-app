<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'xendit_external_id',
        'payment_type',
        'transaction_status',
        'gross_amount',
        'invoice_url',
        'expiry_time',
        'transaction_time',
    ];

    /**
     * Relasi ke Order
     */
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    protected $casts = [
        'transaction_time' => 'datetime',
    ];
}