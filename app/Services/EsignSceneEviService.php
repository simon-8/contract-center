<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/5/6
 * Time: 22:15
 */

namespace App\Services;

use App\Models\Company;
use App\Models\Contract;
use App\Models\ContractCategory;
use App\Models\EsignEviBusiness;
use App\Models\EsignEviLink;
use App\Models\EsignEviPoint;
use App\Models\EsignEviScene;
use App\Models\EsignEviSeg;
use App\Models\EsignSignLog;
use Illuminate\Support\Facades\Storage;
use Simon\Esign\SceneEvi;

class EsignSceneEviService
{
    protected $sceneEvi = null;

    protected $contract = null;

    public function __construct($debug = false)
    {
        $this->sceneEvi = new SceneEvi($this->getConfig(), $debug);
    }

    /**
     * @return array
     */
    protected function getConfig()
    {
        return [
            'project_id'     => config('esign.appid'),
            'project_secret' => config('esign.appSecret'),
            'sign_algorithm' => 'HMACSHA256',
        ];
    }

    /**
     * 定义行业类型
     * @param string $business
     * @return bool
     * @throws \Exception
     */
    public function createBusiness($business = '法律服务')
    {
        $lists = $this->sceneEvi->createBusiness($business);

        // 添加到数据表
        foreach ($lists as $k => $v) {
            EsignEviBusiness::updateOrCreate([
                'name' => $v,
            ], [
                'id' => $k,
            ]);
        }
        return true;
    }

    /**
     * 业务凭证名称 (场景)
     * 与本系统分类关联, 一对一
     * @param $businessId
     * @param string $sceneName
     * @return bool
     * @throws \Exception
     */
    public function createScene(ContractCategory $category, $businessId)
    {
        // 使用分类名做场景名称, 分类名可能重复, 已有场景的话直接关联
        $existsScene = EsignEviScene::where('business_id', $businessId)->whereName($category->name)->first();
        if ($existsScene) {
            EsignEviScene::updateOrCreate([
                'name' => $category->name,
                'business_id' => $businessId,
            ], [
                'id' => $existsScene->id,
                'catid' => $category->id,
            ]);
            return true;
        }
        $lists = $this->sceneEvi->createScene($businessId, $category->name);

        // 添加到数据表
        foreach ($lists as $k => $v) {
            EsignEviScene::updateOrCreate([
                'name' => $v,
                'business_id' => $businessId,
            ], [
                'id' => $k,
                'catid' => $category->id,
            ]);
        }
        return true;
    }


    /**
     * 创建证据点(名称)
     * @param $sceneId
     * @param string $segName
     * @return bool
     * @throws \Exception
     */
    public function createSeg($sceneId, $segName = "合同签署人信息")
    {
        // 目前一个场景只有一个证据点名称
        if (EsignEviSeg::where(['name' => $segName, 'scene_id' => $sceneId,])->exists()) {
            return true;
        }
        $lists = $this->sceneEvi->createSeg($sceneId, $segName);

        // 添加到数据表
        foreach ($lists as $k => $v) {
            EsignEviSeg::updateOrCreate([
                'name' => $v,
                'scene_id' => $sceneId,
            ], [
                'id' => $k,
            ]);
        }
        return true;
    }

    /**
     * 创建证据点字段属性
     * @param $segId
     * @return bool
     * @throws \Exception
     */
    public function createSegProp($segId)
    {
        $properties = [
            [
                "displayName" => "甲方名称",
                "paramName"   => "jiafang",
            ],
            [
                "displayName" => "乙方名称",
                "paramName"   => "yifang",
            ],
            [
                "displayName" => "居间人名称",
                "paramName"   => "jujianren",
            ],

            [
                "displayName" => "甲方手机",
                "paramName"   => "jiafangMobile",
            ],
            [
                "displayName" => "乙方手机",
                "paramName"   => "yifangMobile",
            ],
            [
                "displayName" => "居间人手机",
                "paramName"   => "jujianrenMobile",
            ],
        ];
        return $this->sceneEvi->createSegProp($segId, $properties);
    }

    /**
     * 为合同创建证据链 一对一
     * @param Contract $contract
     * @return EsignEviLink|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function createLink(Contract $contract)
    {
        $sceneName = $contract->category->eviScene->name;
        $sceneId = $contract->category->eviScene->id;

        $evid = $this->sceneEvi->createLink($sceneName, $sceneId);
        // 存库
        return EsignEviLink::create([
            'contract_id' => $contract->id,
            'scene_id' => $sceneId,
            'scene_name' => $sceneName,
            'scene_evid' => $evid,
        ]);
    }

    /**
     * 为合同创建一个原文基础版证据点
     * @param Contract $contract
     * @param EsignEviLink $esignEviLink
     * @return bool
     * @throws \Exception
     */
    public function createPointBasic(Contract $contract, EsignEviLink $esignEviLink)
    {
        $segmentData = [
              'jiafang' => $contract->jiafang,
              'yifang' => $contract->yifang,
              'jujianren' => $contract->jujianren,
        ];
        $segmentData['jiafangMobile'] = $contract->companyid_first ? $contract->companyFirst->mobile : $contract->userFirst->mobile;
        $segmentData['yifangMobile'] = $contract->companyid_second ? $contract->companySecond->mobile : $contract->userSecond->mobile;
        $segmentData['jujianrenMobile'] = $contract->companyid_three ? $contract->companyThree->mobile : $contract->userThree->mobile;

        $segId = $contract->category->eviScene->eviSeg->id;
        $filePath = Storage::disk('uploads')->path($contract->path_pdf);
        $response = $this->sceneEvi->createPointBasic($segId, $filePath, $segmentData);

        //
        return $esignEviLink->update([
            'point_evid' => $response['evid'],
            'point_url' => $response['url'],
        ]);
        //EsignEviPoint::create([
        //    'contract_id' => $contract->id,
        //    'evid' => $response['evid'],
        //    'url' => $response['url'],
        //]);
        //return $response;
    }

    /**
     * 添加证据点到证据链
     * @param Contract $contract
     * @return bool
     * @throws \Exception
     */
    public function addPointToLink(Contract $contract)
    {
        $link = EsignEviLink::where('contract_id', $contract->id)->first();
        $point = EsignEviPoint::where('contract_id', $contract->id)->first();
        $serviceIds = EsignSignLog::where('contract_id', $contract->id)->pluck('serviceid')->all();

        return $this->sceneEvi->addPointToLink($link->id, $point->id, $serviceIds);
    }

    /**
     * 关联证据链和用户
     * @param string $linkId
     * @param array $users
     * @return bool
     * @throws \Exception
     */
    public function addLinkToUser(Contract $contract)
    {
        $link = EsignEviLink::where('contract_id', $contract->id)->first();
        $userFirst = ['name' => $contract->jiafang];
        if ($contract->companyid_first) {
            $userFirst['type'] = $this->getCompanyType($contract->companyFirst->reg_type);
            $userFirst['number'] = $contract->companyFirst->organ_code;
        } else {
            $userFirst['type'] = 'ID_CARD';
            $userFirst['number'] = $contract->userFirst->idcard;
        }

        $userSecond = ['name' => $contract->yifang];
        if ($contract->companyid_second) {
            $userSecond['type'] = $this->getCompanyType($contract->companySecond->reg_type);
            $userSecond['number'] = $contract->companySecond->organ_code;
        } else {
            $userSecond['type'] = 'ID_CARD';
            $userSecond['number'] = $contract->userSecond->idcard;
        }

        $userThree = ['name' => $contract->jujianren];
        if ($contract->companyid_three) {
            $userThree['type'] = $this->getCompanyType($contract->companyThree->reg_type);
            $userThree['number'] = $contract->companyThree->organ_code;
        } else {
            $userThree['type'] = 'ID_CARD';
            $userThree['number'] = $contract->userThree->idcard;
        }

        $users = [
            $userFirst,
            $userSecond,
            $userThree,
        ];
        return $this->sceneEvi->addLinkToUser($link->id, $users);
    }

    /**
     * 获取 company type
     * 默认 CODE_ORG (组织机构代码)
     * @param $regType
     * @return string
     */
    private function getCompanyType($regType)
    {
        switch ($regType) {
            //case Company::REG_TYPE_NORMAL:
            //    $type = 'CODE_ORG';
            //    break;
            case Company::REG_TYPE_MERGE:
                $type = 'CODE_USC';
                break;
            case Company::REG_TYPE_REGCODE:
                $type = 'CODE_REG';
                break;
            //case Company::REG_TYPE_OTHER:
            //    $type = '';
            //    break;
            default:
                $type = 'CODE_ORG';
                break;
        }
        return $type;
    }

    /**
     * 上传代保全文档
     * @param string $fileUploadUrl
     * @param string $filePath
     * @return bool
     * @throws \Exception
     */
    public function uploadFile(string $fileUploadUrl, string $filePath)
    {
        $this->sceneEvi->uploadFile($fileUploadUrl, $filePath);
        return true;
    }

    /**
     * 拼接查看存证证明URL
     * @param $linkId
     * @param int $expiredAt
     * @return string
     */
    public function getViewUrl($linkId, int $expiredAt = 0)
    {
        $viewUrl = $this->getViewUrl($linkId, $expiredAt);
        return $viewUrl;
    }
}
