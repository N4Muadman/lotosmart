<?php

namespace App\Http\Controllers;

use App\Models\LotteryResult;
use App\Service\AiPredictionService;
use App\Service\LotoNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class StatisticsController extends Controller
{
    public function __construct(protected LotoNumberService $lotoNumberService, protected AiPredictionService $ai_prediction_service) {}

    public function baseStatis(Request $request)
    {
        $numbers = $request->numbers ? explode(',', $request->numbers) : $this->generateRandomNumbers();
        $date = $request->date ? Carbon::createFromFormat('Y-m-d', $request->date) : now();
        $daysPeriod = $request->days_period ?? 7;
        $region = $request->region ?? 'XSMB';

        $stats = $this->lotoNumberService->baseStatis($numbers, $date, $daysPeriod, $region);

        return response()->json($stats, 200);
    }

    public function AiPredictionSpecialPrize(Request $request)
    {
        $region = $request->filled('region') ? $request->region : 'XSMB';
        $province = $request->filled('province') ? $request->region : null;

        if ($region === 'XSMB') {
            $date = now()->lt(today()->setTime(18, 30)) ? now()->subDay() : today();
        } else if ($region === 'XSMN') {
            $date = now()->lt(today()->setTime(16, 30)) ? now()->subDay() : today();
        } else if ($region === 'XSMT') {
            $date = now()->lt(today()->setTime(17, 30)) ? now()->subDay() : today();
        }

        $special_prize = $this->ai_prediction_service->AiPredictionSpecialPrize($region, $province, $date);

        $all_prize = $this->ai_prediction_service->AiPredictionAllPrizeByDate($region, $province, $date);

        return response()->json([
            'special_prize' => $special_prize,
            'all_prize' => $all_prize
        ], 200);
    }


    private function generateRandomNumbers($count = 3)
    {
        $numbers = [];
        $range = range(0, 99);
        shuffle($range);
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = str_pad($range[$i], 2, '0', STR_PAD_LEFT);
        }
        return $numbers;
    }
}
