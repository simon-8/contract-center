<?php

namespace App\Events;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserSign
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contract;
    public $user;
    /**
     * UserConfirm constructor.
     * @param Contract $contract
     * @param User $user
     */
    public function __construct(Contract $contract, User $user)
    {
        $this->contract = $contract;
        $this->user = $user;
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
