<?php
/**
 * Note: Role模型观察者
 * User: Liu
 * Date: 2018/5/17
 * Time: 22:53
 */
namespace App\Observers;
use App\Models\Role;

class RoleObserver
{

    /**
     * @param Role $data
     */
    public function created(Role $data)
    {
        if ($data['access']) {
            $data->roleAccess()->attach($data['access']);
        }
    }

    /**
     * @param Role $data
     */
    public function updated(Role $data)
    {
        if ($data['access']) {
            $data->roleAccess()->detach();
            $data->roleAccess()->attach($data['access']);
        }
    }

    /**
     * @param Role $data
     */
    public function deleted(Role $data)
    {
        if ($data['access']) {
            $data->roleAccess()->detach();
        }
    }
}