<?php
/**
 * Note: Manager模型观察者
 * User: Liu
 * Date: 2018/5/17
 * Time: 22:53
 */
namespace App\Observers;
use App\Models\Manager;

class ManagerObserver
{

    /**
     * @param Manager $data
     */
    public function created(Manager $data)
    {
        if ($data['role']) {
            $data->getRoles()->attach($data['role']);
        }
    }

    /**
     * @param Manager $data
     */
    public function updated(Manager $data)
    {
        if ($data['role']) {
            $data->getRoles()->detach();
            $data->getRoles()->attach($data['role']);
        }
    }

    /**
     * @param Manager $data
     */
    public function deleted(Manager $data)
    {
        if ($data['role']) {
            $data->getRoles()->detach();
        }
    }
}