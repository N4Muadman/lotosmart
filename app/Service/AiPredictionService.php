<?php

namespace App\Service;

use App\Models\AiPrediction;
use App\Models\LotoNumber;
use Illuminate\Support\Carbon;
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
}
