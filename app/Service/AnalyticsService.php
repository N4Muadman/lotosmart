<?php

namespace App\Service;

use App\Models\LotteryResult;
use Illuminate\Support\Carbon;

class AnalyticsService
{
    public function calculateFrequencies($region, $days = 30)
    {
        $results = LotteryResult::where('region', $region)
            ->where('draw_date', '>=', now()->subDays($days))
            ->get();

        $frequencies = [];

        foreach ($results as $result) {
            $numbers = $result->getAllNumbers();
            foreach ($numbers as $number) {
                $frequencies[$number] = ($frequencies[$number] ?? 0) + 1;
            }
        }

        return $frequencies;
    }

    public function calculateGanDays($region)
    {
        $results = LotteryResult::where('region', $region)
            ->whereBetween('draw_date', ['2025-03-01', '2025-03-30'])
            ->orderByDesc('draw_date')
            ->get();

        if ($results->isEmpty()) {
            return [];
        }

        $ganDays = [];
        $allNumbers = collect(range(0, 99))->map(fn($n) => str_pad($n, 2, '0', STR_PAD_LEFT));
        $today = Carbon::createFromFormat('Y-m-d', '2025-03-30')->startOfDay();

        foreach ($allNumbers as $number) {
            $ganDays[$number] = null;
        }

        foreach ($results as $result) {
            $numbers = $result->getAllNumbers();

            foreach ($numbers as $num) {
                if ($ganDays[$num] === null) {
                    $ganDays[$num] = \Carbon\Carbon::parse($result->draw_date)->startOfDay();
                }
            }

            if (collect($ganDays)->filter()->count() === 100) {
                break;
            }
        }

        $oldestDate = \Carbon\Carbon::parse($results->last()->draw_date)->startOfDay();

        foreach ($ganDays as $number => $lastDate) {
            if ($lastDate) {
                // Số đã từng xuất hiện: tính từ lần cuối + 1
                $ganDays[$number] = $today->diffInDays($lastDate);
            } else {
                // Số chưa từng xuất hiện: tính từ ngày đầu tiên có data
                $ganDays[$number] = $today->diffInDays($oldestDate);
            }
        }

        dd(collect($ganDays)->sortDesc());
        return ;
    }

    public function analyzePatterns($region, $type = 'cau_lo')
    {
        switch ($type) {
            case 'cau_lo':
                return $this->analyzeCauLo($region);
            case 'dan_de':
                // return $this->analyzeDanDe($region);
            case 'xien':
                // return $this->analyzeXien($region);
        }
    }

    private function analyzeCauLo($region)
    {
        // Logic phân tích cầu lô
        $results = LotteryResult::where('region', $region)
            ->orderBy('draw_date', 'desc')
            ->limit(100)
            ->get();

        $gaps = [];
        // Calculate gaps for each number

        return $gaps;
    }
}
