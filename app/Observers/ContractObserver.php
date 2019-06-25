<?php
/**
 * Note: 合同
 * User: Liu
 * Date: 2019/6/21
 * Time: 21:15
 */
namespace App\Observers;

use App\Models\Contract;

class ContractObserver
{
    /**
     * 删除关联数据
     * @param Contract $data
     */
    public function deleted(Contract $data)
    {
        // 关联内容
        $data->content()->delete();
        // 关联文件
        $data->file()->delete();
    }
}