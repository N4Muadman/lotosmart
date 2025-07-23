<?php

namespace App\Service;

class HandleDateService
{
    public function handleDateLotteryResult($region, $date)
    {
        if ($date) {
            return $date;
        }

        $now = now();
        $today = today();

        switch ($region) {
            case 'XSMB':
                $cutoff = $today->setTime(18, 00);
                break;
            case 'XSMN':
                $cutoff = $today->setTime(16, 00);
                break;
            case 'XSMT':
                $cutoff = $today->setTime(17, 00);
                break;
            default:
                $cutoff = $today->setTime(18, 00);
        }

        $dateToUse = $now->lt($cutoff) ? $now->subDay() : $today;

        return $dateToUse->format('Y-m-d');
    }

    public function handleDateAiPrediction($region)
    {
        $now = now();
        $today = today();

        switch ($region) {
            case 'XSMB':
                $cutoff = $today->setTime(18, 30);
                break;
            case 'XSMN':
                $cutoff = $today->setTime(16, 30);
                break;
            case 'XSMT':
                $cutoff = $today->setTime(17, 30);
                break;
            default:
                $cutoff = $today->setTime(18, 30);
        }

        $date = $now->lt($cutoff) ? $today : $now->addDay();
        return $date->format('Y-m-d');
    }

    public function handleDate(){
        return now()->lt(today()->setTime(18, 30)) ? today() : now()->addDay();
    }
}
