<?php
/**
 * 1. A起草
 * 2. A选择身份
 * 3. A发给B
 * 4. B编辑并确认, 确认身份
 * 5. A确认(生成PDF), 支付, 然后签名 (生成签名后PDF)
 * 6. B签名 (基于A签名)
 * 7. 平台签名
 * 8. 文档保全
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
use App\Models\Contract;
use App\Models\ContractCategory;
use App\Models\ContractTplSection;
use App\Services\ContractService;
use \DB;

class ContractController extends BaseController
{
    //public function __construct(\Request $request)
    //{
    //    parent::__construct($request);
    //    $this->middleware('auth:api')->except('getStatus', 'getStatusCount');
    //}

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
            Contract::STATUS_LAWYER_CONFIRM => '已见证',
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
    public function index(\Request $request, Contract $contract)
    {
        if ($this->user === null) {
            return responseMessage('');
        }

        $data = $request::all();
        $lists = $contract->ofStatus($data['status'] ?? '')
            //->ofUserid($this->user->id)
            ->ofMine($this->user->id)
            ->ofCatid($data['catid'] ?? '')
            ->ofMycatid($data['mycatid'] ?? 0)
            //->ofLawyerid($da ta['lawyerid'] ?? 0)
            ->ofJiafang($data['jiafang'] ?? '')
            ->ofYifang($data['yifang'] ?? '')
            ->ofJujianren($data['jujianren'] ?? '')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return ContractResource::collection($lists);
    }

    /**
     * 详情
     * @param Contract $contract
     * @return ContractResource
     */
    public function show(Contract $contract)
    {
        //$this->checkAuth($contract);

        $contract->loadMissing('content');
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

        DB::beginTransaction();
        try {
            $contractData = $contract->create([
                'userid' => $this->user->id,
                'catid' => $data['catid'],
                'players' => $data['players'],
                'jiafang' => '',
                'yifang' =>  '',
                'jujianren' =>  '',
                //"userid_{$userType}" => $this->user->id,
                'status' => $contract::STATUS_APPLY
            ]);

            $contractData->content()->create([
                'id' => $contractData->id,
                'tpl' => $sections,
                'fill' => $data['fillsData']
            ]);
            // todo 放入模型created事件 处理
            $catname = ContractCategory::getCatName($data['catid']);
            $contractData->name = __('contract.name', [
                'catname' => $catname,
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

        DB::beginTransaction();
        try {
            // 重置数据 等待重新确认
            $updateData = [
                'jiafang' => $data['fills']['jiafang'] ?? '',
                'yifang' =>  $data['fills']['yifang'] ?? '',
                'jujianren' =>  $data['fills']['jujianren'] ?? '',
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

            $contractData = $contract->update($updateData);

            $contract->content->update([
                'tpl' => $sections,
                'fill' => $data['fillsData']
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return responseException($exception->getMessage());
        }

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
            return responseException('请先通过实名认证', ['vtruename' => false]);
        }
        $data = $request->only(['user_type']);
        $request->validateConfirm($data);

        $userType = $contract->getUserType($data['user_type']);
        unset($data['user_type']);

        $updateData["userid_{$userType}"] = $this->user->id;
        $updateData["confirm_{$userType}"] = 1;
        $contract->fill($updateData);

        // 直接设置当前用户真实姓名
        if ($userType === Contract::USER_TYPE_FIRST) {
            $updateData['jiafang'] = $this->user->realname->truename;
        } else if ($userType === Contract::USER_TYPE_SECOND) {
            $updateData['yifang'] = $this->user->realname->truename;
        } else if ($userType === Contract::USER_TYPE_THREE) {
            $updateData['jujianren'] = $this->user->realname->truename;
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
        return responseMessage('', new ContractResource($contract));
    }
}
