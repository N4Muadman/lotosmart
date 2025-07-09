<?php

namespace App\Jobs;

use App\Service\AiPredictionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AiPredictionXSMBJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ai_prediction_service = app(AiPredictionService::class);
        $ai_prediction_service->generateAndStorePredictionForTomorrow('XSMB', '/add-bac', 'lo-mien-bac', 'de-mien-bac');
    }
}
