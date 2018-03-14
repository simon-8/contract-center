<?php
/**
 * Note: 广告位
 * User: Liu
 * Date: 2018/3/14
 * Time: 22:59
 */
namespace App\Repositories;
use App\Models\Ad;
use App\Models\AdPlace;

class AdRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new AdPlace();
    }

    /**
     * 广告位数量少 直接返回全部集合
     * @return \Illuminate\Support\Collection
     */
    public function lists()
    {
        return $this->model->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * 新增
     * @param $data
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * 更新
     * @param $data
     * @return bool
     */
    public function update($data)
    {
        $adPlace = $this->model->find($data['id']);
        return $adPlace->update($data);
    }

    /**
     * 删除
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        $adPlace = $this->model->find($id);
        \Log::debug($adPlace->ad);
        $child = $adPlace->ad;
        if (count($child)) {
            return false;
        }
        return $this->model->destroy($id);
    }
}