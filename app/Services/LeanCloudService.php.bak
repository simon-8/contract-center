<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/19
 */
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use LeanCloud\Client;
use LeanCloud\SMS;

class LeanCloudService
{
    public $app = null;

    public function __construct()
    {
        $config = config('phpsms.agents.LeanCloud');
        Client::initialize($config['appid'], $config['appkey'], $config['master_key']);
    }

    /**
     * 校验是否可进行发送
     * @param $mobile
     * @return bool
     */
    protected function validateSendable($mobile)
    {
        $lastTime = Cache::get("verifySms:{$mobile}");
        if (!$lastTime) {
            return true;
        }
        //if (count($history) > 10) {
        //    array_splice($history, 0, 10);
        //}
        //$lastTime = array_slice($history, -1);
        // 1分钟检测
        if ($lastTime < (time() - 60)) {
            return true;
        }
        return false;
    }

    /**
     * 发送验证码
     * @param $mobile
     * @throws \Exception
     */
    public function sendVerifyCode($mobile)
    {
        if (!$this->validateSendable($mobile)) {
            throw new \Exception('距离上一次发送时间不足一分钟');
        }
        SMS::requestSmsCode($mobile, [
            'op' => '绑定手机'
        ]);

        // 设置一分钟缓存
        Cache::put("verifySms:{$mobile}", time(), now()->addMinute());
    }

    /**
     * 校验验证码
     * @param $mobile
     * @param $code
     */
    public function verifyCode($mobile, $code)
    {
        SMS::verifySmsCode($mobile, $code);
    }
}