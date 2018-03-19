<?php
/**
 * Note: 设置管理
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\Setting;

class SettingRepository
{
    protected $model;

    protected static $pageSize = 15;

    public function __construct()
    {
        $this->model = new Setting();
    }

    /**
     * @return array
     */
    public function lists()
    {
        return $this->model->all()->toArray();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * 创建
     * @param $data
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate($data)
    {
        return $this->model->updateOrCreate(['item' => $data['item']] , $data);
    }

    /**
     * 更新
     * @param $data
     * @return bool
     */
    public function updateAll($data)
    {
        foreach ($data as $k => $v) {
            $r = $this->find($k);
            if (!$r) {
                continue;
            } else {
                //$r->name = $v['name'];
                $r->value = $v['value'];
                $r->save();
            }
        }
        return true;
    }

    /**
     * 删除
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}