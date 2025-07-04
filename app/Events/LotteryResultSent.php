<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LotteryResultSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lottery_result;

    public function __construct($lottery_result)
    {
        $this->lottery_result = $lottery_result;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('lottery-result'),
        ];
    }

    public function broadcastWith(): array
    {
        return $this->lottery_result;
    }

    public function broadcastAs()
    {
        return 'lottery.sent';
    }
}
