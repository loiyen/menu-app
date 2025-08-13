<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
  /** @use HasFactory<\Database\Factories\OrdersFactory> */
  use HasFactory;

  protected $fillable = [
    'order_id',
    'nama',
    'meja_id',       // tambahkan ini
    'waktu_pesan',
    'opsi',
    'status',
    'payment_status',
    'catatan',
    'total_harga',

  ];

  public function meja()
  {
    return $this->belongsTo(mejas::class, 'meja_id');
  }


  public function items()
  {
    return $this->hasMany(OrderItem::class, 'order_id');
  }

  public function pembayaran()
  {
    return $this->hasOne(pembayarans::class, 'orders_id');
  }
}
