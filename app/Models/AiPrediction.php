<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiPrediction extends Model
{
    protected $fillable = [
        'prediction_date',
        'region',
        'province',
        'prediction_type',
        'numbers',
    ];

    protected $casts = [
        'prediction_date' => 'date',
        'numbers' => 'array'
    ];

    const TYPE_SO_DE = 'so_de';
    const TYPE_SO_LO = 'so_lo';

    public function scopeByRegion($query, $region)
    {
        return $query->where('region', $region);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('prediction_type', $type);
    }

    public function scopeByProvince($query, $province)
    {
        return $query->where('province', $province);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('prediction_date', 'desc');
    }
}
