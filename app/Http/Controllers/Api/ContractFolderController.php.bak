<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/13
 * Time: 23:36
 */
namespace App\Http\Controllers\Api;

use App\Http\Resources\ContractFolder AS ContractFolderResource;
use App\Models\ContractFolder;
use \DB;

class ContractFolderController extends BaseController
{
    /**
     * 权限检查
     * @param ContractFolder $contractFolder
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAuth($contractFolder)
    {
        if (!$this->user) {
            return responseException(__('api.no_auth'));
        }
        if ($contractFolder->userid !== $this->user->id) {
            return responseException(__('api.no_auth'));
        }
    }

    /**
     * 列表
     * @param \Request $request
     * @param ContractFolder $contractFolder
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(\Request $request, ContractFolder $contractFolder)
    {
        if ($this->user === null) {
            return responseMessage('');
        }

        //$data = $request::all();
        $lists = $contractFolder->ofUserid($this->user->id)
            ->paginate();
        return ContractFolderResource::collection($lists);
    }

    /**
     * 详情
     * @param ContractFolder $contractFolder
     * @return ContractFolderResource
     */
    public function show(ContractFolder $contractFolder)
    {
        $this->checkAuth($contractFolder);

        return responseMessage('', new ContractFolderResource($contractFolder));
    }

    /**
     * 创建
     * @param \Request $request
     * @param ContractFolder $contractFolder
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(\Request $request, ContractFolder $contractFolder)
    {
        $data = $request::all();

        if (!$contractFolder->create($data)) {
            return responseException(__('api.failed'));
        }

        return responseMessage();
    }

    /**
     * 更新
     * @param \Request $request
     * @param ContractFolder $contractFolder
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(\Request $request, ContractFolder $contractFolder)
    {
        $this->checkAuth($contractFolder);

        $data = $request::all();

        if (!$contractFolder->update($data)) {
            return responseException(__('api.failed'));
        }

        return responseMessage();
    }


    /**
     * 删除
     * @param ContractFolder $contractFolder
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(ContractFolder $contractFolder)
    {
        $this->checkAuth($contractFolder);

        if (!$contractFolder->delete()) {
            return responseException(__('web.failed'));
        }
        return responseMessage();
    }
}