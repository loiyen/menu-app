<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subkategoris extends Model
{
    /** @use HasFactory<\Database\Factories\SubkategorisFactory> */
    use HasFactory;

    public function menu(){
        return $this->hasMany(Menus::class, 'subkategori_id');
    }
}
