<?php
/**
 * Note: contract service
 * User: Liu
 * Date: 2019/6/24
 */

namespace App\Services;

use App\Events\UserSign;
use App\Models\Contract;
use App\Models\EsignSignLog;
use Illuminate\Support\Facades\Storage;
use PDF;
/**
 * @property \App\Services\ContractService $contractService
 * @property \App\Services\EsignService $esignService
 * @property \App\Models\Contract $contract
 * @property \App\Models\User $user
 *
 * */
class ContractService
{
    public $contractService;
    public $esignService;
    public $contract; // 合同
    public $user; // 用户
    //protected $pdfSourceRoot; // pdf原始目录
    //protected $pdfOutputRoot; // pdf输出目录

    //public function __construct()
    //{
    //    $this->pdfSourceRoot = 'pdf/source';
    //    $this->pdfOutputRoot = 'pdf/output';
    //}

    /**
     * 生成存储路径
     * @param $id
     * @param bool $output  为true时选择output目录
     * @return string
     */
    public function makeStorePath($id, $output = false)
    {
        if ($output) {
            $dir = 'pdf/output';
        } else {
            $dir = 'pdf/source';
        }
        return $dir. "/{$id}.pdf";
    }

    /**
     * 生成pdf文档
     * @param Contract $contract
     * @param bool $output
     * @return \Barryvdh\Snappy\PdfWrapper
     */
    public function makePdf(Contract $contract, $output = false)
    {
        $sections = json_decode($contract->content->tpl, true);
        $fill = json_decode($contract->content->fill, true);
        $pdf = PDF::loadView('api.contract.show', compact('contract', 'sections', 'fill'));
        $storePath = $this->makeStorePath($contract->id, $output);
        $storePath = Storage::disk('uploads')->path($storePath);
        return $pdf->save($storePath, true);
    }

    /**
     * 生成签名数据
     * @param $mobile
     * @param $captcha
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makeSignData($mobile, $captcha)
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
            'mobile' => $mobile,
            'code' => $captcha,
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
     * 用户签名
     * @param $contract
     * @param $user
     * @param $mobile
     * @param $captcha
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException|\Exception
     */
    public function userSign($contract, $user, $mobile, $captcha)
    {
        $this->contractService = new ContractService();
        $this->esignService = new EsignService();
        $this->contract = $contract;
        $this->user = $user;

        $signData = $this->makeSignData($mobile, $captcha);
        logger(__METHOD__, $signData);

        $serviceid = $this->esignService->userSignToMobile($signData);

        // 签名记录
        EsignSignLog::create([
            'contract_id' => $this->contract->id,
            'name' => $this->contract->name,
            'userid' => $this->user->id,
            'serviceid' => $serviceid,
        ]);
        return $serviceid;
    }
}
