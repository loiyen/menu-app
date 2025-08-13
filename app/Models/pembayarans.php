<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayarans extends Model
{
    /** @use HasFactory<\Database\Factories\PembayaransFactory> */
    use HasFactory;

    protected $fillable = [
        'orders_id',
        'metode',
        'jumlah_bayar',
        'kembalian',
        'status',
        'waktu_bayar',
    ];

    public function order()
    {
        return $this->belongsTo(orders::class, 'orders_id');
    }
}
