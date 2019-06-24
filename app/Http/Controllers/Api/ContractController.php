<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/13
 * Time: 23:36
 */
namespace App\Http\Controllers\Api;

use App\Http\Resources\Contract AS ContractResource;
use App\Models\Contract;
use \DB;

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
            ->ofCatid($data['catid'] ?? 0)
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
        //$this->checkAuth($contract);
        $data = $request::only(['catid', 'fills', 'rules', 'agree']);

        DB::beginTransaction();
        try {
            $contractData = $contract->create([
                'userid' => $this->user->id,
                'catid' => $data['catid'],
                'jiafang' => $data['fills']['jiafang'] ?? '/',
                'yifang' =>  $data['fills']['yifang'] ?? '/',
                'jujianren' =>  $data['fills']['jujianren'] ?? '/',
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
        $this->checkAuth($contract);

        $data = $request::only(['fills', 'rules', 'agree']);

        DB::beginTransaction();
        try {
            $contractData = $contract->update([
                'jiafang' => $data['fills']['jiafang'],
                'yifang' =>  $data['fills']['yifang'],
                'jujianren' =>  $data['fills']['jujianren'],
            ]);

            $contractData->content()->update([
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
}