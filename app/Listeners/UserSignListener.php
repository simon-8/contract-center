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
     * Create the event listener.
     * @return void
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

        // 获取签名图片
        $sign = $contract->sign()->where('userid', $user->id)->first();
        if (!$sign) {
            throw new \Exception('用户未上传签名');
        }
        if (!Storage::disk('uploads')->exists($sign->thumb)) {
            throw new \Exception('用户签名图片不存在');
        }
        $signImage = Storage::disk('uploads')->get($sign->thumb);
        $signImageBase64 = base64_encode($signImage);

        // PDF路径
        $sourceFile = $this->contractService->makeStorePath($contract->id);
        $outputFile = $this->contractService->makeStorePath($contract->id, true);

        // 当output中存在文件时, 表示有一方已签署
        $uploadPath = config('filesystems.disks.uploads.root');
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
            'sealData' => $signImageBase64,
            'stream' => true,
        ];
        // 签章关键字定位
        if ($contract->isOwner($user->id)) {
            $contract->signed_first = 1;
            $signData['signPos']['key'] = '甲方签章';
        } else {
            $contract->signed_first = 1;
            $signData['signPos']['key'] = '乙方签章';
        }

        $serviceid = $this->esignService->userSign($signData);

        // 双方都签过名
        if ($contract->signed_first && $contract->signed_second) {
            $contract->status = $contract::STATUS_SIGN;
        }
        $contract->save();

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
