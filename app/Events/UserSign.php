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

    public $contract; // 合同
    public $user; // 用户
    public $mobile; // 签署手机号
    public $captcha; // 签署验证码

    /**
     * UserSign constructor.
     * @param Contract $contract
     * @param User $user
     * @param string $mobile
     * @param string $captcha
     */
    public function __construct(Contract $contract, User $user, $mobile = '', $captcha = '')
    {
        $this->contract = $contract;
        $this->user = $user;
        $this->mobile = $mobile;
        $this->captcha = $captcha;
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
