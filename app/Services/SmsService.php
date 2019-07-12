<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/12
 */
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use LeanCloud\Client;
use LeanCloud\SMS;

class SmsService
{
    //public $app = null;

    const TEMPLATE_USER_SIGNED = '云证合同';

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
        // todo 增加次数限制

        // 1分钟检测
        if ($lastTime < (time() - 60)) {
            return true;
        }
        return false;
    }

    /**
     * 设置一分钟缓存
     * @param $mobile
     */
    protected function setValidateSendable($mobile)
    {
        Cache::put("verifySms:{$mobile}", time(), now()->addMinute());
    }

    /**
     * 发送短信
     * @param $mobile
     * @param $data
     */
    protected function sendSMS($mobile, $data)
    {
        SMS::requestSmsCode($mobile, $data);

        // 设置一分钟缓存
        $this->setValidateSendable($mobile);
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

    /**
     * 发送模板短信
     * @param $mobile
     * @param array $data
     * @param string $template
     * @throws \Exception
     */
    public function sendTemplateSms($mobile, $data = [], $template = '')
    {
        if (!$this->validateSendable($mobile)) {
            throw new \Exception('距离上一次发送时间不足一分钟');
        }
        $data = array_merge($data, ['template' => $template]);
        $this->sendSMS($mobile, $data);
    }

}