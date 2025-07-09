<?php

namespace App\Jobs;

use App\Service\AiPredictionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AiPredictionXSMTJob implements ShouldQueue
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
        $ai_prediction_service->generateAndStorePredictionForTomorrow('XSMT', '/add-trung', 'lo-mien-trung', 'de-mien-trung');
    }
}
