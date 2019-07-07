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
        return responseMessage('', $contract->getStatus());
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
            ->ofUserid($this->user->id)
            ->ofCatid($data['catid'] ?? '')
            ->ofMycatid($data['mycatid'] ?? 0)
            ->ofLawyerid($data['lawyerid'] ?? 0)
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

        $content = $contract->content->getAttribute('content');
        unset($contract->content);
        $contract->content = $content;
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
        $data = collect($data)->only(['catid', 'fills', 'rules', 'agree'])->toArray();

        //$userType = $contract->getUserType($data['user_type']);
        //unset($data['user_type']);

        DB::beginTransaction();
        try {
            $contractData = $contract->create([
                'userid' => $this->user->id,
                'catid' => $data['catid'],
                'jiafang' => $data['fills']['jiafang'] ?? '',
                'yifang' =>  $data['fills']['yifang'] ?? '',
                'jujianren' =>  $data['fills']['jujianren'] ?? '',
                //"userid_{$userType}" => $this->user->id,
                'status' => $contract::STATUS_APPLY
            ]);

            $contractData->content()->create([
                'id' => $contractData->id,
                'content' => $data
            ]);
            // todo 放入模型created事件 处理
            $contractData->name = __('contract.name', ['id' => $contractData->id]);
            $contractData->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
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
        $data = collect($data)->only(['fills', 'rules', 'agree'])->toArray();

        DB::beginTransaction();
        try {
            $updateData = [
                'jiafang' => $data['fills']['jiafang'] ?? '',
                'yifang' =>  $data['fills']['yifang'] ?? '',
                'jujianren' =>  $data['fills']['jujianren'] ?? '',
                'confirm_first' => 0,
                'confirm_second' => 0,
            ];
            if ($contract::CAT_THREE) {
                $updateData['confirm_three'] = 0;
            }
            // 设置targetid
            //if ($this->user->id != $contract->userid) {
            //    $updateData['targetid'] = $this->user->id;
            //}
            $updateData['confirm_second'] = 0;
            $contractData = $contract->update($updateData);

            $contract->content->update([
                'content' => $data
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return responseException($exception->getMessage());
        }

        return responseMessage();
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
        $data = $request->only(['user_type']);
        $request->validateConfirm($data);

        $userType = $contract->getUserType($data['user_type']);
        unset($data['user_type']);

        if ($contract->catid == $contract::CAT_THREE) {
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
        $updateData["userid_{$userType}"] = $this->user->id;
        $updateData["confirm_{$userType}"] = 1;
        $contract->fill($updateData);
        if (!$contract->save()) {
            return responseException(__('web.failed'));
        }

        // 已确认 生成pdf文档
        if ($contract->status === $contract::STATUS_CONFIRM) {
            event(new UserConfirm($contract));
        }

        $content = $contract->content->getAttribute('content');
        unset($contract->content);
        $contract->content = $content;
        return responseMessage('', new ContractResource($contract));
        //return responseMessage('', $contract->status);
    }
}