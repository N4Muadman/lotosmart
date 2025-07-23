<?php

namespace App\Service;

use App\Events\LotteryResultSent;
use App\Jobs\AiPredictionForNextDrawJob;
use App\Models\LotteryResult;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class LotteryResultService
{
    protected $lotoNumberService;

    public function __construct()
    {
        $this->lotoNumberService = app(LotoNumberService::class);
    }

    public function lotteryResult($region, $date)
    {
        if ($region == 'XSMB') {
            $lottery = LotteryResult::where('draw_date', $date)->where('region', $region)->first();

            return [
                'lottery' => $lottery,
                'numbers' => $lottery?->getAllNumbers(),
                'loto' => $lottery?->getLotoNumbers(),
                'date' => $date,
                'region' => $region
            ];

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

            return [
                'results' => $results,
                'date' => $date,
                'region' => $region,
            ];
        }
    }

    public function insertLotteryResult($data){
        $date = now();
        $newNumberData = [];
        $new_lotteries = collect();
        foreach ($data as $station) {
            $new_lottery = $this->processNewResult($date, $station['region'], $station['province'], $station['prizes']);
            $newNumberData[] = [
                "region" => $station['region'],
                "province" => $station['province'],
                'prizes' => $new_lottery->getAllNumbers(),
            ];

            $this->lotoNumberService->processNewResult($new_lottery);
            $new_lotteries->push($new_lottery);
        }

        $checkSuccessInsert = $this->checkSuccessInsert($new_lotteries);
        if ($checkSuccessInsert) {
            AiPredictionForNextDrawJob::dispatch($checkSuccessInsert);
        }

        broadcast(new LotteryResultSent($newNumberData));
        return $newNumberData;
    }

    public function processNewResult(Carbon $date, $region, $province, $prizes)
    {
        if ($region === 'XSMB') {
            return LotteryResult::UpdateOrCreate(
                ['region' => $region, 'draw_date' => $date->toDateString(), 'province' => $province],
                [
                    'special_prize' => $prizes[0] ?? null,
                    'first_prize' => $prizes[1] ?? null,
                    'second_prize' => $prizes[2] ?? null,
                    'third_prize' => $prizes[3] ?? null,
                    'fourth_prize' => $prizes[4] ?? null,
                    'fifth_prize' => $prizes[5] ?? null,
                    'sixth_prize' => $prizes[6] ?? null,
                    'seventh_prize' => $prizes[7] ?? null,
                    'special_code' => $prizes[8] ?? null,
                ]
            );
        } else {
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

    private function checkSuccessInsert($new_lotteries)
    {
        if ($new_lotteries->isEmpty()) {
            return false;
        }

        foreach ($new_lotteries as $new_lottery) {
            $count = $new_lottery->getAllNumbers()->count();

            switch ($new_lottery->region) {
                case 'XSMB':
                    if ($count !== 27) {
                        return false;
                    }
                    break;

                case 'XSMN':
                case 'XSMT':
                    if ($count !== 18) {
                        return false;
                    }
                    break;

                default:
                    return false;
            }
        }

        return $new_lotteries->first()->region;
    }
}
