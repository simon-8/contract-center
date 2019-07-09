<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/13
 * Time: 23:36
 */
namespace App\Http\Controllers\Api;

use App\Http\Resources\ContractFile AS ContractFileResource;
use App\Models\ContractFile;
use \DB;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Storage;

class ContractFileController extends BaseController
{
    /**
     * 权限检查
     * @param ContractFile $contractFile
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAuth($contractFile)
    {
        if (!$this->user) {
            return responseException(__('api.no_auth'));
        }
        if ($contractFile->userid !== $this->user->id) {
            return responseException(__('api.no_auth'));
        }
    }

    /**
     * 列表
     * @param \Request $request
     * @param ContractFile $contractFile
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(\Request $request, ContractFile $contractFile)
    {
        if ($this->user === null) {
            return responseMessage('');
        }

        $data = $request::all();
        $lists = $contractFile->ofUserid($this->user->id)
            ->ofContractId($data['contract_id'] ?? 0)
            ->get();
        return ContractFileResource::collection($lists);
    }

    /**
     * 详情
     * @param ContractFile $contractFile
     * @return ContractFileResource
     */
    public function show(ContractFile $contractFile)
    {
        $this->checkAuth($contractFile);

        return responseMessage('', new ContractFileResource($contractFile));
    }

    /**
     * 创建
     * @param \Request $request
     * @param ContractFile $contractFile
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(\Request $request, ContractFile $contractFile)
    {
        if (!$this->user) {
            throw new AuthenticationException();
        }
        $data = $request::all();
        if (!$request::hasFile('file')) {
            return responseException('请选择文件上传');
        }
        $file = $request::file('file');
        if (!$file->isValid()) {
            return responseException('图片文件无效');
        }
        $data['linkurl'] = $file->store('/images/'.date('Ym/d'), 'uploads');
        $data['filetype'] = $file->extension();
        $data['filesize'] = $file->getSize();
        $data['userid'] = $this->user->id;

        $tmp = $contractFile->create($data);
        if (!$tmp) {
            return responseException(__('api.failed'));
        }

        return responseMessage('', new ContractFileResource($tmp));
    }

    /**
     * 更新 todo 暂时无用
     * @param \Request $request
     * @param ContractFile $contractFile
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(\Request $request, ContractFile $contractFile)
    {
        $this->checkAuth($contractFile);

        $data = $request::all();

        if (!$contractFile->update($data)) {
            return responseException(__('api.failed'));
        }

        return responseMessage();
    }


    /**
     * 删除
     * @param ContractFile $contractFile
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(ContractFile $contractFile)
    {
        $this->checkAuth($contractFile);

        if (!$contractFile->delete()) {
            return responseException(__('web.failed'));
        }

        Storage::disk('uploads')->delete($contractFile->linkurl);
        return responseMessage();
    }
}