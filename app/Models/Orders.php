<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
  /** @use HasFactory<\Database\Factories\OrdersFactory> */
  use HasFactory;

  protected $fillable = [
    'nama',
    'phone',
    'email',
    'meja_id',    
    'waktu_pesan',
    'opsi',
    'status',
    'payment_status',
    'catatan',
    'total_harga',

  ];

  public function meja()
  {
    return $this->belongsTo(Mejas::class, 'meja_id');
  }


  public function items()
  {
    return $this->hasMany(OrderItems::class, 'order_id');
  }

  public function pembayaran()
  {
    return $this->hasOne(Pembayarans::class, 'orders_id');
  }

  public function transaction()
  {
    return $this->hasOne(Transaction::class);
  }


}
