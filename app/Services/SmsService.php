<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/12
 */
namespace App\Services;

use App\Models\Company;
use App\Models\CompanyStaff;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use LeanCloud\Client;
use LeanCloud\SMS;

class SmsService
{
    // 给职员发的
    const TPL_COMPANY_STAFF_BE_CANCEL = '主动取消公司授权';// 被取消
    const TPL_COMPANY_STAFF_APPLY_STATUS = '加入公司申请状态';// 已通过 已拒绝
    const TPL_COMPANY_STAFF_USER_CANCEL = '取消授权申请状态';// 取消成功, 取消失败

    // 管理员
    const TPL_COMPANY_STAFF_USER_APPLY = '用户申请加入公司'; // 申请加入
    //const TPL_COMPANY_STAFF_USER_APPLY_CANCEL = '公司授权申请取消';

    const TPL_CONTRACT_SIGNING = '签约过程通知';
    const TPL_CONTRACT_SIGNED = '云证合同';
    const TPL_CONTRACT_SAVE = '合同保存通知';
    const TPL_CONTRACT_LAWYER_APPLY = '申请见证通知';
    const TPL_CONTRACT_EXPRESS = '快递寄出通知';

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

    /**
     * 被公司取消授权 (给指定用户)
     * @param CompanyStaff $companyStaff
     */
    public function companyStaffBeCancel(CompanyStaff $companyStaff)
    {
        try {
            $this->sendTemplateSms($companyStaff->user->mobile, [
                'company' => $companyStaff->company->name,
            ], self::TPL_COMPANY_STAFF_BE_CANCEL);
        } catch (\Exception $e) {
            logger(__METHOD__, [$companyStaff->company, $companyStaff->user, $e->getMessage()]);
        }
    }

    /**
     * 加入公司申请状态 (给指定用户)
     * @param CompanyStaff $companyStaff
     */
    public function companyStaffApplyStatus(CompanyStaff $companyStaff)
    {
        try {
            $this->sendTemplateSms($companyStaff->user->mobile, [
                'company' => $companyStaff->company->name,
                'status' => $companyStaff->getStatusText(),
            ], self::TPL_COMPANY_STAFF_APPLY_STATUS);
        } catch (\Exception $e) {
            logger(__METHOD__, [$companyStaff->company, $companyStaff->user, $e->getMessage()]);
        }
    }

    /**
     * 取消授权申请状态 (给指定用户)
     * @param CompanyStaff $companyStaff
     */
    public function companyStaffUserCancel(CompanyStaff $companyStaff)
    {
        try {
            $this->sendTemplateSms($companyStaff->user->mobile, [
                'company' => $companyStaff->company->name,
                'status' => $companyStaff->getStatusText(),
            ], self::TPL_COMPANY_STAFF_USER_CANCEL);
        } catch (\Exception $e) {
            logger(__METHOD__, [$companyStaff->company, $companyStaff->user, $e->getMessage()]);
        }
    }

    /**
     * 用户申请加入公司 (给管理员)
     * @param CompanyStaff $companyStaff
     */
    public function companyStaffUserApply(CompanyStaff $companyStaff)
    {
        try {
            $this->sendTemplateSms($companyStaff->company->user->mobile, [
                'company' => $companyStaff->company->name,
            ], self::TPL_COMPANY_STAFF_USER_APPLY);
        } catch (\Exception $e) {
            logger(__METHOD__, [$companyStaff->company, $companyStaff->user, $e->getMessage()]);
        }
    }

    /**
     * 合同已签字 (给其他人)
     * @param Contract $contract
     * @param User $user
     */
    public function contractSigned(Contract $contract, User $user)
    {
        $targetUsers = [];
        if ($contract->userFirst && $contract->userFirst->id != $user->id) $targetUsers[$contract->jiafang] = $contract->userFirst;
        if ($contract->userSecond && $contract->userSecond->id != $user->id) $targetUsers[$contract->yifang] = $contract->userSecond;
        if ($contract->userThree && $contract->userThree->id != $user->id) $targetUsers[$contract->jujianren] = $contract->userThree;

        foreach ($targetUsers as $name => $targetUser) {
            try {
                $this->sendTemplateSms($targetUser->mobile, [
                    'title' => $contract->name,
                    'name' => $name,
                ], self::TPL_CONTRACT_SIGNED);
            } catch (\Exception $e) {
                logger(__METHOD__, [$targetUser, $name, $e->getMessage()]);
            }
        }
    }

    /**
     * 合同签约中 (给用户)
     * @param User $user
     */
    public function contractSigning(User $user)
    {
        try {
            $this->sendTemplateSms($user->mobile, [
                'name' => '',
            ], self::TPL_CONTRACT_SIGNING);
        } catch (\Exception $e) {
            logger(__METHOD__, [$user, $e->getMessage()]);
        }
    }

    /**
     * 合同保存通知 (给所有人)
     * @param Contract $contract
     */
    public function contractSave(Contract $contract)
    {
        $targetUsers = [];
        if ($contract->userFirst) $targetUsers[$contract->jiafang] = $contract->userFirst;
        if ($contract->userSecond) $targetUsers[$contract->yifang] = $contract->userSecond;
        if ($contract->userThree) $targetUsers[$contract->jujianren] = $contract->userThree;
        foreach ($targetUsers as $targetUser) {
            try {
                $this->sendTemplateSms($targetUser->mobile, [
                    'number' => $contract->number_text,
                    'name' => $contract->name,
                    'address' => __('contract.appname'),
                    'time' => $contract->expired_at,
                ], self::TPL_CONTRACT_SAVE);
            } catch (\Exception $e) {
                logger(__METHOD__, [$targetUser, $contract, $e->getMessage()]);
            }
        }
    }

    /**
     * 合同寄出 (给用户)
     * @param User $user
     * @param $data
     */
    public function contractExpress(User $user, $data)
    {
        try {
            $this->sendTemplateSms($user->mobile, [
                'name' => $data,
            ], self::TPL_CONTRACT_EXPRESS);
        } catch (\Exception $e) {
            logger(__METHOD__, [$user, $e->getMessage()]);
        }
    }

    /**
     * 申请见证通知 (给管理员)
     * @param User $user
     */
    public function contractLawyerApply(User $user)
    {
        try {
            $this->sendTemplateSms(getSetting('adminMobile'), [
                'name' => $user->truename,
                'time' => now()->toDateTimeString(),
            ], self::TPL_CONTRACT_LAWYER_APPLY);
        } catch (\Exception $e) {
            logger(__METHOD__, [$user, $e->getMessage()]);
        }
    }
}
