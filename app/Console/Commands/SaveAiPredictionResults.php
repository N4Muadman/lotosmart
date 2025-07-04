<?php

namespace App\Console\Commands;

use App\Service\AiPredictionService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SaveAiPredictionResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:save-ai-prediction-results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    
    public function handle(AiPredictionService $ai_prediction_service)
    {
        $today = Carbon::today()->subDay(2);
        $numbers = ['23', '11', '38', '24', '56', '64', '62', '89', '77', '65'];

        $ai_prediction_service->processNewAiPrediction($numbers, $today, null, 'XSMB', 'so_de');

        $this->info("Lập lịch thành công");
    }
}
