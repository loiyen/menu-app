<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoris extends Model
{
    /** @use HasFactory<\Database\Factories\KategorisFactory> */
    use HasFactory;

    protected $fillable = ['nama'];


    public function menu()
    {

        return $this->hasMany(menus::class, 'kategori_id');
    }

    public function menu_ds()
    {
        return $this->belongsTo(kategoris::class, 'kategori_id');
    }
}
