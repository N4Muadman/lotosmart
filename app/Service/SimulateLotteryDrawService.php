<?php

namespace App\Service;

use App\Models\AiPrediction;
use Illuminate\Support\Carbon;

class SimulateLotteryDrawService
{
    public function generateLotteryResult($region, $date = null)
    {
        $date = $date ?? Carbon::today()->format('Y-m-d');

        $loPredictions = $this->getPredictions($region, 'so_lo', $date);
        $dePredictions = $this->getPredictions($region, 'so_de', $date);

        if (empty($loPredictions) || empty($dePredictions)) {
            throw new \Exception('Không có dữ liệu dự đoán cho ngày này');
        }

        // Lấy cấu trúc giải theo miền
        $prizeStructure = $this->getPrizeStructure($region);

        if ($region === 'XSMB') {
            $allNumbers = [
                $this->generateAllPrizes($loPredictions, $prizeStructure),
                $this->generateSpecialPrize($dePredictions, $prizeStructure['special_prize']['length'])
            ];

            $result = collect($allNumbers)->flatten()->filter(function ($prize) {
                return !empty($prize) && strlen($prize) >= 2;
            })->values();
        } else {
            $provinces = $this->getProvincesForDate($date, $region);

            foreach ($provinces as $province) {
                $allNumbers = [
                    $this->generateAllPrizes($loPredictions, $prizeStructure),
                    $this->generateSpecialPrize($dePredictions, $prizeStructure['special_prize']['length'])
                ];

                $result[] = [
                    'lottery' => [
                        'province' => $province,
                        'allNumbers' => collect($allNumbers)->flatten()->filter(function ($prize) {
                            return !empty($prize) && strlen($prize) >= 2;
                        })->values()
                    ]
                ];
            }
        }

        return $result;
    }

    private function getPrizeStructure($region)
    {
        $structures = [
            'XSMB' => [
                'special_prize' => ['count' => 1, 'length' => 5],
                'first_prize' => ['count' => 1, 'length' => 5],
                'second_prize' => ['count' => 2, 'length' => 5],
                'third_prize' => ['count' => 6, 'length' => 5],
                'fourth_prize' => ['count' => 4, 'length' => 4],
                'fifth_prize' => ['count' => 6, 'length' => 4],
                'sixth_prize' => ['count' => 3, 'length' => 3],
                'seventh_prize' => ['count' => 4, 'length' => 2]
            ],
            'XSMT' => [
                'eighth_prize' => ['count' => 1, 'length' => 2],
                'seventh_prize' => ['count' => 1, 'length' => 2],
                'sixth_prize' => ['count' => 3, 'length' => 3],
                'fifth_prize' => ['count' => 1, 'length' => 4],
                'fourth_prize' => ['count' => 7, 'length' => 4],
                'third_prize' => ['count' => 2, 'length' => 5],
                'second_prize' => ['count' => 1, 'length' => 5],
                'first_prize' => ['count' => 1, 'length' => 5],
                'special_prize' => ['count' => 1, 'length' => 6],
            ],
            'XSMN' => [
                'eighth_prize' => ['count' => 1, 'length' => 2],
                'seventh_prize' => ['count' => 1, 'length' => 2],
                'sixth_prize' => ['count' => 3, 'length' => 3],
                'fifth_prize' => ['count' => 1, 'length' => 4],
                'fourth_prize' => ['count' => 7, 'length' => 4],
                'third_prize' => ['count' => 2, 'length' => 5],
                'second_prize' => ['count' => 1, 'length' => 5],
                'first_prize' => ['count' => 1, 'length' => 5],
                'special_prize' => ['count' => 1, 'length' => 6],
            ]
        ];

        return $structures[$region] ?? $structures['XSMB'];
    }

    private function generateAllPrizes($loPredictions, $prizeStructure)
    {
        $allPrizes = [];
        $totalNumbers = 0;

        // Đếm tổng số lượng số cần tạo (trừ giải đặc biệt)
        foreach ($prizeStructure as $prizeName => $config) {
            if ($prizeName !== 'special_prize') {
                $totalNumbers += $config['count'];
            }
        }

        // Tạo danh sách tất cả số trước (ngẫu nhiên)
        $allNumbers = [];
        foreach ($prizeStructure as $prizeName => $config) {
            if ($prizeName !== 'special_prize') {
                for ($i = 0; $i < $config['count']; $i++) {
                    $allNumbers[] = [
                        'prize' => $prizeName,
                        'number' => $this->generateRandomNumber($config['length']),
                        'length' => $config['length']
                    ];
                }
            }
        }

        // Chọn một số vị trí ngẫu nhiên để thay thế bằng số dự đoán
        $predictionCount = min(count($loPredictions), $totalNumbers);
        $randomPositions = array_rand($allNumbers, $predictionCount);

        if (!is_array($randomPositions)) {
            $randomPositions = [$randomPositions];
        }

        $shuffledPredictions = $this->shuffleArray($loPredictions);

        // Thay thế các vị trí được chọn bằng số có 2 số cuối là dự đoán
        for ($i = 0; $i < $predictionCount; $i++) {
            $position = $randomPositions[$i];
            $loNumber = $shuffledPredictions[$i];
            $length = $allNumbers[$position]['length'];

            $allNumbers[$position]['number'] = $this->generateNumberWithLength($loNumber, $length);
        }

        // Phân loại lại theo từng giải
        foreach ($allNumbers as $item) {
            if (!isset($allPrizes[$item['prize']])) {
                $allPrizes[$item['prize']] = [];
            }
            $allPrizes[$item['prize']][] = $item['number'];
        }

        return $allPrizes;
    }

    private function getPredictions($region, $type, $date)
    {
        $prediction = AiPrediction::where('region', $region)
            ->where('prediction_type', $type)
            ->where('prediction_date', $date)
            ->first();

        if (!$prediction) {
            return [];
        }

        return $prediction->numbers;
    }

    private function generateSpecialPrize($dePredictions, $numberLength)
    {
        $shuffled = $this->shuffleArray($dePredictions);
        $selectedDe = $shuffled[array_rand($shuffled)];

        if ($numberLength == 5) {
            $prefix = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
        } else { // 6 số
            $prefix = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        }

        return $prefix . $selectedDe;
    }

    /**
     * Tạo số với độ dài cụ thể, kết thúc bằng số lô
     */
    private function generateNumberWithLength($loNumber, $totalLength)
    {
        if ($totalLength == 2) {
            return str_pad($loNumber, 2, '0', STR_PAD_LEFT);
        }

        $prefixLength = $totalLength - 2;
        $prefix = str_pad(random_int(0, pow(10, $prefixLength) - 1), $prefixLength, '0', STR_PAD_LEFT);

        return $prefix . str_pad($loNumber, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Tạo số hoàn toàn ngẫu nhiên với độ dài cụ thể
     */
    private function generateRandomNumber($totalLength)
    {
        return str_pad(random_int(0, pow(10, $totalLength) - 1), $totalLength, '0', STR_PAD_LEFT);
    }

    private function shuffleArray($array)
    {
        $shuffled = $array;
        shuffle($shuffled);
        return $shuffled;
    }

    public function getProvincesForDate($date, $region = null)
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        $schedule = config('lottery_schedule.schedule');

        if (!isset($schedule[$dayOfWeek])) {
            return [];
        }

        if ($region) {
            return $schedule[$dayOfWeek][$region] ?? [];
        }

        return $schedule[$dayOfWeek];
    }
}
