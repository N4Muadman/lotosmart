<?php

namespace App\Http\Controllers;

use App\Service\HandleDateService;
use App\Service\LotteryResultService;
use Illuminate\Http\Request;
use App\Service\SimulateLotteryDrawService;

class LotteryResultController extends Controller
{
    public function __construct(
        protected LotteryResultService $lottery_result_service,
        protected SimulateLotteryDrawService $simulateService,
        protected HandleDateService $date_service
    ) {}

    public function lotteryResult(Request $request)
    {
        $region = $request->filled('region') ? $request->region : 'XSMB';

        $date = $this->date_service->handleDateLotteryResult($region, $request->date);

        $lottery = $this->lottery_result_service->lotteryResult($region, $date);

        return response()->json($lottery, 200);
    }

    public function insertLotteryResult(Request $request)
    {
        $data = $request->validate([
            '*.province' => 'required|string|max:100',
            '*.prizes' => 'nullable|array',
            '*.prizes.*' => 'nullable|array',
            '*.region' => 'required|string'
        ]);

        $new_lotteries = $this->lottery_result_service->insertLotteryResult($data);

        return response()->json($new_lotteries, 200);
    }

    public function simulateLotteryDraw(Request $request)
    {
        // $request->validate(['region' => 'required']);
        try {
            $region = $request->input('region', 'XSMN');
            $date = $this->date_service->handleDateAiPrediction($region);
            $dataSimulate = $this->simulateService->generateLotteryResult($region, $date);

            return response()->json([
                'dataSimulate' => $dataSimulate,
                'date' => $date
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
