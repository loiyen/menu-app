<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mejas extends Model
{

    protected $table = 'mejas';
    
    protected $fillable = [
        'nomor_meja',
        'lokasi'
    ];
}
