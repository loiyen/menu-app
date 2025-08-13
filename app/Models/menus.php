<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menus extends Model
{
    /** @use HasFactory<\Database\Factories\MenusFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'gambar',
        'kategori_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(kategoris::class);
    }

    
}
