<?php

use App\Models\GanStatistic;
use App\Models\LotteryResult;

class GanDaysService
{
    public function getGanDays($region, $date = null)
    {
        $date = $date ?? now()->toDateString();
        
        // Kiểm tra cache trước
        $cached = GanStatistic::where('region', $region)
            ->where('calculation_date', $date)
            ->first();
            
        if ($cached && $this->isCacheValid($cached, $region)) {
            return $cached->gan_days;
        }
        
        // Tính toán mới
        $ganDays = $this->calculateGanDays($region);
        
        // Lưu vào cache
        $this->saveGanDays($region, $date, $ganDays);
        
        return $ganDays;
    }
    
    private function isCacheValid($cached, $region)
    {
        // Kiểm tra xem có kết quả mới sau lần tính cuối không
        $latestResult = LotteryResult::where('region', $region)
            ->orderByDesc('draw_date')
            ->first();
            
        return $latestResult && 
               $latestResult->draw_date <= $cached->last_draw_date;
    }
    
    private function saveGanDays($region, $date, $ganDays)
    {
        $latestDrawDate = LotteryResult::where('region', $region)
            ->orderByDesc('draw_date')
            ->value('draw_date');
            
        GanStatistic::updateOrCreate(
            [
                'region' => $region,
                'calculation_date' => $date
            ],
            [
                'gan_days' => $ganDays,
                'last_draw_date' => $latestDrawDate
            ]
        );
    }
    
    // Tính gan days (code đã sửa từ trước)
    private function calculateGanDays($region)
    {
        $results = LotteryResult::where('region', $region)
            ->orderByDesc('draw_date')
            ->get();
        
        if ($results->isEmpty()) {
            return [];
        }
        
        $ganDays = [];
        $allNumbers = collect(range(0, 99))->map(fn($n) => str_pad($n, 2, '0', STR_PAD_LEFT));
        $today = now()->startOfDay();
        
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
                $ganDays[$number] = $today->diffInDays($lastDate);
            } else {
                $ganDays[$number] = $today->diffInDays($oldestDate);
            }
        }
        
        return $ganDays;
    }
    
    // Cleanup old data (chạy daily)
    public function cleanupOldData($keepDays = 30)
    {
        GanStatistic::where('calculation_date', '<', now()->subDays($keepDays))
            ->delete();
    }
    
    // Force recalculate (khi có data mới)
    public function recalculateForRegion($region)
    {
        // Xóa cache hiện tại
        GanStatistic::where('region', $region)
            ->where('calculation_date', now()->toDateString())
            ->delete();
            
        // Tính toán lại
        return $this->getGanDays($region);
    }
}