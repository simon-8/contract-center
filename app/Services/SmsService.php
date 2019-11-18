<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/12
 */
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use LeanCloud\Client;
use LeanCloud\SMS;

class SmsService
{
    //public $app = null;

    const TEMPLATE_USER_SIGNED = '云证合同';
    const TEMPLATE_COMPANY_STAFF_APPLY = '用户申请加入公司';
    const TEMPLATE_COMPANY_STAFF_SUCCESS = '加入公司申请通过';
    const TEMPLATE_COMPANY_STAFF_REFUSE = '加入公司被拒绝';
    const TEMPLATE_COMPANY_STAFF_CANCEL = '加入公司申请取消';

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
     * @param bool $validate
     */
    protected function sendSMS($mobile, $data, $validate = true)
    {
        SMS::requestSmsCode($mobile, $data);

        // 设置一分钟缓存
        if ($validate) $this->setValidateSendable($mobile);
    }

    /**
     * 发送验证码
     * @param $mobile
     * @param string $op
     * @param bool $validate
     * @throws \Exception
     */
    public function sendVerifyCode($mobile, $op = '绑定手机', $validate = true)
    {
        if (!$this->validateSendable($mobile)) {
            throw new \Exception('距离上一次发送时间不足一分钟');
        }
        SMS::requestSmsCode($mobile, [
            'op' => $op,
        ]);
        DB::table('laravel_sms')->insert([
            'to' => $mobile,
            //'temp_id' => $template,
            //'data' => json_encode(['code']),
            'content' => $op,
            'sent_time' => now()->timestamp,
            'result_info' => 'ok',
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);
        // 设置一分钟缓存
        if ($validate) Cache::put("verifySms:{$mobile}", time(), now()->addMinute());
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
     * @param bool $validate
     * @throws \Exception
     */
    public function sendTemplateSms($mobile, $data = [], $template = '', $validate = true)
    {
        if ($validate && !$this->validateSendable($mobile)) {
            throw new \Exception('距离上一次发送时间不足一分钟');
        }
        $data = array_merge($data, ['template' => $template]);
        $this->sendSMS($mobile, $data, $validate);
        DB::table('laravel_sms')->insert([
            'to' => $mobile,
            'temp_id' => $template,
            'data' => json_encode($data),
            //'content' => '',
            'sent_time' => now()->timestamp,
            'result_info' => 'ok',
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);
    }
}
