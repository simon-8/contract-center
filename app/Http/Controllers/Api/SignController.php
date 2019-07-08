<?php
/**
 * Note: 用户签名
 * User: Liu
 * Date: 2019/6/27
 */
namespace App\Http\Controllers\Api;

use App\Models\Contract;
use App\Models\Sign;
use App\Http\Resources\Sign as SignResource;
use App\Events\UserSign;
use App\Services\ContractService;
use App\Services\EsignService;

class SignController extends BaseController
{
    /**
     * @param $id
     * @return string
     */
    protected function makeStorePath($id)
    {
        return 'signs/'. $id;
    }

    /**
     * 列表
     * @param Sign $sign
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Sign $sign)
    {
        $lists = $sign->where('userid', $this->user->id)
            ->paginate();
        return SignResource::collection($lists);
    }

    /**
     * 保存
     * @param \Request $request
     * @param Sign $sign
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\Request $request, Sign $sign)
    {
        if (!$this->user->has('esignUser')->count()) {
            return responseException('请先通过实名认证');
        }

        // todo 权限检查
        $data = $request::only(['contract_id']);
        if (!$request::hasFile('file')) {
            return responseException('请选择文件上传');
        }
        $file = $request::file('file');
        if (!$file->isValid()) {
            return responseException('图片文件无效');
        }
        // 存储图片
        $storePath = $this->makeStorePath($data['contract_id']);
        $filename = $this->user->id .'.'. $file->extension();
        $result = $file->storeAs($storePath, $filename, 'uploads');

        $data['thumb'] = '/'. $result;
        $data['userid'] = $this->user->id;

        $where = [
            'contract_id' => $data['contract_id'],
            'userid' => $data['userid']
        ];

        if (!$sign->updateOrCreate($where, $data)) {
            return responseException(__('api.failed'));
        }

        // 更新 contract
        $contract = Contract::find($data['contract_id']);

        if ($contract->userid_first == $this->user->id) {
            $contract->signed_first = 1;
        } else if ($contract->userid_second == $this->user->id) {
            $contract->signed_second = 1;
        } else if ($contract->userid_three == $this->user->id) {
            $contract->signed_three = 1;
        }

        // 参与方都签了名 直接修改状态
        if ($contract->catid == $contract::CAT_DOUBLE) {
            if ($contract->signed_first && $contract->signed_second) {
                $contract->status = $contract::STATUS_SIGN;
            }
        } else if ($contract->catid == $contract::CAT_THREE) {
            if ($contract->signed_first && $contract->signed_second && $contract->signed_three) {
                $contract->status = $contract::STATUS_SIGN;
            }
        }

        $contract->save();

        // 触发usersign事件
        event(new UserSign($contract, $this->user));

        return responseMessage(__('api.success'));
    }

    /**
     * 更新
     * @param \Request $request
     * @param Sign $sign
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\Request $request, Sign $sign)
    {
        if (!$request::hasFile('file')) {
            return responseException('请选择文件上传');
        }
        $file = $request::file('file');
        if (!$file->isValid()) {
            return responseException('图片文件无效');
        }
        // 存储图片
        $storePath = $this->makeStorePath($sign->contract_id);
        $filename = $this->user->id .'.'. $file->extension();
        $result = $file->storeAs($storePath, $filename, 'uploads');

        $data['thumb'] = '/'. $result;

        if (!$sign->update($data)) {
            return responseException(__('api.failed'));
        }
        return responseMessage(__('api.success'));
    }

    /**
     * 删除
     * @param Sign $sign
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Sign $sign)
    {
        if (!$sign->delete()) {
            return responseException(__('web.failed'));
        }
        return responseMessage(__('api.failed'));
    }
}