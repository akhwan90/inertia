<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanKategori extends Model
{
    //
    protected $fillable = [
        'nama',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->translatedFormat('d F Y, H:i');
    }
}
