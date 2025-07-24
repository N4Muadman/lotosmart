<?php

namespace App\Service;

use App\Models\AiPrediction;
use App\Models\LotteryResult;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JobGetPredictionService
{
    public function generateAndStorePredictionForTomorrow($region, $api_add, $api_get_lo, $api_get_de)
    {
        $tomorrow = now()->addDay()->format('Y-m-d');

        $existingPredictions = AiPrediction::where('region', $region)
            ->where('prediction_date', $tomorrow)
            ->whereIn('prediction_type', ['so_lo', 'so_de'])
            ->pluck('prediction_type')
            ->toArray();

        $prediction_lo_exists = in_array('so_lo', $existingPredictions);
        $prediction_de_exists = in_array('so_de', $existingPredictions);

        if ($prediction_lo_exists && $prediction_de_exists) {
            Log::info("Predictions for {$region} tomorrow already exist");
            return;
        }

        $lotteryTodayQuery = LotteryResult::where('region', $region)
            ->where('draw_date', today())
            ->get();

        if ($lotteryTodayQuery->isEmpty()) {
            Log::warning("Không tìm thấy kết quả {$region} hôm nay");
            return;
        }

        $lotteryToday = $this->formatLotteryData($lotteryTodayQuery, $region);

        // Chỉ gọi API add data nếu cần thiết
        if (!$prediction_lo_exists || !$prediction_de_exists) {
            if (!$this->addLotteryDataToAI($lotteryToday, $api_add, $region)) {
                return; // Stop execution if adding data fails
            }
        }

        // Xử lý prediction lô
        if (!$prediction_lo_exists) {
            $this->processPrediction($region, $tomorrow, $api_get_lo, 'so_lo', 'Lô');
        }

        // Xử lý prediction đề
        if (!$prediction_de_exists) {
            $this->processPrediction($region, $tomorrow, $api_get_de, 'so_de', 'Đề');
        }

        Log::info("Thêm dữ liệu {$region} thành công");
    }

    /**
     * Format lottery data theo region
     */
    private function formatLotteryData($lotteryResults, $region)
    {
        $lotteryToday = [
            "date" => today()->format('d-m-Y'),
        ];

        foreach ($lotteryResults as $lt) {
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
                $lotteryToday['all_results'][$lt->province] = [
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

        return $lotteryToday;
    }

    /**
     * Thêm dữ liệu lottery vào AI
     */
    private function addLotteryDataToAI($lotteryData, $api_add, $region)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders(['Accept' => 'application/json'])
                ->post(config('services.base_api_ai') . $api_add, $lotteryData);

            if ($response->failed()) {
                Log::error("Thêm dữ liệu {$region} vào AI không thành công", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => config('services.base_api_ai') . $api_add
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Exception khi thêm dữ liệu {$region} vào AI", [
                'message' => $e->getMessage(),
                'url' => config('services.base_api_ai') . $api_add
            ]);
            return false;
        }
    }

    /**
     * Xử lý prediction từ AI
     */
    private function processPrediction($region, $tomorrow, $api_endpoint, $prediction_type, $type_name)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders(['Accept' => 'application/json'])
                ->get(config('services.base_api_ai') . $api_endpoint);

            if ($response->failed()) {
                Log::error("Lấy dữ liệu dự đoán {$region} {$type_name} từ AI không thành công", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => config('services.base_api_ai') . $api_endpoint
                ]);
                return false;
            }

            $responseData = $response->json();

            if (!is_array($responseData) || empty($responseData)) {
                Log::error("Kết quả trả về từ AI không hợp lệ cho {$region} {$type_name}", [
                    'response' => $responseData
                ]);
                return false;
            }

            $numbers = collect(array_keys($responseData))
                ->map(fn($number) => str_pad($number, 2, '0', STR_PAD_LEFT))
                ->toArray();

            AiPrediction::create([
                'prediction_date' => $tomorrow,
                'region' => $region,
                'prediction_type' => $prediction_type,
                'numbers' => $numbers,
            ]);

            Log::info("Tạo prediction {$region} {$type_name} thành công", [
                'numbers_count' => count($numbers)
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Exception khi xử lý prediction {$region} {$type_name}", [
                'message' => $e->getMessage(),
                'url' => config('services.base_api_ai') . $api_endpoint
            ]);
            return false;
        }
    }
}
