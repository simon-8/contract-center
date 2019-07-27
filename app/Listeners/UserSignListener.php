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
use Storage;

class UserSignListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 1;

    public $contractService;

    public $esignService;

    /**
     * UserSignListener constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        info(__METHOD__, [time()]);
        $this->contractService = new ContractService();
        $this->esignService = new EsignService();
    }

    /**
     * @param UserSign $event

     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException|\Exception
     */
    public function handle(UserSign $event)
    {
        \Log::info(__METHOD__);

        $contract = $event->contract;
        $user = $event->user;

        // PDF路径
        $sourceFile = $this->contractService->makeStorePath($contract->id);
        $outputFile = $this->contractService->makeStorePath($contract->id, true);

        // 当output中存在文件时, 表示有一方已签署
        $uploadPath = Storage::disk('uploads')->path('');
        if (Storage::disk('uploads')->exists(str_replace($uploadPath, '', $outputFile))) {
            $sourceFile = $outputFile;
        }

        // 签章配置
        $signData = [
            'accountid' => $user->esignUser->accountid,
            'signFile' => [
                'srcPdfFile' => $sourceFile,
                'dstPdfFile' => $outputFile,
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
        ];

        // 签章关键字定位 && 签名类型
        $signType = Contract::SIGN_TYPE_PERSON;
        if ($contract->userid_first == $user->id) {

            $signData['signPos']['key'] = '甲方签章';
            $signType = $contract->sign_type_first;

        } else if ($contract->userid_second == $user->id) {

            $signData['signPos']['key'] = '乙方签章';
            $signType = $contract->sign_type_second;

        } else if ($contract->userid_three == $user->id) {

            $signData['signPos']['key'] = '居间人签章';
            $signType = $contract->sign_type_three;

        }

        if ($signType == Contract::SIGN_TYPE_COMPANY) {
            $signData['sealData'] = $this->companySignImage($event);
            $signData['signPos']['width'] = 159;
        } else {
            $signData['sealData'] = $this->userSignImage($event);
        }

        $serviceid = $this->esignService->userSign($signData);

        // 签名记录
        EsignSignLog::create([
            'contract_id' => $contract->id,
            'name' => $contract->name,
            'userid' => $user->id,
            'serviceid' => $serviceid,
        ]);
        return $serviceid;
    }

    /**
     * 用户签名
     * @param $event
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException|\Exception
     */
    protected function userSignImage(UserSign $event)
    {
        // 获取签名图片
        $sign = $event->contract->sign()->where('userid', $event->user->id)->first();
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
     * @param UserSign $event
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException|\Exception
     */
    protected function companySignImage(UserSign $event)
    {
        $companyInfo = $event->user->company;
        if (!$companyInfo && !$companyInfo->sign_data) {
            throw new \Exception('用户未验证公司');
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
    public function failed(UserSign $event, $exception)
    {
        info(__METHOD__, [$exception->getMessage()]);
    }
}
