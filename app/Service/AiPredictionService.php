<?php

namespace App\Service;

use App\Models\AiPrediction;
use App\Models\LotoNumber;
use App\Models\LotteryResult;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiPredictionService
{
    public function processNewAiPrediction($numbers, $prediction_date, $province, $region, $type)
    {
        $aiPrediction = AiPrediction::create([
            'prediction_date' => $prediction_date,
            'numbers' => $numbers,
            'province' => $province,
            'region' => $region,
            'prediction_type' => $type,
        ]);

        return $aiPrediction;
    }

    public function AiPredictionSpecialPrize($region, $province, $date)
    {
        $lotoNumberQuery = LotoNumber::where('is_special_prize', true)
            ->where('region', $region)->whereBetween('draw_date', [$date->copy()->subDay(10), $date]);

        $aiPredictionQuery = AiPrediction::byRegion($region)
            ->byType('so_de');
        if ($province) {
            $lotoNumberQuery->where('province', $province);
            $aiPredictionQuery->byProvince($province);
        }

        $lotoNumberByDate = $lotoNumberQuery->get()
            ->keyBy('draw_date');

        $aiPredictions = $aiPredictionQuery->whereBetween('prediction_date', [$date->copy()->subDay(10), $date])
            ->get();

        $stats = collect($aiPredictions)->map(function ($prediction) use ($lotoNumberByDate) {
            $date = $prediction->prediction_date->toDateString();

            if (!isset($lotoNumberByDate[$date])) {
                return null;
            }

            $specialPrize = $lotoNumberByDate[$date]->full_number;
            $tail = $lotoNumberByDate[$date]->loto_number;

            $hit = in_array($tail, $prediction->numbers);

            return [
                'date' => $date,
                'special_prize' => $specialPrize,
                'tail' => $tail,
                'predicted' => $prediction->numbers,
                'hit' => $hit ? 1 : 0,
            ];
        })->filter();

        $maxStreak = 0;
        $currentStreak = 0;

        foreach ($stats as $stat) {
            if ($stat['hit'] === 1) {
                $currentStreak++;
                $maxStreak = max($maxStreak, $currentStreak);
            } else {
                $currentStreak = 0;
            }
        }

        $latestHit = $stats->where('hit', 1)->sortByDesc('date')->first();

        return [
            'stats' => $stats,
            'accuracy_percent' => round($stats->avg('hit') * 100, 2),
            'max_streak' => $maxStreak,
            'latest_hit' => $latestHit
        ];
    }

    public function AiPredictionAllPrizeByDate($region, $province, $date)
    {
        $aiPredictions = AiPrediction::whereDate('prediction_date', $date)->byType('so_lo')->byRegion($region)->get();
        $statis = collect($aiPredictions)->map(function ($prediction) {
            $correct_loto_number_prediction = LotoNumber::SelectRaw('loto_number, count(loto_number) as count')
                ->where('region', $prediction->region)
                ->where('draw_date', $prediction->prediction_date)
                ->whereIn('loto_number', $prediction->numbers)
                ->where('province', $prediction->province)
                ->groupBy('loto_number')
                ->get();

            return [
                'prediction' => $prediction->numbers,
                'date' => $prediction->prediction_date->format('Y-m-d'),
                'region' => $prediction->region,
                'province' => $prediction->province,
                'correct_loto_number' => $correct_loto_number_prediction,
                'accuracy' => count($prediction->numbers) > 0 ? round(count($correct_loto_number_prediction) / count($prediction->numbers) * 100, 2) . '%' : '0%',
            ];
        });

        return $statis;
    }

    public function generateAndStorePredictionForTomorrow($region, $api_add, $api_get_lo, $api_get_de)
    {
        $tomorrow = now()->addDay(1)->format('Y-m-d');
        $aiPredictionXsmbTomorrow = AiPrediction::where('region', $region)->where('prediction_date', $tomorrow);

        $prediction_lo = (clone $aiPredictionXsmbTomorrow)->where('prediction_type', 'so_lo')->first();
        $prediction_de = (clone $aiPredictionXsmbTomorrow)->where('prediction_type', 'so_de')->first();

        $lotteryTodayQuery = LotteryResult::where('region', $region)->where('draw_date', today())->get();

        if ($lotteryTodayQuery->count() === 0) {
            Log::warning('Không tìm thấy kết quả ' . $region . ' hôm nay');
            return;
        }

        $lotteryToday = [
            "date" =>  $tomorrow,
        ];

        foreach ($lotteryTodayQuery as $lt) {
            if ($region === 'XSMB') {
                $lotteryToday['special_prize'] = $lt->special_prize[0];
                $lotteryToday['all_results'] = [
                    "ĐB" => $lt->special_prize,
                    "1" => $lt->first_prize,
                    "2" => $lt->second_prize,
                    "3" => $lt->third_prize,
                    "4" => $lt->fourth_prize,
                    "5" => $lt->fifth_prize,
                    "6" => $lt->sixth_prize,
                    "7" => $lt->seventh_prize,
                ];
            }else{
                $lotteryToday['special_prize'][] = $lt->special_prize[0];
                $lotteryToday['all_results'][$lt->region] = [
                    "ĐB" => $lt->special_prize,
                    "1" => $lt->first_prize,
                    "2" => $lt->second_prize,
                    "3" => $lt->third_prize,
                    "4" => $lt->fourth_prize,
                    "5" => $lt->fifth_prize,
                    "6" => $lt->sixth_prize,
                    "7" => $lt->seventh_prize,
                    "8" => $lt->eighth_prize
                ];
            }
        }
        Log::info($lotteryToday);

        if (!$prediction_lo && !$prediction_de) {
            $responseAddLotteryInAi =  Http::timeout(300)->withHeaders([
                'Accept' => 'application/json',
            ])->post(config('services.base_api_ai') . $api_add, $lotteryToday);

            if ($responseAddLotteryInAi->failed()) {
                Log::error('Thêm dữ liệu ' . $region . ' vào AI không thành công', [
                    'status' => $responseAddLotteryInAi->status(),
                    'body' => $responseAddLotteryInAi->body(),
                ]);
                return;
            }
        }

        if (!$prediction_lo) {
            $getPredictionLoToAI = Http::timeout(300)->withHeaders([
                'Accept' => 'application/json',
            ])->get(config('services.base_api_ai') . $api_get_lo);

            if ($getPredictionLoToAI->failed()) {
                Log::error('Lấy dữ liệu dự đoán ' . $region . ' Lô từ AI không thành công', [
                    'status' => $getPredictionLoToAI->status(),
                    'body' => $getPredictionLoToAI->body(),
                ]);
            }

            Log::info($getPredictionLoToAI->json());
            $new_lo_data = array_keys($getPredictionLoToAI->json());

            // AiPrediction::create([
            //     'prediction_date' => $tomorrow,
            //     'region' => $region,
            //     'prediction_type' => 'so_lo',
            //     'numbers' => $new_lo_data,
            // ]);
        }

        if (!$prediction_de) {
            $getPredictionDeToAI = Http::timeout(1200)->withHeaders([
                'Accept' => 'application/json',
            ])->get(config('services.base_api_ai') . $api_get_de);

            if ($getPredictionDeToAI->failed()) {
                Log::error('Lấy dữ liệu dự đoán ' . $region . ' Đề từ AI không thành công', [
                    'status' => $getPredictionDeToAI->status(),
                    'body' => $getPredictionDeToAI->body(),
                ]);
            }

            Log::info($getPredictionDeToAI->json());
            $new_de_data = array_keys($getPredictionDeToAI->json());

            // AiPrediction::create([
            //     'prediction_date' => $tomorrow,
            //     'region' => $region,
            //     'prediction_type' => 'so_de',
            //     'numbers' => $new_de_data,
            // ]);
        }

        Log::info('Thêm dữ liệu thành công');
        return;
    }
}
