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

        $aiPredictions = $aiPredictionQuery->whereBetween('prediction_date', [$date->copy()->subDay(10), $date])->orderByDesc('prediction_date')
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
        $aiPredictions = AiPrediction::whereDate('prediction_date', $date)->byType('so_lo')->byRegion($region)->first();

        $statis = null;

        if ($aiPredictions) {
            $correct_loto_number_prediction = LotoNumber::selectRaw('loto_number, count(loto_number) as count')
                ->where('region', $aiPredictions->region)
                ->where('draw_date', $aiPredictions->prediction_date)
                ->whereIn('loto_number', $aiPredictions->numbers)
                ->groupBy('loto_number')
                ->get();

            $statis = [
                'prediction' => $aiPredictions->numbers,
                'date' => $aiPredictions->prediction_date->format('Y-m-d'),
                'region' => $aiPredictions->region,
                'province' => $aiPredictions->province,
                'correct_loto_number' => $correct_loto_number_prediction,
                'accuracy' => count($aiPredictions->numbers) > 0
                    ? round(count($correct_loto_number_prediction) / count($aiPredictions->numbers) * 100, 2) . '%'
                    : '0%',
            ];
        }

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
            "date" =>  today()->format('d-m-Y'),
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
            } else {
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

        if (!$prediction_lo && !$prediction_de) {
            $responseAddLotteryInAi =  Http::withHeaders([
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
            $getPredictionLoToAI = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get(config('services.base_api_ai') . $api_get_lo);

            if ($getPredictionLoToAI->failed()) {
                Log::error('Lấy dữ liệu dự đoán ' . $region . ' Lô từ AI không thành công', [
                    'status' => $getPredictionLoToAI->status(),
                    'body' => $getPredictionLoToAI->body(),
                ]);
            }

            $responseData = $getPredictionLoToAI->json();
            if (!is_array($responseData)) {
                Log::error('Kết quả trả về từ AI không hợp lệ ' . $getPredictionLoToAI->json());
            }
            $new_lo_data = [];

            foreach (array_keys($responseData) as $nd) {
                $new_lo_data[] = str_pad($nd, 2, '0', STR_PAD_LEFT);
            }

            AiPrediction::create([
                'prediction_date' => $tomorrow,
                'region' => $region,
                'prediction_type' => 'so_lo',
                'numbers' => $new_lo_data,
            ]);
        }

        if (!$prediction_de) {
            $getPredictionDeToAI = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get(config('services.base_api_ai') . $api_get_de);

            if ($getPredictionDeToAI->failed()) {
                Log::error('Lấy dữ liệu dự đoán ' . $region . ' Đề từ AI không thành công', [
                    'status' => $getPredictionDeToAI->status(),
                    'body' => $getPredictionDeToAI->body(),
                ]);
            }

            $responseDataDe = $getPredictionDeToAI->json();
            if (!is_array($responseData)) {
                Log::error('Kết quả trả về từ AI không hợp lệ ' . $getPredictionLoToAI->json());
            }
            $new_de_data = [];

            foreach (array_keys($responseDataDe) as $nd) {
                $new_de_data[] = str_pad($nd, 2, '0', STR_PAD_LEFT);
            }

            AiPrediction::create([
                'prediction_date' => $tomorrow,
                'region' => $region,
                'prediction_type' => 'so_de',
                'numbers' => $new_de_data,
            ]);
        }

        Log::info('Thêm dữ liệu thành công');
        return;
    }

    public function getAiPredictionForNextDraw($request)
    {
        if ($request->add_number == 'show-lo') {
            session(['show_lo' => now()->addMinutes(5)]);
        }
        if ($request->add_number == 'show-de') {
            session(['show_de' => now()->addMinutes(5)]);
        }
        if ($request->add_number == 'show-xien') {
            session(['show_xien' => now()->addMinutes(5)]);
        }

        $region = $request->filled('region') ? $request->region : 'XSMB';
        $date = $this->handleDate($region);

        $predictionQuery = AiPrediction::where('region', $region)->where('prediction_date', $date);

        $prediction_lo = (clone $predictionQuery)->where('prediction_type', 'so_lo')->first();
        $prediction_de = (clone $predictionQuery)->where('prediction_type', 'so_de')->first();

        $number_lo = [];
        $number_de = [];

        $now = now();

        if ($prediction_lo) {
            $isShowLo = session('show_lo') && session('show_lo') > $now;
            $isShowXien = session('show_xien') && session('show_xien') > $now;

            $number_lo = $this->generateNumberPrediction($isShowLo, $prediction_lo->numbers);
            $number_lo['xien_2'] = $this->generateXienCombinations($prediction_lo->numbers, 2, $isShowXien);
        }
        if ($prediction_de) {
            $isShowDe = session('show_de') && session('show_de') > $now;

            $number_de = $this->generateNumberPrediction($isShowDe, $prediction_de->numbers);
        }

        return [
            'so_lo' => $number_lo,
            'so_de' => $number_de,
        ];
    }

    private function generateNumberPrediction($show, $numbers)
    {
        $kep_numbers = array_filter($numbers, function ($num) {
            if (strlen($num) !== 2) {
                return false;
            }

            return $num[0] === $num[1];
        });

        if ($show) {
            return [
                'all_numbers' => $numbers,
                'kep_numbers' => array_values($kep_numbers),
            ];
        } else {
            return [
                'all_numbers' => array_slice($numbers, 0, 2),
                'kep_numbers' => array_slice($kep_numbers, 0, 2),
            ];
        }
    }

    private function generateXienCombinations(array $numbers, int $size, bool $show): array
    {
        if ($size > count($numbers)) {
            return [];
        }

        $combinations = [];
        $indices = range(0, count($numbers) - 1);

        foreach ($this->getCombinations($indices, $size) as $combination) {
            $combo = [];
            foreach ($combination as $index) {
                $combo[] = str_pad($numbers[$index], 2, '0', STR_PAD_LEFT);
            }
            $combinations[] = $combo;
        }

        return $show ? array_slice($combinations, 0, 5) : array_slice($combinations, 0, 2);
    }

    private function getCombinations(array $array, int $size): array
    {
        if ($size == 0) {
            return [[]];
        }

        if (count($array) == 0) {
            return [];
        }

        $combinations = [];
        $first = array_shift($array);

        foreach ($this->getCombinations($array, $size - 1) as $combination) {
            $combinations[] = array_merge([$first], $combination);
        }

        foreach ($this->getCombinations($array, $size) as $combination) {
            $combinations[] = $combination;
        }

        return $combinations;
    }

    private function handleDate($region)
    {
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
                // fallback: mặc định giống XSMB
                $cutoff = $today->setTime(18, 30);
        }

        $date = $now->lt($cutoff) ? $today : $now->addDay();
        return $date->format('Y-m-d');
    }
}
