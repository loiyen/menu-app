<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayarans extends Model
{
    protected $table = 'pembayarans';
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
        return $this->belongsTo(Orders::class, 'orders_id');
    }
}
