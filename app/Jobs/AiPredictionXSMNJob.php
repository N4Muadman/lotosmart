<?php

namespace App\Jobs;

use App\Service\AiPredictionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AiPredictionXSMNJob implements ShouldQueue
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
        $ai_prediction_service->generateAndStorePredictionForTomorrow('XSMN', '/add-nam', 'lo-mien-nam', 'de-mien-nam');
    }
}
