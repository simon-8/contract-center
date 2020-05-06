<?php
/**
 * A起草
 * A选择身份类型并确认身份(甲乙方 / 具体人)
 * A转发给B
 * B选择身份类型并确认身份
 * A || B 支付
 * 签名 个人: 手写+验证码
 * 签名 公司: 印章+验证码
 *
 * Note: Contract
 * User: Liu
 * Date: 2019/6/13
 * Time: 23:36
 */
namespace App\Http\Controllers\Api;

use App\Events\UserConfirm;
use App\Http\Requests\ContractRequest;
use App\Http\Resources\Contract AS ContractResource;
use App\Http\Resources\Company as CompanyResource;
use App\Models\Contract;
use App\Models\ContractCategory;
use App\Models\ContractChangeLog;
use App\Models\ContractTplSection;
use App\Models\Company;
use App\Services\ContractService;
use \DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContractController extends BaseController
{
    /**
     * 权限检查
     * @param $contract
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAuth($contract)
    {
        if (!$this->user) {
            return responseException(__('api.no_auth'));
        }
        if ($contract->userid !== $this->user->id && $contract->lawyerid !== $this->user->id) {
            return responseException(__('api.no_auth'));
        }
    }

    /**
     * 获取类型名称
     * @param Contract $contract
     * @return array
     */
    public function getStatus(Contract $contract)
    {
        $statusArr = [
            Contract::STATUS_APPLY          => '一方申请',
            Contract::STATUS_CONFIRM        => '双方确认',
            Contract::STATUS_PAYED          => '进行签名',
            Contract::STATUS_SIGN           => '签名完毕',
            //Contract::STATUS_LAWYER_CONFIRM => '已见证',
        ];
        return responseMessage('', $statusArr);
    }

    /**
     * 根据status计数
     * @param \Request $request
     * @param Contract $contract
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatusCount(\Request $request, Contract $contract)
    {
        $status = $request::input('status', [0, 1, 2]);

        if (!$this->user) {
            $lists = [];
            foreach ($status as $s) {
                $lists[$s] = 0;
            }
            return responseMessage('', $lists);
        }

        $tmp = $contract->selectRaw('status,COUNT(id) as count')
            ->ofUserid($this->user->id)
            ->ofStatus($status ?? '')
            ->groupBy('status')
            ->get()
            ->toArray();
        $lists = [];
        foreach ($status as $s) {
            foreach ($tmp as $v) {
                if ($v['status'] == $s) {
                    $lists[$s] = $v['count'];
                }
            }
            if (!isset($lists[$s])) {
                $lists[$s] = 0;
            }
        }
        return responseMessage('', $lists);
    }

    /**
     * 列表
     * @param \Request $request
     * @param Contract $contract
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, Contract $contract)
    {
        if ($this->user === null) {
            return responseMessage('');
        }

        // 如果未传入company_id 则限制为本人合同
        if (empty($request->company_id)) {
            $request->userid = $this->user->id;
            $request->staff_id = 0;
        }
        $lists = $contract->ofStatus($request->status)
            //->ofUserid($this->user->id)
            ->ofMine($request->userid)
            ->ofCatid($request->catid)
            ->ofMycatid($request->mycatid)
            //->ofLawyerid($da ta['lawyerid)
            ->ofJiafang($request->jiafang)
            ->ofYifang($request->yifang)
            ->ofJujianren($request->jujianren)
            ->ofCompanyStaff($request->company_id, $request->staff_id)
            //->ofCompanyId($request->company_id)
            //->ofStaffId($request->staff_id)
            ->ofName($request->keyword)
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return ContractResource::collection($lists);
    }

    /**
     * 详情
     * @param Contract $contract
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Contract $contract)
    {
        //$this->checkAuth($contract);
        //if (!$this->user) {
        //    return responseException(__('api.no_auth'));
        //}
        // 已确认 已签名 已支付
        if ($this->user) {
            if ($contract->status > Contract::STATUS_APPLY) {
                if (!$contract->authCheck($this->user->id)) {
                    return responseException('该合同已被他人领签');
                }
            }
        }

        $contract->loadMissing('content', 'changelog');

        // 加载当前用户选择的公司
        if ($this->user) {
            $userType = $contract->getUserTypeByUserid($this->user->id);
            if ($contract["companyid_". $userType]) {
                $companyType = "company_". $userType;
                $companyId = "companyid_". $userType;
                $contract[$companyType] = Company::find($contract->$companyId)->only('id', 'userid' ,'name' ,'sign_free');
            }
        }

        return responseMessage('', new ContractResource($contract));
    }

    /**
     * 创建
     * @param \Request $request
     * @param Contract $contract
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(\Request $request, Contract $contract)
    {
        $data = $request::json()->all();
        $data = collect($data)->only(['catid', 'players', 'fillsData'])->toArray();
        logger(__METHOD__, $data);

        $sectionIds = array_keys($data['fillsData']);
        $tplIds = [];
        foreach ($data['fillsData'] as $sectionid => $v) {
            $tplIds = array_merge($tplIds, array_keys($v));
        }

        $sections = ContractTplSection::whereIn('id', $sectionIds)->with(['contractTpl' => function($query) use ($tplIds) {
            $query->whereIn('id', $tplIds)->orderByDesc('listorder');
        }])
        ->orderByDesc('listorder')
        ->get()
        ->toArray();

        $createData = [
            'userid' => $this->user->id,
            'catid' => $data['catid'],
            'players' => $data['players'],
            'jiafang' => '',
            'yifang' =>  '',
            'jujianren' =>  '',
            //"userid_{$userType}" => $this->user->id,
            'status' => $contract::STATUS_APPLY
        ];
        // 公司合同分类, 指定身份类型
        $category = ContractCategory::find($data['catid']);
        if ($category->company_id && $category->user_type) {
            $createData["userid_{$category->user_type}"] = $this->user->id;
            $createData["companyid_{$category->user_type}"] = $category->company_id;

            switch ($category->user_type) {
                case Contract::USER_TYPE_FIRST:
                    $createData['jiafang'] = $category->company->name;
                    break;
                case Contract::USER_TYPE_SECOND:
                    $createData['yifang'] = $category->company->name;
                    break;
                case Contract::USER_TYPE_THREE:
                    $createData['jujianren'] = $category->company->name;
                    break;
                default:
                    break;
            }
        }

        DB::beginTransaction();
        try {
            $contractData = $contract->create($createData);

            $contractData->content()->create([
                'id' => $contractData->id,
                'tpl' => $sections,
                'fill' => $data['fillsData']
            ]);

            $contractData->name = __('contract.name', [
                'catname' => $category->name,
                'id' => $contractData->id,
            ]);
            $contractData->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            logger(__METHOD__, [$exception->getMessage()]);
            return responseException($exception->getMessage());
        }

        return responseMessage();
    }

    /**
     * 更新
     * @param \Request $request
     * @param Contract $contract
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(\Request $request, Contract $contract)
    {
        $data = $request::json()->all();
        $data = collect($data)->only(['catid', 'players', 'fillsData'])->toArray();
        logger(__METHOD__, $data);

        $sectionIds = array_keys($data['fillsData']);
        $tplIds = [];
        foreach ($data['fillsData'] as $sectionid => $v) {
            $tplIds = array_merge($tplIds, array_keys($v));
        }

        $sections = ContractTplSection::whereIn('id', $sectionIds)
            ->with(['contractTpl' => function($query) use ($tplIds) {
                $query->whereIn('id', $tplIds)->orderByDesc('listorder');
            }])
            ->orderByDesc('listorder')
            ->get()
            ->toArray();

        // 重置数据 等待重新确认
        $updateData = [
            'jiafang' => '',
            'yifang' => '',
            'jujianren' => '',
            // 用户ID
            'userid_first' => 0,
            'userid_second' => 0,
            'userid_three' => 0,
            // 公司ID
            'companyid_first' => 0,
            'companyid_second' => 0,
            'companyid_three' => 0,
            // 确认状态
            'confirm_first' => 0,
            'confirm_second' => 0,
            'confirm_three' => 0,
            // 签名状态
            'signed_first' => 0,
            'signed_second' => 0,
            'signed_three' => 0,
            // 签名类型
            'signed_type_first' => 0,
            'signed_type_second' => 0,
            'signed_type_three' => 0,
        ];

        // 公司合同分类, 不允许重置指定身份类型
        $category = ContractCategory::find($data['catid']);
        if ($category->company_id && $category->user_type) {
            unset($updateData["userid_{$category->user_type}"]);
            unset($updateData["companyid_{$category->user_type}"]);

            switch ($category->user_type) {
                case Contract::USER_TYPE_FIRST:
                    unset($updateData['jiafang']);
                    break;
                case Contract::USER_TYPE_SECOND:
                    unset($updateData['yifang']);
                    break;
                case Contract::USER_TYPE_THREE:
                    unset($updateData['jujianren']);
                    break;
                default:
                    break;
            }
        }

        DB::beginTransaction();
        try {

            $contractData = $contract->update($updateData);

            $contract->content->tpl = $sections;
            $contract->content->fill = $data['fillsData'];

            // 填空内容有修改
            if ($contract->content->isDirty('fill')) {
                $changeFills = [];
                $originFillsData = json_decode($contract->content->getOriginal('fill'), true);
                foreach ($data['fillsData'] as $sectionId => $tpls) {
                    foreach ($tpls as $tplId => $tpl) {
                        foreach ($tpl as $key => $val) {
                            if (empty($originFillsData[$sectionId][$tplId][$key])) {
                                $changeFills[$tplId][$key] = 1;
                                continue;
                            }
                            if ($val != $originFillsData[$sectionId][$tplId][$key]) {
                                $changeFills[$tplId][$key] = 1;
                                continue;
                            }
                        }
                    }
                }
                // 记录本次修改内容
                ContractChangeLog::updateOrCreate([
                    'contract_id' => $contract->id,
                ], [
                    'user_id' => $this->user->id,
                    'content' => $changeFills,
                ]);
            }
            $contract->content->update();
            //$contract->content->update([
            //    'tpl' => $sections,
            //    'fill' => $data['fillsData']
            //]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return responseException($exception->getMessage());
        }

        // todo 通知各个成员数据变更
        return responseMessage('', new ContractResource($contract));
    }

    /**
     * 删除
     * @param Contract $contract
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Contract $contract)
    {
        $this->checkAuth($contract);

        if (!$contract->delete()) {
            return responseException(__('web.failed'));
        }
        return responseMessage();
    }

    /**
     * 用户确认, 同时确认身份
     * @param ContractRequest $request
     * @param Contract $contract
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function confirm(ContractRequest $request, Contract $contract)
    {
        if (!$this->user->vtruename) {
            return responseException('请先通过实名认证', ['vtruename' => true]);
        }
        $data = $request->only(['user_type', 'companyid']);
        $request->validateConfirm($data);

        $userType = $contract->getUserType($data['user_type']);
        unset($data['user_type']);

        $updateData["userid_{$userType}"] = $this->user->id;
        $updateData["companyid_{$userType}"] = $data['companyid'];
        $updateData["confirm_{$userType}"] = 1;
        $contract->fill($updateData);

        $companyData = [];
        if ($data['companyid']) {
            $companyData = Company::find($data['companyid']);
            if (empty($companyData) || !$companyData->id) {
                return responseException('未找到该企业信息, 请确认');
            }
            if ($companyData->status != Company::STATUS_SUCCESS) {
                return responseException('该企业还未认证成功, 请认证后再试');
            }
        }
        // 设置各方名称 && 签名类型
        $identityName = $companyData ? $companyData['name'] : $this->user->truename;
        if ($userType === Contract::USER_TYPE_FIRST) {
            $updateData['jiafang'] = $identityName;
            $updateData['sign_type_first'] = $companyData ? 1 : 0;
        } else if ($userType === Contract::USER_TYPE_SECOND) {
            $updateData['yifang'] = $identityName;
            $updateData['sign_type_second'] = $companyData ? 1 : 0;
        } else if ($userType === Contract::USER_TYPE_THREE) {
            $updateData['jujianren'] = $identityName;
            $updateData['sign_type_three'] = $companyData ? 1 : 0;
        }

        if ($contract->players == $contract::PLAYERS_THREE) {
            if ($contract->confirm_first && $contract->confirm_second && $contract->confirm_three) {
                $updateData['status'] = $contract::STATUS_CONFIRM;
                $updateData['confirm_at'] = date('Y-m-d H:i:s');
            }
        } else {
            if ($contract->confirm_first && $contract->confirm_second) {
                $updateData['status'] = $contract::STATUS_CONFIRM;
                $updateData['confirm_at'] = date('Y-m-d H:i:s');
            }
        }
        $contract->fill($updateData);

        if (!$contract->save()) {
            return responseException(__('web.failed'));
        }

        // 已确认 生成pdf文档
        if ($contract->status === $contract::STATUS_CONFIRM) {
            event(new UserConfirm($contract));
        }

        $contract->loadMissing('content');

        // 返回当前用户选择的公司
        if ($companyData) {
            $companyType = "company_". $userType;
            $contract[$companyType] = $companyData->only('id', 'userid' ,'name' ,'sign_free');
        }
        return responseMessage('', new ContractResource($contract));
    }

    /**
     * 签名企业信息
     * @param \Request $request
     * @param Contract $contract
     * @return \Illuminate\Http\JsonResponse
     */
    public function signCompanyInfo(\Request $request, Contract $contract)
    {
        // 根据用户类型获取企业ID
        $userType = $contract->getUserTypeByUserid($this->user->id);
        $companyid = $contract['companyid_' . $userType];

        if (!$companyid) {
            return responseException('该合同无法使用企业签名');
        }
        $companyData = Company::ofStatus(Company::STATUS_SUCCESS)->whereId($companyid)->first();
        if (!$companyData) {
            return responseException('该企业未通过企业认证');
        }
        $companyData['mobile'] = stringHide($companyData['mobile']);
        unset($companyData['legal_idno']);
        return responseMessage('', new CompanyResource($companyData));
    }

    /**
     * 我的数量
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myCount(\Request $request)
    {
        $companyId = $request::input('company_id');
        $userId = $request::input('staff_id');
        //$userId = $userId ?: $this->user->id;

        // 签章数量(单方面签章)
        $data['contract_signed_count'] = Contract::where(function ($query) use ($userId, $companyId) {
            $query->where(function (Builder $query) use ($userId, $companyId) {
                $query->where('signed_first', 1)
                    ->where('companyid_first', $companyId);
                if ($userId) $query->where('userid_first', $userId);
            })->orWhere(function (Builder $query) use ($userId, $companyId) {
                $query->where('signed_second', 1)
                    ->where('companyid_second', $companyId);
                if ($userId) $query->where('userid_second', $userId);
            })->orWhere(function (Builder $query) use ($userId, $companyId) {
                $query->where('signed_three', 1)
                    ->where('companyid_three', $companyId);
                if ($userId) $query->where('userid_three', $userId);
            });
        })
        ->where('status', '<', Contract::STATUS_SIGN)
        ->count();

        // 成功数量(双方签章)
        $data['contract_success_count'] = Contract::where(function ($query) use ($userId, $companyId) {
            $query->where(function (Builder $query) use ($userId, $companyId) {
                $query->where('signed_first', 1)
                    ->where('companyid_first', $companyId);
                if ($userId) $query->where('userid_first', $userId);
            })->orWhere(function (Builder $query) use ($userId, $companyId) {
                $query->where('signed_second', 1)
                    ->where('companyid_second', $companyId);
                if ($userId) $query->where('userid_second', $userId);
            })->orWhere(function (Builder $query) use ($userId, $companyId) {
                $query->where('signed_three', 1)
                    ->where('companyid_three', $companyId);
                if ($userId) $query->where('userid_three', $userId);
            });
        })
        ->where('status', Contract::STATUS_SIGN)
        ->count();
        return responseMessage('', $data);
    }
}
