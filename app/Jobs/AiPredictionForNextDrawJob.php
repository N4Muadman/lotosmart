<?php

namespace App\Jobs;

use App\Service\AiPredictionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AiPredictionForNextDrawJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $region)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $init = match ($this->region){
            'XSMB' => [
                'region' => 'XSMB',
                'api_add' => '/add-bac',
                'api_get_lo' => '/lo-mien-bac',
                'api_get_de' => '/de-mien-bac'
            ],
            'XSMN' => [
                'region' => 'XSMN',
                'api_add' => '/add-nam',
                'api_get_lo' => '/lo-mien-nam',
                'api_get_de' => '/de-mien-nam'
            ],
            'XSMT' => [
                'region' => 'XSMT',
                'api_add' => '/add-trung',
                'api_get_lo' => '/lo-mien-trung',
                'api_get_de' => '/de-mien-trung'
            ],
        };

        $service = app(AiPredictionService::class);

        $service->generateAndStorePredictionForTomorrow($init['region'], $init['api_add'], $init['api_get_lo'], $init['api_get_de']);
    }
}
