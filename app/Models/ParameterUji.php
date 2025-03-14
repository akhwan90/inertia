<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ParameterUji extends Model
{
    //
    protected $fillable = [
        'nama',
        'satuan',
        'kadar_maksimum_operator',
        'kadar_maksimum_value',
        'metode_uji',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->translatedFormat('d F Y, H:i');
    }
}
