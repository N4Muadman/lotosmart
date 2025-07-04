<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotteryResult extends Model
{
    protected $fillable = [
        'region',
        'draw_date',
        'special_prize',
        'first_prize',
        'second_prize',
        'third_prize',
        'fourth_prize',
        'fifth_prize',
        'sixth_prize',
        'seventh_prize',
        'eighth_prize',
        'special_code',
        'province'
    ];

    protected $casts = [
        'draw_date' => 'date',
        'special_prize' => 'array',
        'first_prize' => 'array',
        'second_prize' => 'array',
        'third_prize' => 'array',
        'fourth_prize' => 'array',
        'fifth_prize' => 'array',
        'sixth_prize' => 'array',
        'seventh_prize' => 'array',
        'eighth_prize' => 'array',
        'special_code' => 'array'
    ];

    public function getAllNumbers()
    {
        return collect([
            $this->first_prize,
            $this->second_prize,
            $this->third_prize,
            $this->fourth_prize,
            $this->fifth_prize,
            $this->sixth_prize,
            $this->seventh_prize,
            $this->eighth_prize,
            $this->special_prize,
        ])
            ->flatten()
            ->filter(function ($prize) {
                return !empty($prize) && strlen($prize) >= 2;
            })->values();
    }

    public function getLotoNumbers()
    {
        return $this->getAllNumbers()->map(function ($item) {
            return substr($item, -2);
        });
    }
}
