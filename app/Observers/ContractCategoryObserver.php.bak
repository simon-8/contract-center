<?php
/**
 * Note: 合同分类
 * User: Liu
 * Date: 2019/6/21
 * Time: 21:15
 */
namespace App\Observers;

use App\Models\ContractCategory AS Model;
use App\Models\EsignEviBusiness;
use App\Services\EsignSceneEviService;
use Illuminate\Support\Facades\Log;

class ContractCategoryObserver
{

    /**
     * 分类创建完成后
     * 1. 查找唯一行业
     * 2. 创建场景
     * 3. 创建证据点名称
     * 4. 创建证据点字段属性
     * @param Model $model
     */
    public function created(Model $model)
    {
        $eviService = new EsignSceneEviService();
        $eviService->categoryCreated($model);
    }

    /**
     *
     * @param Model $model
     */
    public function updated(Model $model)
    {
        // 名称变更
        if ($model->getOriginal('name') !== $model->name) {
            $eviService = new EsignSceneEviService();
            $eviService->categoryCreated($model);
        }
    }

    /**
     * 删除关联数据
     * @param Model $model
     */
    //public function deleted(Model $model)
    //{
    //    // 关联内容
    //    $data->content()->delete();
    //    // 关联文件
    //    $data->file()->delete();
    //}
}
