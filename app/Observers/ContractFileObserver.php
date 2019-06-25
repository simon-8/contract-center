<?php
/**
 * Note: 资料
 * User: Liu
 * Date: 2019/6/21
 * Time: 21:15
 */
namespace App\Observers;

use App\Models\ContractFile;

class ContractFileObserver
{
    /**
     * 删除文件
     * @param ContractFile $data
     */
    public function deleted(ContractFile $data)
    {
        // todo
    }
}