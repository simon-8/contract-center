<?php
/**
 * Note: 合同
 * User: Liu
 * Date: 2019/6/21
 * Time: 21:15
 */
namespace App\Observers;

use App\Models\Contract as Model;

class ContractObserver
{
    public function updated(Model $model)
    {
        switch ($model->status) {
            case Model::STATUS_SIGN:
                    if ($model->companyid_first) $model->companyFirst->increment('contract_success_count');
                    if ($model->companyid_second) $model->companySecond->increment('contract_success_count');
                    if ($model->companyid_three) $model->companyThree->increment('contract_success_count');
                break;
            //case Model::STATUS_CONFIRM:
            //
            //    break;
            default:
                break;
        }
    }

    /**
     * 删除关联数据
     * @param Model $model
     */
    public function deleted(Model $model)
    {
        // 关联内容
        $model->content()->delete();
        // 关联文件
        $model->file()->delete();
    }
}
