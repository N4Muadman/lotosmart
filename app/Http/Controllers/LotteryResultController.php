<?php

namespace App\Http\Controllers;

use App\Events\LotteryResultSent;
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

        $date = now();
        $newNumberData = [];
        foreach ($data as $station) {
            $new_lottery = $this->lottery_result_service->processNewResult($date, $station['region'], $station['province'], $station['prizes']);
            $newNumberData[] = [
                "region" => $station['region'],
                "province" => $station['province'],
                'prizes' => $new_lottery->getAllNumbers(),
            ];

            if ($new_lottery->region == 'XSMB' && $new_lottery->getAllNumbers()->count() == 27) {
                $this->loto_number_service->processNewResult($new_lottery);
            }else if ($new_lottery->getAllNumbers()->count() == 18){
                $this->loto_number_service->processNewResult($new_lottery);
            }
        }

        broadcast(new LotteryResultSent($newNumberData));
        return response()->json([$newNumberData], 200);
    }

    private function handleDate($region, $date){
        switch ($region){
            case 'XSMB':
                return $date ? $date : (now()->lt(today()->setTime(18, 15)) ? now()->subDay() : today());
                break ;
            case 'XSMN':
                return $date ? $date : (now()->lt(today()->setTime(17, 15)) ? now()->subDay() : today());
                break ;
            case 'XSMT':
                return $date ? $date : (now()->lt(today()->setTime(17, 15)) ? now()->subDay() : today());
                break ;
        }
    }
}
