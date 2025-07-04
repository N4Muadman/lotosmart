<?php

namespace App\Service;

use App\Models\LotteryResult;
use Illuminate\Support\Carbon;

class LotteryResultService
{
    public function processNewResult(Carbon $date, $region, $province, $prizes)
    {
        if ($region === 'XSMB') {
            return LotteryResult::UpdateOrCreate(
                ['region' => $region, 'draw_date' => $date->toDateString(), 'province' => $province],
                [
                    'special_prize' => $prizes[7] ?? null,
                    'first_prize' => $prizes[0] ?? null,
                    'second_prize' => $prizes[1] ?? null,
                    'third_prize' => $prizes[2] ?? null,
                    'fourth_prize' => $prizes[3] ?? null,
                    'fifth_prize' => $prizes[4] ?? null,
                    'sixth_prize' => $prizes[5] ?? null,
                    'seventh_prize' => $prizes[6] ?? null,
                    'eighth_prize' => $prizes[8] ?? null,
                ]
            );
        } else{
            return LotteryResult::UpdateOrCreate(
                ['region' => $region, 'draw_date' => $date->toDateString(), 'province' => $province],
                [
                    'special_prize' => $prizes[8] ?? null,
                    'first_prize' => $prizes[7] ?? null,
                    'second_prize' => $prizes[6] ?? null,
                    'third_prize' => $prizes[5] ?? null,
                    'fourth_prize' => $prizes[4] ?? null,
                    'fifth_prize' => $prizes[3] ?? null,
                    'sixth_prize' => $prizes[2] ?? null,
                    'seventh_prize' => $prizes[1] ?? null,
                    'eighth_prize' => $prizes[0] ?? null,
                ]
            );
        }
    }
}
