<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotoNumber extends Model
{
    protected $fillable = [
        'region',
        'draw_date',
        'is_special_prize',
        'province',
        'full_number',
        'loto_number',
    ];
}
