<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoris extends Model
{
    /** @use HasFactory<\Database\Factories\KategorisFactory> */
    use HasFactory;

    protected $fillable = ['nama'];


    public function menu()
    {

        return $this->hasMany(Menus::class, 'kategori_id');
    }

    public function menu_ds()
    {
        return $this->belongsTo(Kategoris::class, 'kategori_id');
    }
}
