<?php

namespace App\Events;

use App\Models\Contract;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlatformSign
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contract;

    /**
     * UserConfirm constructor.
     * @param Contract $contract
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
