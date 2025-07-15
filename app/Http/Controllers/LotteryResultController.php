<?php

namespace App\Http\Controllers;

use App\Events\LotteryResultSent;
use App\Jobs\AiPredictionForNextDrawJob;
use App\Models\LotteryResult;
use App\Service\LotoNumberService;
use App\Service\LotteryResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class LotteryResultController extends Controller
{
    public function __construct(protected LotteryResultService $lottery_result_service, protected LotoNumberService $loto_number_service) {}

    public function lotteryResult(Request $request)
    {
        $region = $request->filled('region') ? $request->region : 'XSMB';

        $date = $this->handleDate($region, $request->date);

        if ($region == 'XSMB') {
            $lottery = LotteryResult::where('draw_date', $date)->where('region', $region)->first();

            return response()->json(['lottery' => $lottery, 'numbers' => $lottery?->getAllNumbers(), 'loto' => $lottery?->getLotoNumbers(), 'date' => $date, 'region' => $region], 200);
        } else {
            $lotteries = LotteryResult::where('draw_date', $date)->where('region', $region)->get();

            $results = [];

            foreach ($lotteries as $lottery) {
                $results[] = [
                    'lottery' => $lottery,
                    'numbers' => $lottery?->getAllNumbers(),
                    'loto' => $lottery?->getLotoNumbers(),
                ];
            }

            return response()->json([
                'results' => $results,
                'date' => $date,
                'region' => $region,
            ]);
        }
    }

    public function insertLotteryResult(Request $request)
    {
        $data = $request->validate([
            '*.province' => 'required|string|max:100',
            '*.prizes' => 'nullable|array',
            '*.prizes.*' => 'nullable|array',
            '*.region' => 'required|string'
        ]);

        Log::info($data);

        $date = now();
        $newNumberData = [];
        foreach ($data as $station) {
            $new_lottery = $this->lottery_result_service->processNewResult($date, $station['region'], $station['province'], $station['prizes']);
            $newNumberData[] = [
                "region" => $station['region'],
                "province" => $station['province'],
                'prizes' => $new_lottery->getAllNumbers(),
            ];

            $this->loto_number_service->processNewResult($new_lottery);

            $count = $new_lottery->getAllNumbers()->count();
            switch (true) {
                case $new_lottery->region === 'XSMB' && $count === 27:
                    AiPredictionForNextDrawJob::dispatch('XSMB');
                    break;
                case $new_lottery->region === 'XSMN' && $count === 18:
                    AiPredictionForNextDrawJob::dispatch('XSMN');
                    break;
                case $new_lottery->region === 'XSMT' && $count === 18:
                    AiPredictionForNextDrawJob::dispatch('XSMT');
                    break;
            }
        }

        broadcast(new LotteryResultSent($newNumberData));
        return response()->json([$newNumberData], 200);
    }

    private function handleDate($region, $date)
    {
        if ($date) {
            return $date;
        }

        $now = now();
        $today = today();

        switch ($region) {
            case 'XSMB':
                $cutoff = $today->setTime(18, 30);
                break;
            case 'XSMN':
                $cutoff = $today->setTime(16, 30);
                break;
            case 'XSMT':
                $cutoff = $today->setTime(17, 30);
                break;
            default:
                $cutoff = $today->setTime(18, 30);
        }

        $dateToUse = $now->lt($cutoff) ? $now->subDay() : $today;

        return $dateToUse->format('Y-m-d');
    }
}
