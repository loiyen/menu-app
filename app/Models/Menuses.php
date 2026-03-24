<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menuses extends Model
{
    protected $table = 'menuses';

    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'gambar',
        'kategori_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategoris::class);
    }
}
