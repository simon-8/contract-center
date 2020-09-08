<?php

namespace App\Console\Commands;

use App\Models\UserOauth;
use Illuminate\Console\Command;

class UpdatePassword extends Command
{
    protected $signature = 'update:password';

    protected $description = '更新用户密码';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // 更新用户密码
        $userOauths = UserOauth::where('unionid', '<>', '')->get();
        foreach ($userOauths as $userOauth) {
            $userOauth->user->password = md5($userOauth->unionid);
            $userOauth->user->save();
        }
    }
}
