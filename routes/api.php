<?php

use App\Http\Controllers\LotteryResultController;
use App\Http\Controllers\StatisticsController;
use App\Models\LotteryResult;
use App\Service\LotoNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/import-xsmb', function () {
    $path = storage_path('app/public/xsmb_data.json');

    if (!file_exists($path)) {
        return 'notfound';
    }

    $data = json_decode(file_get_contents($path), true);
    $dataLottery = [];
    foreach ($data as $item) {
        $dataLottery = [
            'region' => 'XSMB',
            'draw_date' => Carbon::createFromFormat('d-m-Y', $item['date'])->format('Y-m-d'),
            'special_code' => $item['codes'],
            'special_prize' => $item['all_results']['ĐB'],
            'first_prize' => $item['all_results']['1'],
            'second_prize' => $item['all_results']['2'],
            'third_prize' => $item['all_results']['3'],
            'fourth_prize' => $item['all_results']['4'],
            'fifth_prize' => $item['all_results']['5'],
            'sixth_prize' => $item['all_results']['6'],
            'seventh_prize' => $item['all_results']['7'],
        ];
        LotteryResult::create($dataLottery);
    }

    return 'oke';
});

Route::get('/import-xsmn', function () {
    set_time_limit(300);
    $path = storage_path('app/public/xsmn_data.json');

    if (!file_exists($path)) {
        return 'notfound';
    }

    $data = json_decode(file_get_contents($path), true);
    $dataLottery = [];
    foreach ($data as $item) {
        foreach ($item['all_results'] as $key => $results) {
            $dataLottery = [
                'region' => 'XSMN',
                'draw_date' => Carbon::createFromFormat('d-m-Y', $item['date'])->format('Y-m-d'),
                'special_prize' => $results['ĐB'],
                'first_prize' => $results['1'],
                'second_prize' => $results['2'],
                'third_prize' => $results['3'],
                'fourth_prize' => $results['4'],
                'fifth_prize' => $results['5'],
                'sixth_prize' => $results['6'],
                'seventh_prize' => $results['7'],
                'eighth_prize' => $results['8'],
                'province' => $key
            ];
            LotteryResult::create($dataLottery);
        }
    }

    return 'oke';
});

Route::get('import-loto-number', function () {
    $lotoNumberService = new LotoNumberService;
    $lottery = LotteryResult::whereBetween('draw_date', ['2024-06-10', '2025-06-20'])->get();

    foreach($lottery as $lt){
        $lotoNumberService->processNewResult($lt);
    }

    return 'oke';
});


Route::get('lottery-result', [LotteryResultController::class, 'lotteryResult']);
Route::get('base-statis', [StatisticsController::class, 'baseStatis']);
Route::get('ai-prediction-special-prize', [StatisticsController::class, 'AiPredictionSpecialPrize']);

Route::post('new-lottery-results', [LotteryResultController::class, 'insertLotteryResult']);
