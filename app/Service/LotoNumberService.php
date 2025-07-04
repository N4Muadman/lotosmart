<?php

namespace App\Service;

use App\Models\LotoNumber;
use App\Models\LotteryResult;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class LotoNumberService
{
    public function baseStatis($numbers = [], Carbon $endDate, $daysPeriod, $region)
    {
        $startDate = $endDate->copy()->subDays($daysPeriod);

        $baseQuery = LotoNumber::select('loto_number')
            ->selectRaw('COUNT(*) as frequency')
            ->selectRaw('GROUP_CONCAT(DISTINCT DATE(draw_date) ORDER BY DATE(draw_date) ASC) as draw_dates')
            ->whereIn('loto_number', $numbers)
            ->whereBetween('draw_date', [$startDate, $endDate])
            ->where('region', $region);


        $specialPrizeStats = (clone $baseQuery)
            ->where('is_special_prize', 1)
            ->groupBy('loto_number')
            ->get();

        $allNumberStats = (clone $baseQuery)
            ->groupBy('loto_number')
            ->get();

        $lastAppearanceRecords = LotoNumber::select('loto_number')
            ->selectRaw('MAX(draw_date) as last_draw_date')
            ->selectRaw('DATEDIFF(?, MAX(draw_date)) as days_not_appeared', [$endDate->toDateString()])
            ->whereIn('loto_number', $numbers)
            ->where('draw_date', '<=', $endDate)
            ->where('region', $region)
            ->groupBy('loto_number')
            ->get();

        return [
            'special_prize_stats' => $specialPrizeStats,
            'all_number_stats' => $allNumberStats,
            'lastAppearanceRecords' => $lastAppearanceRecords
        ];
    }

    public function processNewResult(LotteryResult $lottery)
    {
        $list_loto = $lottery->getAllNumbers();
        $newLotoData = [];
        foreach ($list_loto as $key => $loto) {
            $is_special_prize = false;
            if ($lottery->region == 'XSMB' && $key === 26){
                $is_special_prize = true;
            }elseif (in_array($lottery->region, ['XSMN', 'XSMT']) && $key === 17){
                $is_special_prize = true;
            }

            $newLotoData[] = LotoNumber::UpdateOrCreate(
                [
                    'region' => $lottery->region,
                    'draw_date' => $lottery->draw_date,
                    'province' => $lottery->province,
                    'full_number' => $loto,
                ],
                [
                    'is_special_prize' => $is_special_prize,
                    'loto_number' => substr($loto, -2),
                ]
            );
        }

        return $newLotoData;
    }
}
