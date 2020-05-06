<?php
/**
 * Note: 合同
 * User: Liu
 * Date: 2019/6/21
 * Time: 21:15
 */
namespace App\Observers;

use App\Models\CompanyStaff AS Model;

class CompanyStaffObserver
{
    /**
     *
     * @param Model $model
     */
    public function updated(Model $model)
    {
        switch ($model->status) {
            case Model::STATUS_SUCCESS:
                $model->company->increment('staff_count');
                break;
            case Model::STATUS_CANCEL:
                $model->company->decrement('staff_count');
                break;
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
