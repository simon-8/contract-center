<?php
/*
 * 用户签名后签署PDF文件
 * */
namespace App\Listeners;

use App\Events\UserSign;
use App\Models\Contract;
use App\Models\EsignSignLog;
use App\Services\ContractService;
use App\Services\EsignService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

/**
 * @property \App\Services\ContractService $contractService
 * @property \App\Services\EsignService $esignService
 * @property \App\Models\Contract $contract
 * @property \App\Models\User $user
 * @property string $mobile
 * @property string $captcha
 *
 * */
class UserSignListener
{
    //use InteractsWithQueue;

    //public $tries = 1;

    public $contractService;
    public $esignService;
    public $contract; // 合同
    public $user; // 用户
    public $mobile; // 签署手机号
    public $captcha; // 签署验证码

    /**
     * UserSignListener constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        //info(__METHOD__, [time()]);
    }

    /**
     * @param UserSign $event

     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException|\Exception
     */
    public function handle(UserSign $event)
    {
        \Log::info(__METHOD__);

        $this->contractService = new ContractService();
        $this->esignService = new EsignService();
        //$this->event = $event;
        $this->contract = $event->contract;
        $this->user = $event->user;
        $this->mobile = $event->mobile;
        $this->captcha = $event->captcha;

        $signData = $this->makeSignData();
        logger(__METHOD__, $signData);
        try {
            $serviceid = $this->esignService->userSignToMobile($signData);
        } catch (\Exception $e) {
            logger(__METHOD__, [$e->getMessage()]);
            return responseException('签名失败');
        }

        // 签名记录
        EsignSignLog::create([
            'contract_id' => $this->contract->id,
            'name' => $this->contract->name,
            'userid' => $this->user->id,
            'serviceid' => $serviceid,
        ]);
        return $serviceid;
    }

    /**
     * 生成签名数据
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makeSignData()
    {
        // PDF路径
        $sourceFile = $this->contractService->makeStorePath($this->contract->id);
        $outputFile = $this->contractService->makeStorePath($this->contract->id, true);

        // 当output中存在文件时, 表示有一方已签署, 直接修改已签署文件
        if (Storage::disk('uploads')->exists($outputFile)) {
            $sourceFile = $outputFile;
        }

        // 签章配置
        $signData = [
            'accountid' => $this->user->esignUser->accountid,
            'signFile' => [
                'srcPdfFile' => Storage::disk('uploads')->path($sourceFile),
                'dstPdfFile' => Storage::disk('uploads')->path($outputFile),
                //'fileName' => '',
                //'ownerPassword' => '',
            ],
            'signPos' => [
                //'posPage' => '',
                'posX' => '80',
                'posY' => '10',
                'key' => '甲方签章',
                'width' => '100',
                //'cacellingSign' => '',
                //'isQrcodeSign' => '',
                'addSignTime' => 'true',
            ],
            'signType' => 'Key',
            'sealData' => '',
            'stream' => true,
            'mobile' => $this->mobile,
            'code' => $this->captcha,
        ];

        // 签章关键字定位 && 当前用户签名类型
        $signType = Contract::SIGN_TYPE_PERSON;
        if ($this->contract->userid_first == $this->user->id) {

            $signData['signPos']['key'] = '甲方签章';
            $signType = $this->contract->sign_type_first;

        } else if ($this->contract->userid_second == $this->user->id) {

            $signData['signPos']['key'] = '乙方签章';
            $signType = $this->contract->sign_type_second;

        } else if ($this->contract->userid_three == $this->user->id) {

            $signData['signPos']['key'] = '居间人签章';
            $signType = $this->contract->sign_type_three;

        }

        if ($signType == Contract::SIGN_TYPE_COMPANY) {
            $signData['sealData'] = $this->companySignImage();
            $signData['signPos']['width'] = 159;
        } else {
            $signData['sealData'] = $this->userSignImage();
        }
        return $signData;
    }

    /**
     * 用户签名
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException|\Exception
     */
    protected function userSignImage()
    {
        // 获取签名图片
        $sign = $this->contract->sign()->where('userid', $this->user->id)->first();
        if (!$sign) {
            throw new \Exception('用户未上传签名');
        }
        if (!Storage::disk('uploads')->exists($sign->thumb)) {
            throw new \Exception('用户签名图片不存在');
        }
        $signImage = Storage::disk('uploads')->get($sign->thumb);
        $signImageBase64 = base64_encode($signImage);
        return $signImageBase64;
    }

    /**
     * 公司签名
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException|\Exception
     */
    protected function companySignImage()
    {
        $companyInfo = [];
        if ($this->contract->userid_first == $this->user->id) {
            $companyInfo = $this->contract->companyFirst;
        } else if ($this->contract->userid_second == $this->user->id) {
            $companyInfo = $this->contract->companySecond;
        } else if ($this->contract->userid_three == $this->user->id) {
            $companyInfo = $this->contract->companyThree;
        }
        if (!$companyInfo && !$companyInfo->sign_data) {
            throw new \Exception('无签名文件');
        }

        if (!Storage::disk('uploads')->exists($companyInfo->sign_data)) {
            throw new \Exception('公司印章图片不存在');
        }
        $signImage = Storage::disk('uploads')->get($companyInfo->sign_data);
        $signImageBase64 = base64_encode($signImage);
        return $signImageBase64;
    }

    /**
     * 处理失败任务。
     *
     * @param  \App\Events\UserSign  $event
     * @param  \Exception  $exception
     * @return void
     */
    //public function failed(UserSign $event, $exception)
    //{
    //    info(__METHOD__, [$exception->getMessage()]);
    //}
}
