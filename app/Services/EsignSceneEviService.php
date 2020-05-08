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
use App\Models\EsignEviScene;
use App\Models\EsignSignLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Simon\Esign\SceneEvi;

class EsignSceneEviService
{
    protected $sceneEvi = null;

    protected $contract = null;

    public function __construct($debug = true)
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
     * @param ContractCategory $category
     * @param $businessId
     * @return EsignEviScene|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function createScene(ContractCategory $category, $businessId)
    {
        // 使用分类名做场景名称, 分类名可能重复, 已有场景的话直接关联
        $existsScene = EsignEviScene::whereBusinessId($businessId)->whereName($category->name)->first();
        if ($existsScene) {
            return EsignEviScene::updateOrCreate([
                'name' => $category->name,
                'business_id' => $businessId,
                'catid' => $category->id,
            ], [
                'id' => $existsScene->id,
                'seg_id' => $existsScene->seg_id,
                'seg_has_attr' => $existsScene->seg_has_attr,
            ]);
        }
        $lists = $this->sceneEvi->createScene($businessId, $category->name);

        // 只会有一条数据
        $firstKey = array_keys($lists)[0];
        $firstVal = array_values($lists)[0];
        return EsignEviScene::create([
            'name' => $firstVal,
            'business_id' => $businessId,
            'id' => $firstKey,
            'catid' => $category->id,
        ]);
    }

    /**
     * 创建证据点(名称)
     * @param EsignEviScene $esignEviScene
     * @param string $segName
     * @return bool
     * @throws \Exception
     */
    public function createSeg(EsignEviScene $esignEviScene, $segName = "合同签署人信息")
    {
        // 目前一个场景只有一个证据点名称
        if ($esignEviScene->seg_id) return true;

        $lists = $this->sceneEvi->createSeg($esignEviScene->id, $segName);

        // 添加到数据表
        $esignEviScene->seg_id = array_keys($lists)[0];
        $esignEviScene->save();
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
        // 合同所属分类关联的情景ID和名称
        $sceneName = $contract->category->eviScene->name;
        $sceneId = $contract->category->eviScene->id;
        $segId = $contract->category->eviScene->seg_id;

        $evid = $this->sceneEvi->createLink($sceneName, $sceneId);
        // 存库
        return EsignEviLink::create([
            'contract_id' => $contract->id,
            'scene_id' => $sceneId,
            'scene_name' => $sceneName,
            'scene_evid' => $evid,
            'seg_id' => $segId,
            'point_url' => '',
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

        $filePath = Storage::disk('uploads')->path($contract->path_pdf);
        $response = $this->sceneEvi->createPointBasic($esignEviLink->seg_id, $filePath, $segmentData);

        return $esignEviLink->update([
            'point_evid' => $response['evid'],
            'point_url' => $response['url'],
            'status' => EsignEviLink::STATUS_POINT_CREATED
        ]);
    }

    /**
     * 添加证据点到证据链
     * @param EsignEviLink $esignEviLink
     * @return bool
     * @throws \Exception
     */
    public function addPointToLink(EsignEviLink $esignEviLink)
    {
        $serviceIds = EsignSignLog::where('contract_id', $esignEviLink->contract_id)->pluck('serviceid')->all();

        $result = $this->sceneEvi->addPointToLink($esignEviLink->scene_evid, $esignEviLink->point_evid, $serviceIds);
        if (!$result) throw new \Exception('添加证据点到证据链失败');

        return $esignEviLink->update([
            'status' => EsignEviLink::STATUS_POINT_LINKED,
        ]);
    }

    /**
     * 关联证据链和用户
     * @param Contract $contract
     * @param EsignEviLink $esignEviLink
     * @return bool
     * @throws \Exception
     */
    public function addLinkToUser(Contract $contract, EsignEviLink $esignEviLink)
    {
        $userFirst = ['name' => $contract->jiafang];
        if ($contract->companyid_first) {
            $userFirst['type'] = $this->getCompanyType($contract->companyFirst->reg_type);
            $userFirst['number'] = $contract->companyFirst->organ_code;
        } else {
            $userFirst['type'] = 'ID_CARD';
            $userFirst['number'] = $contract->userFirst->realname->idcard;
        }

        $userSecond = ['name' => $contract->yifang];
        if ($contract->companyid_second) {
            $userSecond['type'] = $this->getCompanyType($contract->companySecond->reg_type);
            $userSecond['number'] = $contract->companySecond->organ_code;
        } else {
            $userSecond['type'] = 'ID_CARD';
            $userSecond['number'] = $contract->userSecond->realname->idcard;
        }

        $userThree = [];
        if ($contract->jujianren) {
            $userThree = ['name' => $contract->jujianren];
            if ($contract->companyid_three) {
                $userThree['type'] = $this->getCompanyType($contract->companyThree->reg_type);
                $userThree['number'] = $contract->companyThree->organ_code;
            } else {
                $userThree['type'] = 'ID_CARD';
                $userThree['number'] = $contract->userThree->realname->idcard;
            }
        }

        $users = [
            $userFirst,
            $userSecond,
        ];
        if ($userThree) $users[] = $userThree;

        $result = $this->sceneEvi->addLinkToUser($esignEviLink->scene_evid, $users);
        if (!$result) throw new \Exception('关联证据链和用户失败');

        return $esignEviLink->update([
            'status' => EsignEviLink::STATUS_USER_LINKED,
        ]);
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
     * @param EsignEviLink $esignEviLink
     * @param string $filePath
     * @return bool
     * @throws \Exception
     */
    public function uploadFile(EsignEviLink $esignEviLink, $filePath)
    {
        $this->sceneEvi->uploadFile($esignEviLink->point_url, $filePath);
        return $esignEviLink->update([
            'status' => EsignEviLink::STATUS_FILE_UPLOAD,
        ]);
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

    public function categoryCreated(ContractCategory $category)
    {
        $eviBusiness = EsignEviBusiness::first();

        try {
            $scene = $this->createScene($category, $eviBusiness->id);
            if (!$scene->seg_id) {
                $this->createSeg($scene);
            }
            if (!$scene->seg_has_attr) {
                $this->createSegProp($scene->seg_id);
                $scene->seg_has_attr = 1;
                $scene->save();
            }
            info(__METHOD__, ['数据存证字典创建完成']);
        } catch (\Exception $exception) {
            Log::error(__METHOD__, [$exception->getMessage()]);
        }
    }
}
