<?php
/**
 * Note: ContractTplFill模型观察者
 * User: Liu
 * Date: 2019/5/17
 * Time: 22:53
 */
namespace App\Observers;
use App\Models\ContractTplFill;

class ContractTplFillObserver
{

    /**
     * @param ContractTplFill $data
     */
    public function created(ContractTplFill $data)
    {
        $data->formname = pinyin_permalink($data->content, '');
        $data->save();
    }

    /**
     * @param ContractTplFill $data
     */
    //public function updated(ContractTplFill $data)
    //{
    //
    //}

    /**
     * @param ContractTplFill $data
     */
    //public function deleted(ContractTplFill $data)
    //{
    //
    //}
}