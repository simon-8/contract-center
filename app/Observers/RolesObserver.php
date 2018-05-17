<?php
/**
 * Note: Roles模型观察者
 * User: Liu
 * Date: 2018/5/17
 * Time: 22:53
 */
namespace App\Observers;
use App\Models\Roles;

class RolesObserver
{

    /**
     * @param Roles $data
     */
    public function created(Roles $data)
    {
        if ($data['access']) {
            $data->getAccess()->attach($data['access']);
        }
    }

    /**
     * @param Roles $data
     */
    public function updated(Roles $data)
    {
        if ($data['access']) {
            $data->getAccess()->detach();
            $data->getAccess()->attach($data['access']);
        }
    }

    /**
     * @param Roles $data
     */
    public function deleted(Roles $data)
    {
        if ($data['access']) {
            $data->getAccess()->detach();
        }
    }
}