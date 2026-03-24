<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategoris extends Model
{

    protected $table = 'kategoris';

    protected $fillable = ['nama'];

    public function menu()
    {
        return $this->hasMany(Menuses::class, 'kategori_id');
    }

    public function menu_ds()
    {
        return $this->belongsTo(Kategoris::class, 'kategori_id');
    }
}
