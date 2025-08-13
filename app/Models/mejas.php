<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mejas extends Model
{
    /** @use HasFactory<\Database\Factories\MejasFactory> */
    use HasFactory;

    protected $fillable = [
        'nomor_meja',
        'lokasi'
    ];


}
